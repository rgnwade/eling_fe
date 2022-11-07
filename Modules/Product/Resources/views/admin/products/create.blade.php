@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('admin::resource.create', ['resource' => trans('product::products.product')]))

    <li><a href="{{ route('admin.products.index') }}">{{ trans('product::products.products') }}</a></li>
    <li class="active">{{ trans('admin::resource.create', ['resource' => trans('product::products.product')]) }}</li>
@endcomponent

@section('content')
    @if ($errors->any())
        {!! implode('', $errors->all('<div class="alert alert-danger" role="alert">
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
        :message
        </div>')) !!}
    @endif
    <form method="POST" action="{{ route('admin.products.store') }}" class="form-horizontal" id="product-create-form" novalidate>
        {{ csrf_field() }}

        {!! $tabs->render(compact('product')) !!}
    </form>
@endsection

@include('product::admin.products.partials.shortcuts')
