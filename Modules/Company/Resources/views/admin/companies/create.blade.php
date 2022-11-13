@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('admin::resource.create', ['resource' => trans('company::company.company')]))

    <li><a href="{{ route('admin.companies.index') }}">{{ trans('company::company.companies') }}</a></li>
    <li class="active">{{ trans('admin::resource.create', ['resource' => trans('company::company.company')]) }}</li>
@endcomponent

@section('content')
    @if ($errors->any())
        {!! implode('', $errors->all('<div class="alert alert-danger" role="alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
        :message
        </div>')) !!}
    @endif
    <form method="POST" action="{{ route('admin.companies.store') }}" class="form-horizontal" id="Company-create-form" novalidate>
        {{ csrf_field() }}

        {!! $tabs->render(compact('company', 'company_info')) !!}
    </form>
@endsection

@include('company::admin.companies.partials.scripts')
