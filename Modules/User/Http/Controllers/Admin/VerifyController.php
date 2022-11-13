<?php

namespace Modules\User\Http\Controllers\Admin;

use Modules\User\Entities\User;
use Illuminate\Routing\Controller;
use Modules\Admin\Traits\HasCrudActions;
use Illuminate\Http\Request;
use Modules\Admin\Ui\Facades\TabManager;
use Modules\Company\Entities\BankAccount;
use Modules\Company\Entities\Company;
use Modules\Company\Entities\Country;
use Modules\User\Entities\Role;

class VerifyController extends Controller
{
    use HasCrudActions;

    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $viewPath = 'user::admin.verify';


    public function index(Request $request)
    {
        if ($request->has('query')) {
            return $this->getModel()
                ->search($request->get('query'))
                ->query()
                ->limit($request->get('limit', 10))
                ->get();
        }

        if ($request->has('table')) {
            return $this->getModel()->tableVerify($request);
        }

        return view("{$this->viewPath}.index");
    }

    public function edit($id)
    {

        $user = User::find($id);
        $company = $user->company ?: new Company();
        $bank = $company->bankAccount ?: new BankAccount();
        $informations = $company->companyInfo;
        if ($user->isCustomerType()) {
            $documents =  $this->getCompanyDocuments($company, $informations, Company::CUSTOMER_DOC);
        } else if ($user->isLocalMerchantType()) {
            $documents =  $this->getCompanyDocuments($company, $informations, Company::LOCAL_MERCHANT_DOC);
        } else if ($user->isIntMerchantType()) {
            $documents =  $this->getCompanyDocuments($company, $informations, Company::INT_MERCHANT_DOC);
        } 
        else if ($user->isCustomerB2CType()) {
            $documents =  $this->getUserDocuments($user, $user->informations, ['ktp']);
        }else {
            $documents = [];
        }
        $socials = $this->getCompanyInfo($informations, Company::SOCIALS);

        $data = array_merge([
            'user' => $user,
            'company' => $company,
            'socials' => $socials,
            'country' => Country::find($company->country_id),
            'documents' => $documents,
            'bank' => $bank,
        ], $this->getFormData('edit', $id));

        return view("{$this->viewPath}.edit", $data);
    }


    public function update($id)
    {
        //hardcoded seller role
        $seller_role_id = 4;

        $user = User::find($id);
        if ($user->isCustomerType() || $user->isCustomerB2CType() ) {
            $user->roles()->sync([setting('customer_role')]);
        } else {
            $user->roles()->sync([$seller_role_id]);
        }
        $user->update(['status' => User::VERIFIED]);

        return redirect()->back()
            ->withSuccess(trans(
                'admin::messages.resource_verified',
                ['resource' => 'User']
            ));
    }
    private function getCompanyInfo($informations, $keys)
    {
        $documents = [];
        foreach ($keys as $key) {
            foreach ($informations as $info) {
                if ($key == $info->title) {
                    $documents[] = $info;
                    break;
                }
            }
        }
        return $documents;
    }

    private function getCompanyDocuments($company, $informations, $keys)
    {
        $documents = [];
        foreach ($keys as $key) {
            foreach ($informations as $info) {
                if ($key == $info->title) {
                    $file = $company->getAttachment($key);
                    $documents[] = [
                        'path' => $file->path,
                        'thumb' => $file->thumb,
                        'filename' => $file->filename,
                        'ext' => $file->extension,
                        'title' => $info->title,
                        'value' => $info->value,
                    ];
                    break;
                }
            }
        }
        return $documents;
    }

    private function getUserDocuments($user, $informations, $keys)
    {
        $documents = [];
        foreach ($keys as $key) {
            foreach ($informations as $info) {
                if ($key == $info->title) {
                    $file = $user->getAttachment($key);
                    $documents[] = [
                        'path' => $file->path,
                        'thumb' => $file->thumb,
                        'filename' => $file->filename,
                        'ext' => $file->extension,
                        'title' => $info->title,
                        'value' => $info->value,
                    ];
                    break;
                }
            }
        }
        return $documents;
    }
}
