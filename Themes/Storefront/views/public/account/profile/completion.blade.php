@extends('public.account.layout')

@section('title', trans('storefront::account.links.complete_registration'))

@section('account_breadcrumb')
<li class="active">{{ trans('storefront::account.links.complete_registration') }}</li>
@endsection

@section('content_right')
<div id="complete-registration">
    <div class="alert alert-warning" role="alert" v-if="user.status=='on_verification'">
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
        {{ trans('account::messages.notification.onverification') }}
    </div>

    <input type="hidden" value="{{ url('/') }}" id="url" />

    <div class="form-horizontal">

        <div class="account-details">
            <div class="account clearfix">
                <h4>{{ trans('storefront::account.completion.company') }}</h4>

                <div class="row">
                    <div class="col-sm-12">
                        <div v-bind:class="{'form-group':true, 'has-error':(errors['company.name'])}">
                            <label for="name" class="control-label col-sm-2">
                                {{ trans('storefront::account.completion.name') }}<span>*</span>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" name="name" id="name" v-model='company.name' class="form-control">
                                <span class="error-message"
                                    v-if="errors['company.name']">@{{ errors['company.name'][0] }}</span>
                            </div>

                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div v-bind:class="{'form-group':true, 'has-error':(errors['company.address'])}">
                            <label for="address" class="control-label col-sm-2">
                                {{ trans('storefront::account.completion.address') }}<span>*</span>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" name="address" id="address" v-model='company.address'
                                    class="form-control">
                                <span class="error-message"
                                    v-if="errors['company.address']">@{{ errors['company.address'][0] }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div v-bind:class="{'form-group':true, 'has-error':(errors['company.email'])}">
                            <label for="email" class="control-label col-sm-2">
                                {{ trans('storefront::account.completion.email') }}<span>*</span>
                            </label>
                            <div class="col-sm-10">
                                <input type="text" name="email" id="email" v-model='company.email' class="form-control">
                                <span class="error-message"
                                    v-if="errors['company.email']">@{{ errors['company.email'][0] }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12" v-if="user.register_type==='international_merchant'">
                        <div v-bind:class="{'form-group':true, 'has-error':(errors['company.phone'])}">
                            <label for="country_id" class="control-label col-sm-2">
                                {{trans('company::attributes.country')}}<span class="m-l-5 text-red">*</span>
                            </label>

                            <div class="col-sm-10">
                                <select name="country_id" id="country_id" class="form-control custom-select-black"
                                    v-model='selected_country'>
                                    <option value="">Select Country</option>
                                    <option v-for="country in countries" v-bind:value="country" :key="country.id">
                                        @{{ country.name }}
                                    </option>
                                </select>
                            </div>
                            <span class="error-message"
                                v-if="errors['company.country_id']">@{{ errors['company.phone'][0] }}</span>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div v-bind:class="{'form-group':true, 'has-error':(errors['company.phone'])}">
                            <label for="phone" class="control-label col-sm-2">
                                {{ trans('storefront::account.completion.phone') }}<span>*</span>
                            </label>
                            <div class="col-sm-10">

                                <div class="row">
                                    <div class="col-lg-2 " style="padding-right: 1px"><input name="phonecode"
                                            id="phonecode" type="text" class="form-control " readonly=""
                                            v-model='selected_country.phonecode'></div>
                                    <div class="col-lg-10" style="padding-left: 1px"><input name="phone" id="phone"
                                            type="text" class="form-control " placeholder="Phone Number"
                                            v-model='company.phone'>
                                    </div>
                                </div>

                                <span class="error-message"
                                    v-if="errors['company.phone']">@{{ errors['company.phone'][0] }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12" v-if="user.register_type==='local_merchant'">
                        <div v-bind:class="{'form-group':true, 'has-error':(errors['company.is_tax_active'])}">
                            <label for="country_id" class="control-label col-sm-2">
                                {{trans('company::attributes.is_tax_active')}}<span class="m-l-5 text-red">*</span>
                            </label>

                            <div class="col-sm-10" style="    padding-top: 10px; ">
                                
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="tax_status" id="tax_status"  v-model='company.is_tax_active'>
                                    <label class="form-check-label" for="tax_status">{{trans('company::company.form.enable_tax')}}</label>
                              
                            </div>
                            <span class="error-message"
                                v-if="errors['company.is_tax_active']">@{{ errors['company.is_tax_active'][0] }}</span>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            <button @click='saveCompany()' id='save-company-button' class="btn btn-primary pull-right"
                                data-loading>
                                {{ trans('storefront::account.profile.save_changes') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="account-details" v-if="user.company_id">
            <div class="account clearfix" v-if="user.register_type != 'customer'">
                <h4>{{ trans('storefront::account.completion.detail') }}</h4>

                <div class="col-sm-12" v-if="user.register_type=='international_merchant'">
                    <div v-bind:class="{'form-group':true, 'has-error':(errors['company.fta_status'])}">
                        <label for="fta_status" class="control-label col-sm-3">
                            {{ trans('company::attributes.fta_status') }}<span>*</span>
                        </label>
                        <div class="col-sm-9">
                            <select name="fta_status" id="fta_status" v-model='company.fta_status'>
                                <option value="0">NON FTA</option>
                                <option value="1">FTA</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12" v-if="user.register_type=='international_merchant'">
                    <div v-bind:class="{'form-group':true, 'has-error':(errors['company.fta_number'])}">
                        <label for="fta_number" class="control-label col-sm-3">
                            {{ trans('company::attributes.fta_number') }}
                        </label>
                        <div class="col-sm-9">
                            <input type="text" name="fta_number" id="fta_number" v-model='company.fta_number'
                                class="form-control">
                            <span class="error-message"
                                v-if="errors['company.fta_number']">@{{ errors['company.fta_number'][0] }}</span>

                            <div v-if="files.other_file.id" id='attachment'>
                                Attachment: <a target="blank"
                                    :href='files.other_file.path'>@{{ files.other_file.filename }}</a>
                                <button @click='deleteFile(files.other_file.id)' class="btn-close-coupon"
                                    data-toggle="tooltip" data-placement="left" title="Remove">
                                    &times;
                                </button>
                                <img :src="files.other_file.thumb" width=200px style="display: block"
                                    v-if="files.other_file.extension != 'pdf'">
                            </div>
                            <div v-else>
                                <label for="other_file">Upload Documents</label>
                                <input type="file" id="other_file" accept=".png,.jpg,.jpeg,.pdf" name="other_file"
                                    @change="selectFile" />
                            </div>
                            <span class="error-message"
                                v-if="errors['files.other_file']">@{{ errors['files.other_file'][0] }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div v-bind:class="{'form-group':true, 'has-error':(errors['company.director_name'])}">
                        <label for="director_name" class="control-label col-sm-3">
                            {{ trans('storefront::account.completion.director_name') }}<span>*</span>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" name="director_name" id="director_name" v-model='company.director_name'
                                class="form-control">
                            <span class="error-message"
                                v-if="errors['company.director_name']">@{{ errors['company.director_name'][0] }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div v-bind:class="{'form-group':true, 'has-error':(errors['company.director_passport'])}">
                        <label for="director_passport" class="control-label col-sm-3"
                            v-if="user.register_type=='international_merchant'">
                            {{ trans('storefront::account.completion.director_passport') }}<span>*</span>
                        </label>
                        <label for="director_passport" class="control-label col-sm-3" v-else>
                            {{ trans('storefront::account.completion.director_nik') }}<span>*</span>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" name="director_passport" id="director_passport"
                                v-model='company.director_passport' class="form-control">
                            <span class="error-message"
                                v-if="errors['company.director_passport']">@{{ errors['company.director_passport'][0] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="account-details" v-if="user.company_id">
            <div class="account clearfix" v-if="user.register_type != 'customer'">
                <h4>{{ trans('storefront::account.completion.bank_account') }}</h4>

                <div class="col-sm-12">
                    <div v-bind:class="{'form-group':true, 'has-error':(errors['bank_account.beneficiary_bank'])}">
                        <label for="beneficiary_bank" class="control-label col-sm-3">
                            {{ trans('company::attributes.beneficiary_bank') }}<span>*</span>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" name="beneficiary_bank" id="beneficiary_bank"
                                v-model='bank_account.beneficiary_bank' class="form-control">
                            <span class="error-message"
                                v-if="errors['bank_account.beneficiary_bank']">@{{ errors['bank_account.beneficiary_bank'][0] }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div v-bind:class="{'form-group':true, 'has-error':(errors['bank_account.beneficiary_name'])}">
                        <label for="beneficiary_name" class="control-label col-sm-3">
                            {{ trans('company::attributes.beneficiary_name') }}<span>*</span>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" name="beneficiary_name" id="beneficiary_name"
                                v-model='bank_account.beneficiary_name' class="form-control">
                            <span class="error-message"
                                v-if="errors['bank_account.beneficiary_name']">@{{ errors['bank_account.beneficiary_name'][0] }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div v-bind:class="{'form-group':true, 'has-error':(errors['bank_account.bank_address'])}">
                        <label for="bank_address" class="control-label col-sm-3">
                            {{ trans('company::attributes.bank_address') }}<span>*</span>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" name="bank_address" id="bank_address" v-model='bank_account.bank_address'
                                class="form-control">
                            <span class="error-message"
                                v-if="errors['bank_account.bank_address']">@{{ errors['bank_account.bank_address'][0] }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div v-bind:class="{'form-group':true, 'has-error':(errors['bank_account.beneficiary_account'])}">
                        <label for="beneficiary_account" class="control-label col-sm-3">
                            {{ trans('company::attributes.beneficiary_account') }}<span>*</span>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" name="beneficiary_account" id="beneficiary_account"
                                v-model='bank_account.beneficiary_account' class="form-control">
                            <span class="error-message"
                                v-if="errors['bank_account.beneficiary_account']">@{{ errors['bank_account.beneficiary_account'][0] }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div v-bind:class="{'form-group':true, 'has-error':(errors['bank_account.swift_code'])}">
                        <label for="swift_code" class="control-label col-sm-3">
                            {{ trans('company::attributes.swift_code') }}<span>*</span>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" name="swift_code" id="swift_code" v-model='bank_account.swift_code'
                                class="form-control">
                            <span class="error-message"
                                v-if="errors['bank_account.swift_code']">@{{ errors['bank_account.swift_code'][0] }}</span>
                        </div>
                    </div>
                </div>

            </div>

            <div class="account clearfix" v-if="user.register_type != 'customer'">
                <h4>{{ trans('storefront::account.completion.social') }}</h4>

                <div class="col-sm-12">
                    <div v-bind:class="{'form-group':true, 'has-error':(errors['socials.facebook'])}">
                        <label for="facebook" class="control-label col-sm-3">
                            {{ trans('company::attributes.facebook') }}
                        </label>
                        <div class="col-sm-9">
                            <input type="text" name="facebook" id="facebook" v-model='socials.facebook'
                                class="form-control">
                            <span class="error-message"
                                v-if="errors['socials.facebook']">@{{ errors['socials.facebook'][0] }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div v-bind:class="{'form-group':true, 'has-error':(errors['socials.instagram'])}">
                        <label for="instagram" class="control-label col-sm-3">
                            {{ trans('company::attributes.instagram') }}
                        </label>
                        <div class="col-sm-9">
                            <input type="text" name="instagram" id="instagram" v-model='socials.instagram'
                                class="form-control">
                            <span class="error-message"
                                v-if="errors['socials.instagram']">@{{ errors['socials.instagram'][0] }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div v-bind:class="{'form-group':true, 'has-error':(errors['socials.twitter'])}">
                        <label for="twitter" class="control-label col-sm-3">
                            {{ trans('company::attributes.twitter') }}
                        </label>
                        <div class="col-sm-9">
                            <input type="text" name="twitter" id="twitter" v-model='socials.twitter'
                                class="form-control">
                            <span class="error-message"
                                v-if="errors['socials.twitter']">@{{ errors['socials.twitter'][0] }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div v-bind:class="{'form-group':true, 'has-error':(errors['socials.website'])}">
                        <label for="website" class="control-label col-sm-3">
                            {{ trans('company::attributes.website') }}
                        </label>
                        <div class="col-sm-9">
                            <input type="text" name="website" id="website" v-model='socials.website'
                                class="form-control">
                            <span class="error-message"
                                v-if="errors['socials.website']">@{{ errors['socials.website'][0] }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="account clearfix" v-if="user.register_type != 'international_merchant'">
                <h4>{{ trans('storefront::account.completion.documents') }}</h4>

                <div class="col-sm-12" v-if="files.npwp">
                    <div v-bind:class="{'form-group':true, 'has-error':(errors['documents.npwp'])}"
                        :key='files.npwp.id'>
                        <label for="npwp" class="control-label col-sm-3">
                            {{ trans('storefront::account.completion.npwp') }}<span>*</span>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" name="npwp" id="npwp" v-model='documents.npwp' class="form-control">
                            <span class="error-message"
                                v-if="errors['documents.npwp']">@{{ errors['documents.npwp'][0] }}</span>
                            <div v-if="files.npwp.id" id='attachment'>
                                Attachment: <a target="blank" :href='files.npwp.path'>@{{ files.npwp.filename }}</a>
                                <button @click='deleteFile(files.npwp.id)' class="btn-close-coupon"
                                    data-toggle="tooltip" data-placement="left" title="Remove">
                                    &times;
                                </button>
                                <img :src="files.npwp.thumb" width=200px style="display: block"
                                    v-if="files.npwp.extension != 'pdf'">
                            </div>
                            <div v-else>
                                <label for="npwp">Upload Documents</label>
                                <input type="file" id="npwp" accept=".png,.jpg,.jpeg,.pdf" name="npwp"
                                    @change="selectFile" />
                            </div>

                            <span class="error-message"
                                v-if="errors['files.npwp']">@{{ errors['files.npwp'][0] }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12" v-if="files.siup">
                    <div v-bind:class="{'form-group':true, 'has-error':(errors['documents.siup'])}"
                        :key='files.siup.id'>
                        <label for="siup" class="control-label col-sm-3">
                            {{ trans('storefront::account.completion.siup') }}<span>*</span>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" name="siup" id="siup" v-model='documents.siup' class="form-control">
                            <span class="error-message"
                                v-if="errors['documents.siup']">@{{ errors['documents.siup'][0] }}</span>
                            <div v-if="files.siup.id" id='attachment'>
                                Attachment: <a target="blank" :href='files.siup.path'>@{{ files.siup.filename }}</a>
                                <button @click='deleteFile(files.siup.id)' class="btn-close-coupon"
                                    data-toggle="tooltip" data-placement="left" title="Remove">
                                    &times;
                                </button>
                                <img :src="files.siup.thumb" width=200px style="display: block"
                                    v-if="files.siup.extension != 'pdf'">
                            </div>
                            <div v-else>
                                <label for="siup">Upload Documents</label>
                                <input type="file" id="siup" accept=".png,.jpg,.jpeg,.pdf" name="siup"
                                    @change="selectFile" />
                            </div>

                            <span class="error-message"
                                v-if="errors['files.siup']">@{{ errors['files.siup'][0] }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12" v-if="files.nib">
                    <div v-bind:class="{'form-group':true, 'has-error':(errors['documents.nib'])}" :key='files.nib.id'>
                        <label for="nib" class="control-label col-sm-3">
                            {{ trans('storefront::account.completion.nib') }}<span>*</span>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" name="nib" id="nib" v-model='documents.nib' class="form-control">
                            <span class="error-message"
                                v-if="errors['documents.nib']">@{{ errors['documents.nib'][0] }}</span>
                            <div v-if="files.nib.id" id='attachment'>
                                Attachment: <a target="blank" :href='files.nib.path'>@{{ files.nib.filename }}</a>
                                <button @click='deleteFile(files.nib.id)' class="btn-close-coupon" data-toggle="tooltip"
                                    data-placement="left" title="Remove">
                                    &times;
                                </button>
                                <img :src="files.nib.thumb" width=200px style="display: block"
                                    v-if="files.nib.extension != 'pdf'">
                            </div>
                            <div v-else>
                                <label for="nib">Upload Documents</label>
                                <input type="file" id="nib" accept=".png,.jpg,.jpeg,.pdf" name="nib"
                                    @change="selectFile" />
                            </div>

                            <span class="error-message" v-if="errors['files.nib']">@{{ errors['files.nib'][0] }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12" v-if="files.sppkp && company.is_tax_active == 1">
                    <div v-bind:class="{'form-group':true, 'has-error':(errors['documents.sppkp'])}"
                        :key='files.sppkp.id'>
                        <label for="sppkp" class="control-label col-sm-3">
                            {{ trans('storefront::account.completion.sppkp') }}<span>*</span>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" name="sppkp" id="sppkp" v-model='documents.sppkp' class="form-control">
                            <span class="error-message"
                                v-if="errors['documents.sppkp']">@{{ errors['documents.sppkp'][0] }}</span>
                            <div v-if="files.sppkp.id" id='attachment'>
                                Attachment: <a target="blank" :href='files.sppkp.path'>@{{ files.sppkp.filename }}</a>
                                <button @click='deleteFile(files.sppkp.id)' class="btn-close-coupon"
                                    data-toggle="tooltip" data-placement="left" title="Remove">
                                    &times;
                                </button>
                                <img :src="files.sppkp.thumb" width=200px style="display: block"
                                    v-if="files.sppkp.extension != 'pdf'">
                            </div>
                            <div v-else>
                                <label for="sppkp">Upload Documents</label>
                                <input type="file" id="sppkp" accept=".png,.jpg,.jpeg,.pdf" name="sppkp"
                                    @change="selectFile" />
                            </div>

                            <span class="error-message"
                                v-if="errors['files.sppkp']">@{{ errors['files.sppkp'][0] }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12" v-if="files.pajak && company.is_tax_active == 1">
                    <div v-bind:class="{'form-group':true, 'has-error':(errors['documents.pajak'])}"
                        :key='files.pajak.id'>
                        <label for="pajak" class="control-label col-sm-3">
                            {{ trans('storefront::account.completion.pajak') }}<span>*</span>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" name="pajak" id="pajak" v-model='documents.pajak' class="form-control">
                            <span class="error-message"
                                v-if="errors['documents.pajak']">@{{ errors['documents.pajak'][0] }}</span>
                            <div v-if="files.pajak.id" id='attachment'>
                                Attachment: <a target="blank" :href='files.pajak.path'>@{{ files.pajak.filename }}</a>
                                <button @click='deleteFile(files.pajak.id)' class="btn-close-coupon"
                                    data-toggle="tooltip" data-placement="left" title="Remove">
                                    &times;
                                </button>
                                <img :src="files.pajak.thumb" width=200px style="display: block"
                                    v-if="files.pajak.extension != 'pdf'">
                            </div>
                            <div v-else>
                                <label for="pajak">Upload Documents</label>
                                <input type="file" id="pajak" accept=".png,.jpg,.jpeg,.pdf" name="pajak"
                                    @change="selectFile" />
                            </div>

                            <span class="error-message"
                                v-if="errors['files.pajak']">@{{ errors['files.pajak'][0] }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12" v-if="files.akta">
                    <div v-bind:class="{'form-group':true, 'has-error':(errors['documents.akta'])}"
                        :key='files.akta.id'>
                        <label for="akta" class="control-label col-sm-3">
                            {{ trans('storefront::account.completion.akta') }}<span>*</span>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" name="akta" id="akta" v-model='documents.akta' class="form-control">
                            <span class="error-message"
                                v-if="errors['documents.akta']">@{{ errors['documents.akta'][0] }}</span>
                            <div v-if="files.akta.id" id='attachment'>
                                Attachment: <a target="blank" :href='files.akta.path'>@{{ files.akta.filename }}</a>
                                <button @click='deleteFile(files.akta.id)' class="btn-close-coupon"
                                    data-toggle="tooltip" data-placement="left" title="Remove">
                                    &times;
                                </button>
                                <img :src="files.akta.thumb" width=200px style="display: block"
                                    v-if="files.akta.extension != 'pdf'">
                            </div>
                            <div v-else>
                                <label for="akta">Upload Documents</label>
                                <input type="file" id="akta" accept=".png,.jpg,.jpeg,.pdf" name="akta"
                                    @change="selectFile" />
                            </div>

                            <span class="error-message"
                                v-if="errors['files.akta']">@{{ errors['files.pajak'][0] }}</span>
                        </div>
                    </div>
                </div>


            </div>
        </div>

        <div class="col-sm-12">
            <div class="col-sm-2"></div>
            <div class="col-sm-10">
                <button @click='updateCompany()' id='update-company-button' class="btn btn-primary pull-right"
                    data-loading v-if="user.company_id">
                    {{ trans('storefront::account.profile.save_changes') }}
                </button>
                <button data-toggle="modal" data-target="#post-success" id="button-hidden"
                    style="display: none;"></button>
            </div>
        </div>
    </div>


    <div class="modal fade" id="post-success" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">
                        <i class="fa fa-times" aria-hidden="true" style="font-size: 30px"></i>
                    </button>
                    <h4 class="modal-title">Success Notification</h4>
                </div>
                <div class="form">
                    <div class="modal-body">
                        <div class="clearfix">
                            <div class="comment">
                                <div class="comment-details">
                                    <i aria-hidden="true" class="fa fa-check-circle"
                                        style="font-size: 70px;color: green;"></i>
                                    <h4 class="user-text" v-if="user.register_type=='customer'">{{ trans('account::messages.notification.success') }}
                                    <h4 class="user-text" v-else>{{ trans('account::messages.notification.onverification') }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.6.11/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.15/lodash.min.js"></script>

<script type="text/javascript">
    window.Vue = Vue;
    window.axios = axios;
    window.lodash = _;
    window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    let token = document.head.querySelector('meta[name="csrf-token"]');

    if (token) {
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
    } else {
        // eslint-disable-next-line no-console
        console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
    }

    var app = new Vue({
        el: '#complete-registration',
        data: {
            url: document.getElementById('url').value,
            company: {},
            user: {},
            socials: {},
            documents: [],
            files: {},
            errors: {},
            bank_account: {},
            countries: null,
            selected_country: {},
            docs: {},
        },
        mounted() {
            this.getAccount();
            this.getCountry();
        },
        methods: {
            getAccount: function() {
                axios.get(this.url + '/account/completion/show', {})
                .then(function (response) {
                    app.company = response.data.company;
                    app.user = response.data.user;
                    app.documents = response.data.documents;
                    app.socials = response.data.socials;
                    app.files = response.data.files;
                    app.bank_account = response.data.bank_account;
                    if (response.data.user.company_id === null) {
                        app.company.name = response.data.user.company_name
                    }
                });

            },
            getCountry: function() {
                axios.get(this.url + '/countries', {})
                .then(function (response) {
                    app.countries = response.data;
                    if (app.company.country_id != null){
                        app.selected_country = response.data.find(function (el) {
                            return el.id == app.company.country_id;
                        });
                    } else {
                        app.selected_country = response.data.find(function (el) {
                            return el.iso === 'ID';
                        });
                    }
                });
            },
            getFileOny: function() {
                axios.get(this.url + '/account/completion/show', {})
                .then(function (response) {
                    app.files = response.data.files;
                });
            },
            selectFile(event) {
                console.log(event);
                this.uploadFile(event.target.name, event.target.files[0])
            },
            uploadFile(name, file){
                const data = new FormData();
                data.append('name', name);
                data.append('file', file);

                const split = file.name.split('.');
                const ext = split[split.length-1];
                if (ext.toLowerCase() === 'pdf') {
                    axios.post(this.url + "/mediafile", data)
                    .then(function(response){
                        app.getFileOny();
                    })
                }else{
                    axios.post(this.url + "/media", data)
                    .then(function(response){
                        app.getFileOny();
                    })
                }
            },
            deleteFile(id){
                axios.delete(this.url + "/media/" + id)
                .then(function(response){
                    app.docs[name] = {id: response.data.id, preview: response.data.path}
                    app.getFileOny();
                })
            },
            saveCompany: function() {
                this.setCountry();
                axios({
                    method: 'post',
                    url: this.url + '/account/completion',
                    data: {company: { type: this.user.register_type, ...this.company}}
                }).then(function (response) {
                    app.errors={}
                    app.getAccount();
                    app.stopLoading("save-company-button");
                })
                .catch(error => {
                    if (error.response) {
                    console.log(error.response);
                        app.errors=error.response.data.errors;
                        app.stopLoading("save-company-button");
                    }
                });
            },
            updateCompany: function() {
                this.setCountry();
                this.setAttachment();
                const data = {
                    company: this.company,
                    bank_account: this.bank_account,
                    socials: this.socials,
                    documents: this.documents,
                    files: this.docs,
                    register_type: this.user.register_type,
                    is_tax_active: this.company.is_tax_active
                }
                axios({
                    method: 'put',
                    url: this.url + '/account/completion/' + this.user.company_id,
                    data: data
                }).then(function (response) {
                    app.errors={};
                    app.stopLoading("update-company-button");
                    app.getAccount();
                    document.getElementById("button-hidden").click()
                })
                .catch(error => {
                    if (error.response) {
                    console.log(error.response);
                        app.errors=error.response.data.errors;
                        app.stopLoading("update-company-button");
                    }
                });
            },
            stopLoading(id){
                setTimeout(() => {
                        var submitButton = document.getElementById(id);
                        submitButton.classList.remove('btn-loading');
                        submitButton.classList.remove('disabled');
                        submitButton.removeAttribute('disabled');
                    }, 500);
            },
            setCountry(){
                this.company.country_id = this.selected_country.id;
            },
            setAttachment() {
                for (var key in this.files) {
                    if (this.files.hasOwnProperty(key)) {
                        this.docs[key] = this.files[key].id;
                    }
                }
            }
        }
    })
</script>
@endsection
