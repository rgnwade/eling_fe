@extends('public.account.layout')

@section('title', trans('storefront::account.links.complete_registration'))

@section('account_breadcrumb')
<li class="active">{{ trans('storefront::account.links.complete_registration') }}</li>
@endsection

@section('content_right')
<div id="complete-registration">

    <input type="hidden" value="{{ url('/') }}" id="url" />

    <div class="form-horizontal">
        <div class="account-details">
            <div class="account clearfix">
                <h4>{{ trans('storefront::account.completion.documents') }}</h4>
                <div class="col-sm-12" v-if="files.ktp">
                    <div v-bind:class="{'form-group':true, 'has-error':(errors['documents.ktp'])}" :key='files.ktp.id'>
                        <label for="ktp" class="control-label col-sm-3">
                            {{ trans('storefront::account.completion.ktp') }}<span>*</span>
                        </label>
                        <div class="col-sm-9">
                            <input type="text" name="ktp" id="ktp" v-model='documents.ktp' class="form-control">
                            <span class="error-message"
                                v-if="errors['documents.ktp']">@{{ errors['documents.ktp'][0] }}</span>
                            <div v-if="files.ktp.id" id='attachment'>
                                Attachment: <a target="blank" :href='files.ktp.path'>@{{ files.ktp.filename }}</a>
                                <button @click='deleteFile(files.ktp.id)' class="btn-close-coupon" data-toggle="tooltip"
                                    data-placement="left" title="Remove">
                                    &times;
                                </button>
                                <img :src="files.ktp.thumb" width=200px style="display: block"
                                    v-if="files.ktp.extension != 'pdf'">
                            </div>
                            <div v-else>
                                <label for="ktp">Upload Documents</label>
                                <input type="file" id="ktp" accept=".png,.jpg,.jpeg,.pdf" name="ktp"
                                    @change="selectFile" />
                            </div>

                            <span class="error-message" v-if="errors['files.ktp']">@{{ errors['files.ktp'][0] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="col-sm-2"></div>
            <div class="col-sm-10">
                <button @click='updateUserInfo()' id='update-user-button' class="btn btn-primary pull-right"
                    data-loading>
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
                                    <h4 class="user-text" >
                                        {{ trans('account::messages.notification.success') }}
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
            docs: {}
        },
        mounted() {
            this.getAccount();
            this.getCountry();
        },
        methods: {
            getAccount: function() {
                axios.get(this.url + '/account/completion/show', {})
                .then(function (response) {
    
                    app.user = response.data.user;
                    app.documents = response.data.documents;
     
                    app.files = response.data.files;
                 
                    
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
            updateUserInfo: function() {
                this.setCountry();
                this.setAttachment();
                const data = {
                    documents: this.documents,
                    files: this.docs,
                }
                axios({
                    method: 'post',
                    url: this.url + '/account/completion_user/',
                    data: data
                }).then(function (response) {
                    app.errors={};
                    app.stopLoading("update-user-button");
                    app.getAccount();
                    document.getElementById("button-hidden").click()
                })
                .catch(error => {
                    if (error.response) {
                    console.log(error.response);
                        app.errors=error.response.data.errors;
                        app.stopLoading("update-user-button");
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