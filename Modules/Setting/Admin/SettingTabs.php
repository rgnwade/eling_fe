<?php

namespace Modules\Setting\Admin;

use Modules\Admin\Ui\Tab;
use Modules\Admin\Ui\Tabs;
use Modules\Support\Locale;
use Modules\Support\Country;
use Modules\Support\TimeZone;
use Modules\Currency\Currency;
use Modules\User\Entities\Role;

class SettingTabs extends Tabs
{
    /**
     * Make new tabs with groups.
     *
     * @return void
     */
    public function make()
    {
        $this->group('general_settings', trans('setting::settings.tabs.group.general_settings'))
            ->active()
            ->add($this->general())
            ->add($this->maintenance())
            ->add($this->store())
            // ->add($this->currency())
            ->add($this->mail())
            ->add($this->customCssJs());

        $this->group('social_logins', trans('setting::settings.tabs.group.social_logins'))
            ->add($this->facebook())
            ->add($this->google());

        // $this->group('shipping_methods', trans('setting::settings.tabs.group.shipping_methods'))
        //     ->add($this->freeShipping())
        //     ->add($this->localPickup())
        //     ->add($this->flatRate());

        $this->group('payment_methods', trans('setting::settings.tabs.group.payment_methods'))
            ->add($this->midtrans())
            // ->add($this->paypalExpress())
            // ->add($this->stripe())
            // ->add($this->instamojo())
            // ->add($this->cod())
            ->add($this->bankTransfer());
            // ->add($this->checkPayment());
    }

    private function general()
    {
        return tap(new Tab('general', trans('setting::settings.tabs.general')), function (Tab $tab) {
            $tab->active();
            $tab->weight(5);

            $tab->fields([
                'supported_countries.*',
                'default_country',
                'supported_locales.*',
                'default_locale',
                'default_timezone',
                'customer_role',
            ]);

            $tab->view('setting::admin.settings.tabs.general', [
                'locales' => Locale::all(),
                'countries' => Country::all(),
                'timeZones' => TimeZone::all(),
                'roles' => Role::list(),
            ]);
        });
    }

    private function maintenance()
    {
        return tap(new Tab('maintenance', trans('setting::settings.tabs.maintenance')), function (Tab $tab) {
            $tab->weight(7);
            $tab->view('setting::admin.settings.tabs.maintenance');
        });
    }

    private function store()
    {
        return tap(new Tab('store', trans('setting::settings.tabs.store')), function (Tab $tab) {
            $tab->weight(10);

            $tab->fields([
                'translatable.store_name',
                'translatable.store_tagline',
                'store_phone',
                'whatsapp',
                'store_email',
                'notif_receiving_emails',
                'store_address_1',
                'store_address_2',
                'store_city',
                'store_country',
                'store_state',
                'store_zip',
            ]);

            $tab->view('setting::admin.settings.tabs.store', [
                'countries' => Country::all(),
            ]);
        });
    }

    private function currency()
    {
        return tap(new Tab('currency', trans('setting::settings.tabs.currency')), function (Tab $tab) {
            $tab->weight(20);

            $tab->fields([
                'supported_currencies.*',
                'default_currency',
                'currency_rate_exchange_service',
                'fixer_access_key',
                'forge_api_key',
                'currency_data_feed_api_key',
                'auto_refresh_currency_rates',
                'auto_refresh_currency_rate_frequency',
            ]);

            $tab->view('setting::admin.settings.tabs.currency', [
                'currencies' => Currency::names(),
                'currencyRateExchangeServices' => $this->getCurrencyRateExchangeServices(),
            ]);
        });
    }

    private function mail()
    {
        return tap(new Tab('mail', trans('setting::settings.tabs.mail')), function (Tab $tab) {
            $tab->weight(30);
            $tab->fields(['mail_from_address']);
            $tab->view('setting::admin.settings.tabs.mail', [
                'encryptionProtocols' => $this->getMailEncryptionProtocols(),
            ]);
        });
    }

    private function getMailEncryptionProtocols()
    {
        return ['' => trans('admin::admin.form.please_select')] + trans('setting::settings.form.mail_encryption_protocols');
    }

    private function customCssJs()
    {
        return tap(new Tab('custom_css_js', trans('setting::settings.tabs.custom_css_js')), function (Tab $tab) {
            $tab->weight(35);
            $tab->view('setting::admin.settings.tabs.custom_css_js');
        });
    }

    private function getCurrencyRateExchangeServices()
    {
        $currencyRateExchangeServices = ['' => trans('setting::settings.form.select_service')];

        return $currencyRateExchangeServices += trans('currency::services');
    }

