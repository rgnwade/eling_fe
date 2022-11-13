@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('admin::resource.edit', ['resource' => trans('company::company.company')]))
    @slot('subtitle', $company->name)

    <li><a href="{{ route('admin.companies.index') }}">{{ trans('company::company.companies') }}</a></li>
    <li class="active">{{ trans('admin::resource.edit', ['resource' => trans('company::company.company')]) }}</li>
@endcomponent

@section('content')
    @if ($errors->any())
        {!! implode('', $errors->all('<div class="alert alert-danger" role="alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
        :message
        </div>')) !!}
    @endif
    <form method="POST" action="{{ route('admin.companies.update', $company) }}" class="form-horizontal" id="company-edit-form" novalidate>
        {{ csrf_field() }}
        {{ method_field('put') }}

        {!! $tabs->render(compact('company', 'company_info', 'documents', 'docs')) !!}
    </form>
@endsection

@include('company::admin.companies.partials.scripts')
