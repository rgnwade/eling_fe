<?php

namespace Modules\Account\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Company\Entities\Company;
use Modules\Company\Entities\Country;
use Modules\Company\Transformers\CompanyResource;
use Modules\User\Transformers\UserResource;
use Modules\Account\Http\Requests\InitCompletionRequest;
use Modules\Account\Http\Requests\UserCompletionRequest;
use Modules\Account\Http\Requests\UpdateCompletionRequest;
use Modules\Company\Entities\BankAccount;
use Modules\Company\Entities\CompanyInfo;
use Modules\Company\Transformers\BankAccountResource;
use Modules\Media\Transformers\MediaResource;
use Modules\User\Entities\User;
use Modules\User\Entities\UserInfo;

class AccountCompletionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $my = auth()->user();
        if ($my->isCustomerB2CType()) {
            return view('public.account.profile.completion_b2c', compact('my'));
        }
        $company = $my->company ?: Company::find(1);
        $country_list = Country::get();
        return view('public.account.profile.completion', compact('my', 'company', 'country_list'));
    }

    public function show()
    {
        $user = auth()->user();
        $company = $user->company ?: new Company();
        $bank = $company->bankAccount ?: new BankAccount();
        $informations = $company->companyInfo;
        if ($user->isCustomerType()) {
            $documents =  $this->getCompanyInfo($informations, Company::CUSTOMER_DOC);
            $attachments = $this->getCompanyAttachment($company, Company::CUSTOMER_DOC);
        } else if ($user->isLocalMerchantType()) {
            $documents =  $this->getCompanyInfo($informations, Company::LOCAL_MERCHANT_DOC);
            $attachments = $this->getCompanyAttachment($company, Company::LOCAL_MERCHANT_DOC);
        } else if ($user->isIntMerchantType()) {
            $documents =  $this->getCompanyInfo($informations, Company::INT_MERCHANT_DOC);
            $attachments = $this->getCompanyAttachment($company, Company::INT_MERCHANT_DOC);
        } else if ($user->isCustomerB2CType()) {
            $documents =  $this->getUserInfo($user->informations, ['ktp']);
            $attachments = $this->getUserAttachment($user, ['ktp']);
        } else {
            $documents = [];
            $attachments = [];
        }
        $socials = $this->getCompanyInfo($informations, Company::SOCIALS);

        return [
            'user' => new UserResource($user),
            'company' => new CompanyResource($company),
            'bank_account' => new BankAccountResource($bank),
            'documents' => $documents,
            'socials' => $socials,
            'files' => $attachments
        ];
    }

    public function saveUser(UserCompletionRequest $request)
    {
        $user = auth()->user();
        $documents =  $request->get('documents');

        UserInfo::updateOrCreate(
            [
                'user_id' => (int) $user->id,
                'title' => 'ktp'
            ],
            [
                'value' => $documents['ktp'],
            ],
        );

        $user->update(
            [
                'status' => User::ON_VERIFICATION,
                'company_id' => 0 //no corporation
            ],
        );

        return ['success' => true];
    }

    public function save(InitCompletionRequest $request)
    {
        $user = auth()->user();
        $params = $request->get('company');
         
        if ($user->isLocalMerchantType() ) {
            $request->validate([
                'company.is_tax_active' => 'required'
            ]);
        }
        if ($user->company_id) {
            $user->company->update($params);
        } else {
            $company = Company::create(array_merge($params, $this->initCompany($user)));
            $user->update(['company_id' => $company->id]);
        }

        return ['success' => true];
    }

    public function update(UpdateCompletionRequest $request, $id)
    {
        $user = auth()->user();
        $company = Company::find($id);

        $company->update($request->get('company'));

        BankAccount::updateOrCreate(
            ['company_id' => $company->id],
            $request->get('bank_account')
        );

        $socials = $this->companyInfoParams($request->get('socials'));
        $documents = $this->companyInfoParams($request->get('documents'));
        $company_info = array_merge($socials, $documents);
        foreach ($company_info as $info) {
            CompanyInfo::updateOrCreate(
                ['company_id' => $company->id, 'title' => $info->title],
                ['company_id' => $company->id, 'value' => $info->value]
            );
        }
        $user->update(['status' => User::ON_VERIFICATION]);
        return ["success" => true];
    }

    private function initCompany(User $user)
    {
        if ($user->isCustomerType()) {
            $status = ['is_seller' => 0, 'is_buyer' => 1];
        } else {
            $status = ['is_seller' => 1, 'is_buyer' => 0];
        }
        $status['is_active'] = 1;
        $status['director_name'] = '';
        $status['director_passport'] = '';
        $status['fta_status'] = 0;
        return $status;
    }

    private function getCompanyInfo($company_infos, $keys)
    {
        $documents = [];
        foreach ($keys as $key) {
            $document = null;
            foreach ($company_infos as $ci) {
                if ($key == $ci->title) {
                    $document = $ci;
                    $documents[$key] = $ci->value;
                    break;
                }
            }
            if ($document == null) {
                $documents[$key] = '';
            }
        }
        return $documents;
    }

    private function getUserInfo($user_infos, $keys)
    {
        $documents = [];
        foreach ($keys as $key) {
            $document = null;
            foreach ($user_infos as $ci) {
                if ($key == $ci->title) {
                    $document = $ci;
                    $documents[$key] = $ci->value;
                    break;
                }
            }
            if ($document == null) {
                $documents[$key] = '';
            }
        }
        return $documents;
    }

    private function getCompanyAttachment($company, $keys)
    {
        $attachments = [];
        foreach ($keys as $key) {
            $file = $company->getAttachment($key);
            $attachments[$key] = new MediaResource($file);
        }
        return $attachments;
    }

    private function getUserAttachment($user, $keys)
    {
        $attachments = [];
        foreach ($keys as $key) {
            $file = $user->getAttachment($key);
            $attachments[$key] = new MediaResource($file);
        }
        return $attachments;
    }


    private function companyInfoParams($informations)
    {
        $infos = [];
        if ($informations != null) {
            foreach ($informations as $key => $value) {
                $infos[] = new CompanyInfo(
                    [
                        'title' => $key,
                        'value' => $value ?: ''
                    ]
                );
            }
        }
        return $infos;
    }
}
