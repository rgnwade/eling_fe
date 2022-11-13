<?php

namespace Modules\Company\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Modules\Company\Entities\Company;
use Modules\Company\Entities\CompanyInfo;
use Modules\Company\Entities\BankAccount;
use Modules\Admin\Traits\HasCrudActions;
use Modules\Company\Http\Requests\SaveCompanyRequest;
use Modules\Admin\Ui\Facades\TabManager;

class CompanyController extends Controller
{
    use HasCrudActions;

    /**
     * Model for the resource.
     *
     * @var string
     */
    protected $model = Company::class;

    /**
     * Label of the resource.
     *
     * @var string
     */
    protected $label = 'company::company.company';

    /**
     * View path of the resource.
     *
     * @var string
     */
    protected $viewPath = 'company::admin.companies';

    /**
     * Form requests for the resource.
     *
     * @var array|string
     */
    protected $validation = SaveCompanyRequest::class;

    const COMPANY_INFOS = ['profile', 'instagram', 'twitter', 'facebook', 'website'];

    public function create()
    {
        $data = array_merge([
            'tabs' => TabManager::get($this->getModel()->getTable()),
            'company_info' => [],
            $this->getResourceName() => $this->getModel(),
        ], $this->getFormData('create'));

        return view("{$this->viewPath}.create", $data);
    }

    public function store()
    {
        $this->disableSearchSyncing();

        $entity = $this->getModel()->create(
            $this->getRequest('store')->all()
        );

        $bank = new BankAccount($this->bankAccountParams($this->getRequest('store')));
        $entity->bankAccount()->save($bank);
        $company_info = $this->companyInfoParams($this->getRequest('store'), SELF::COMPANY_INFOS);
        $entity->companyInfo()->saveMany($company_info);

        $this->createLog($entity, 'create', $this->getRequest('store'));

        $this->searchable($entity);

        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo($entity);
        }

        return redirect()->route("{$this->getRoutePrefix()}.index")
            ->withSuccess(trans('admin::messages.resource_saved', ['resource' => $this->getLabel()]));
    }

    public function edit($id)
    {
        $company = $this->getEntity($id);

        $companyInfo = array();
        $documents = array();
        $docs =array();

        foreach (SELF::COMPANY_INFOS as $info) {
            $companyInfo[$info] = $company->getInfo($info)->value;
        }

        if ($company->isLocalMerchantType()){
            $docs = Company::LOCAL_MERCHANT_DOC;
            foreach ($docs as $doc) {
                $documents[$doc] = $company->getInfo($doc)->value;
            }
        }elseif($company->isCustomerType()) {
            $docs = Company::CUSTOMER_DOC;
            foreach ($docs as $doc) {
                $documents[$doc] = $company->getInfo($doc)->value;
            }
        }

        $data = array_merge([
            $this->getResourceName() => $company,
            'tabs' => TabManager::get($this->getModel()->getTable()),
            'company_info' => $companyInfo,
            'documents' => $documents,
            'docs' => $docs
        ], $this->getFormData('edit', $id));

        return view("{$this->viewPath}.edit", $data);
    }

    public function update($id)
    {
        $entity = $this->getEntity($id);

        $this->disableSearchSyncing();

        $entity->update(
            $this->getRequest('update')->all()
        );

        BankAccount::updateOrCreate(
            ['company_id' => $entity->id],
            $this->bankAccountParams($this->getRequest('update'))
        );

        $company_info = $this->companyInfoParams($this->getRequest('update'), SELF::COMPANY_INFOS);
        if ($entity->isLocalMerchantType()) {
            $documents =  $this->companyInfoParams($this->getRequest('update'), Company::LOCAL_MERCHANT_DOC);
            $company_info = array_merge($company_info, $documents);
        }
        foreach ($company_info as $info) {
            CompanyInfo::updateOrCreate(
                ['company_id' => $entity->id, 'title' => $info->title],
                ['company_id' => $entity->id, 'value' => $info->value]
            );
        }

        $this->createLog($entity, 'edit', $this->getRequest('update'));

        $this->searchable($entity);

        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo($entity)
                ->withSuccess(trans('admin::messages.resource_saved', ['resource' => $this->getLabel()]));
        }

        return redirect()->back()
            ->withSuccess(trans('admin::messages.resource_saved', ['resource' => $this->getLabel()]));
    }


    private function bankAccountParams($request)
    {
        return [
            'beneficiary_bank' => $request->beneficiary_bank,
            'beneficiary_name' => $request->beneficiary_name,
            'beneficiary_account' => $request->beneficiary_account,
            'swift_code' => $request->swift_code,
            'bank_address' => $request->bank_address
        ];
    }

    private function companyInfoParams($request, $informations)
    {
        $infos = [];
        foreach ($informations as $info) {
            if ($request->$info != null || $request->$info != '') {
                $infos[] = new CompanyInfo([
                    'title' => $info,
                    'value' => $request->$info
                ]);
            }
        }
        return $infos;
    }
}