    private function facebook()
    {
        return tap(new Tab('facebook', trans('setting::settings.tabs.facebook')), function (Tab $tab) {
            $tab->weight(38);

            $tab->fields([
                'facebook_login_enabled',
                'translatable.facebook_login_label',
                'facebook_login_app_id',
                'facebook_login_app_secret',
            ]);

            $tab->view('setting::admin.settings.tabs.facebook');
        });
    }

    private function google()
    {
        return tap(new Tab('google', trans('setting::settings.tabs.google')), function (Tab $tab) {
            $tab->weight(39);

            $tab->fields([
                'google_login_enabled',
                'translatable.google_login_label',
                'google_login_client_id',
                'google_login_client_secret',
            ]);

            $tab->view('setting::admin.settings.tabs.google');
        });
    }

    private function freeShipping()
    {
        return tap(new Tab('free_shipping', trans('setting::settings.tabs.free_shipping')), function (Tab $tab) {
            $tab->weight(40);
            $tab->fields(['free_shipping_enabled', 'translatable.free_shipping_label']);
            $tab->view('setting::admin.settings.tabs.free_shipping');
        });
    }

    private function localPickup()
    {
        return tap(new Tab('local_pickup', trans('setting::settings.tabs.local_pickup')), function (Tab $tab) {
            $tab->weight(45);
            $tab->fields(['local_pickup_enabled', 'translatable.local_pickup_label']);
            $tab->view('setting::admin.settings.tabs.local_pickup');
        });
    }

    private function flatRate()
    {
        return tap(new Tab('flat_rate', trans('setting::settings.tabs.flat_rate')), function (Tab $tab) {
            $tab->weight(50);

            $tab->fields([
                'flat_rate_enabled',
                'translatable.flat_rate_label',
                'flat_rate_cost',
            ]);

            $tab->view('setting::admin.settings.tabs.flat_rate');
        });
    }

    private function paypalExpress()
    {
        return tap(new Tab('paypal_express', trans('setting::settings.tabs.paypal_express')), function (Tab $tab) {
            $tab->weight(55);

            $tab->fields([
                'paypal_express_enabled',
                'translatable.paypal_express_label',
                'translatable.paypal_express_description',
                'paypal_express_env',
                'paypal_express_username',
                'paypal_express_password',
                'paypal_express_signature',
            ]);

            $tab->view('setting::admin.settings.tabs.paypal_express');
        });
    }

    private function stripe()
    {
        return tap(new Tab('stripe', trans('setting::settings.tabs.stripe')), function (Tab $tab) {
            $tab->weight(60);

            $tab->fields([
                'stripe_enabled',
                'translatable.stripe_label',
                'translatable.stripe_description',
                'stripe_publishable_key',
                'stripe_secret_key',
            ]);

            $tab->view('setting::admin.settings.tabs.stripe');
        });
    }

     private function midtrans()
    {
        return tap(new Tab('midtrans', trans('setting::settings.tabs.midtrans')), function (Tab $tab) {
            $tab->weight(62);

            $tab->fields([
                'midtrans_enabled',
                'midtrans_label',
                'midtrans_description'
            ]);

            $tab->view('setting::admin.settings.tabs.midtrans');
        });
    }

    private function instamojo()
    {
        return tap(new Tab('instamojo', trans('setting::settings.tabs.instamojo')), function (Tab $tab) {
            $tab->weight(62);

            $tab->fields([
                'instamojo_enabled',
                'instamojo_label',
                'instamojo_description',
                'instamojo_test_mode',
                'instamojo_api_key',
                'instamojo_auth_token',
            ]);

            $tab->view('setting::admin.settings.tabs.instamojo');
        });
    }

    private function cod()
    {
        return tap(new Tab('cod', trans('setting::settings.tabs.cod')), function (Tab $tab) {
            $tab->weight(65);

            $tab->fields([
                'cod_enabled',
                'translatable.cod_label',
                'translatable.cod_description',
            ]);

            $tab->view('setting::admin.settings.tabs.cod');
        });
    }

    private function bankTransfer()
    {
        return tap(new Tab('bank_transfer', trans('setting::settings.tabs.bank_transfer')), function (Tab $tab) {
            $tab->weight(70);

            $tab->fields([
                'bank_transfer_enabled',
                'translatable.bank_transfer_label',
                'translatable.bank_transfer_description',
                'translatable.bank_transfer_instructions',
            ]);

            $tab->view('setting::admin.settings.tabs.bank_transfer');
        });
    }

    private function checkPayment()
    {
        return tap(new Tab('check_payment', trans('setting::settings.tabs.check_payment')), function (Tab $tab) {
            $tab->weight(75);

            $tab->fields([
                'check_payment_enabled',
                'translatable.check_payment_label',
                'translatable.check_payment_description',
                'translatable.check_payment_instructions',
            ]);

            $tab->view('setting::admin.settings.tabs.check_payment');
        });
    }
}
