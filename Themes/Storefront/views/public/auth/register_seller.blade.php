@extends('public.layout')

@section('title', trans('user::auth.register'))

@section('content')
<div class="register-wrapper clearfix" id="register">
    <div class="col-lg-6 col-md-7 col-sm-10">
        <div class="row">
            @include('public.partials.notification')

            <form method="POST" action="{{ route('register.post') }}">
                {{ csrf_field() }}

                <div class="box-wrapper register-form">
                    <div class="box-header">
                        <h4>{{ trans('user::auth.seller_registration') }}</h4>
                    </div>
                    <div class="form-inner clearfix">
                      
                        <div class="col-md-12">
                            <div class="form-group {{ $errors->has('first_name') ? 'has-error': '' }}">
                                <label for="first-name">{{ trans('user::auth.account_type') }}<span>*</span></label>

                                <div class="radio">
                                    <input type="radio" name="register_type" value="local_merchant" id="local_merchant"
                                        v-model='register_type'>
                                    <label for="local_merchant" style="margin-right: 30px">{{ trans('user::auth.local_merchant') }}</label>

                                    <input type="radio" name="register_type" value="international_merchant"
                                        v-model='register_type' id="international_merchant">
                                    <label
                                        for="international_merchant">{{ trans('user::auth.international_merchant') }}</label>
                                </div>

                                {!! $errors->first('register_type', '<span class="error-message">:message</span>') !!}
                            </div>

                            <div class="form-group {{ $errors->has('first_name') ? 'has-error': '' }}">
                                <label for="first-name">{{ trans('user::auth.first_name') }}<span>*</span></label>

                                <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control"
                                    id="first-name">

                                {!! $errors->first('first_name', '<span class="error-message">:message</span>') !!}
                            </div>

                            <div class="form-group {{ $errors->has('last_name') ? 'has-error': '' }}">
                                <label for="last-name">{{ trans('user::auth.last_name') }}<span>*</span></label>

                                <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control"
                                    id="last-name">

                                {!! $errors->first('last_name', '<span class="error-message">:message</span>') !!}
                            </div>

                            <div class="form-group {{ $errors->has('email') ? 'has-error': '' }}">
                                <label for="email">{{ trans('user::auth.email') }}<span>*</span></label>

                                <input type="text" name="email" value="{{ old('email') }}" class="form-control"
                                    id="email">

                                {!! $errors->first('email', '<span class="error-message">:message</span>') !!}
                            </div>

                            <div class="form-group {{ $errors->has('company_name') ? 'has-error': '' }}"
                                v-if="register_type != 'customer_b2c'">
                                <label for="company-name">{{ trans('user::auth.company_name') }}<span>*</span></label>

                                <input type="text" name="company_name" class="form-control" id="company_name"
                                    value="{{ old('company_name') }}">

                                {!! $errors->first('company_name', '<span class="error-message">:message</span>') !!}
                            </div>

                            <div class="form-group {{ $errors->has('position') ? 'has-error': '' }}"
                                v-if="register_type != 'customer_b2c'">
                                <label for="position">{{ trans('user::auth.position') }}<span>*</span></label>

                                <input type="text" name="position" class="form-control" id="position"
                                    value="{{ old('position') }}">

                                {!! $errors->first('position', '<span class="
                                    error-message">:message</span>')
                                !!}
                            </div>

                            <div class="form-group {{ $errors->has('password') ? 'has-error': '' }}">
                                <label for="password">{{ trans('user::auth.password') }}<span>*</span></label>

                                <input type="password" name="password" class="form-control" id="password">

                                {!! $errors->first('password', '<span class="error-message">:message</span>') !!}
                            </div>

                            <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error': '' }}">
                                <label
                                    for="confirm-password">{{ trans('user::auth.password_confirmation') }}<span>*</span></label>

                                <input type="password" name="password_confirmation" class="form-control"
                                    id="confirm-password">

                                {!! $errors->first('password_confirmation', '<span
                                    class="error-message">:message</span>') !!}
                            </div>


                            <div class="form-group {{ $errors->has('captcha') ? 'has-error': '' }}">
                                @captcha
                                <input type="text" name="captcha" id="captcha" class="captcha-input">

                                {!! $errors->first('captcha', '<span class="error-message">:message</span>') !!}
                            </div>

                        </div>

                        <div class="clearfix"></div>

                        <div class="checkbox">
                            <input type="checkbox" name="privacy_policy" id="privacy">

                            <label for="privacy">
                                {{ trans('user::auth.i_agree_to_the') }} <a
                                    href="{{ $privacyPageURL }}">{{ trans('user::auth.privacy_policy') }}</a>
                            </label>

                            {!! $errors->first('privacy_policy', '<span class="error-message">:message</span>') !!}
                        </div>

                        <button type="submit" class="btn btn-primary btn-register pull-right" data-loading>
                            {{ trans('user::auth.register') }}
                        </button>
                    </div>
                </div>
            </form>
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
        el: '#register',
        data: {
            register_type : "{{old('register_type')}}"
        },
        mounted() {
         
        },
        methods: {
          
        }
    })
</script>
@endsection