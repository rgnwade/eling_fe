<?php

namespace Modules\Company\Admin;

use Modules\Admin\Ui\Tab;
use Modules\Admin\Ui\Tabs;
use Modules\Company\Entities\Company;
use Modules\Company\Entities\Country;

class CompanyTabs extends Tabs
{
    public function make()
    {
        $this->group('company_information', trans('company::company.tabs.group.company_information'))
            ->active()
            ->add($this->users())
            ->add($this->general())
            ->add($this->images())
            ->add($this->fta())
            ->add($this->info())
            ->add($this->bank())
            ;
    }

    public function general()
    {
        return tap(new Tab('general', trans('company::company.tabs.general')), function (Tab $tab) {
            $tab->active();
            $tab->weight(1);
            $tab->fields([
                'name',
                'address',
                'phone',
                'email',
                'country',
                'director_name',
                'director_passport',
                'is_seller',
                'is_buyer',
                'is_active',
            ]);

            $tab->view('company::admin.companies.tabs.general', [
                'countries' => Country::list(),
                'country_list' => Country::get(),
            ]);
        });
    }

    private function images()
    {
        if (! auth()->user()->hasAccess('admin.media.index')) {
            return;
        }

        return tap(new Tab('images', trans('company::company.tabs.images')), function (Tab $tab) {
            $tab->weight(2);
            $tab->view('company::admin.companies.tabs.images');
        });
    }

    private function fta()
    {
        return tap(new Tab('fta', trans('company::company.tabs.documents')), function (Tab $tab) {
            $tab->weight(3);
            $tab->fields([
                'fta_status',
                'fta_number',
                'attachment',
                'npwp',
                'nib',
                'sppkp',
                'pajak',
                'akta'
            ]);

            $tab->view('company::admin.companies.tabs.fta');
        });
    }

    private function info()
    {
        return tap(new Tab('info', trans('company::company.tabs.info')), function (Tab $tab) {
            $tab->weight(4);
            $tab->view('company::admin.companies.tabs.info');
        });
    }

    private function bank()
    {
        return tap(new Tab('bank', trans('company::company.tabs.bank')), function (Tab $tab) {
            $tab->weight(5) ;
            $tab->fields([
                'beneficiary_bank',
                'beneficiary_name',
                'beneficiary_account',
                'swift_code',
                'bank_address',
            ]);
            $tab->view('company::admin.companies.tabs.bank');
        });
    }

    public function users()
    {
        return tap(new Tab('users', trans('company::company.tabs.users')), function (Tab $tab) {
            $tab->weight(6);
            $tab->view('company::admin.companies.tabs.users');
        });
    }

}
