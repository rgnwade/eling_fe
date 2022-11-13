<div class="row">
    <div class="col-md-8">
        {{ Form::text('first_name', trans('user::attributes.users.first_name'), $errors, $user, ['required' => true]) }}
        {{ Form::text('last_name', trans('user::attributes.users.last_name'), $errors, $user, ['required' => true]) }}
        {{ Form::email('email', trans('user::attributes.users.email'), $errors, $user, ['required' => true]) }}
        {{ Form::text('position', trans('user::attributes.users.position'), $errors, $user, ['required' => true]) }}
        {{ Form::select('roles', trans('user::attributes.users.roles'), $errors, $roles, $user, ['multiple' => true, 'required' => true, 'class' => 'selectize prevent-creation']) }}

        @if (request()->routeIs('admin.users.create'))
            {{ Form::password('password', trans('user::attributes.users.password'), $errors, null, ['required' => true]) }}
            {{ Form::password('password_confirmation', trans('user::attributes.users.password_confirmation'), $errors, null, ['required' => true]) }}
             <div class="form-group ">
                <label class="col-md-3"></label>
                <div class="col-md-9" style="font-size : 10px">
                     {{ trans('core::validation.regex_password')}}
                 </div>
            </div>
        @endif

        {{ Form::select('company_id', trans('user::attributes.users.company'), $errors, $companies, $user, ['required' => true], trans('user::users.form.select_company')) }}

        @if (request()->routeIs('admin.users.edit'))
            {{ Form::checkbox('activated', trans('user::attributes.users.activated'), trans('user::users.form.activated'), $errors, $user, [ 'checked' => old('activated', $user->isActivated())]) }}
        @endif

        {{ Form::checkbox('chat_admin', '', trans('user::attributes.users.chat_admin'), $errors, $user) }}
    </div>
</div>
