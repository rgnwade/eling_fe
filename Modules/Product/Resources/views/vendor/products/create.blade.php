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
    <div class="accordion-content clearfix">
        <div class= "accordion-box-content col-lg-12 col-md-6">
            <div class="tab-content clearfix">
                <h3 class="tab-content-title">{{trans('product::products.product_information')}}</h3>
                <form method="POST" action="{{ route('vendor.products.store') }}" class="form-vertical" id="product-create-form" validate>
                    {{ csrf_field() }}
                    <div class= "col-lg-6 col-md-6 ">
                        {{ Form::textVertical('name', trans('product::vendor.name'), $errors, $product, [ 'required' => true, 'placeholder' => trans('product::vendor.name')]) }}
                    </div>
                     <div class= "col-lg-6 col-md-6 ">
                        {{ Form::selectVertical('categories', trans('product::attributes.categories'), $errors, $categories, $product, ['class' => 'selectize prevent-creation', 'multiple' => true]) }}
                    </div>
                    <div class= "col-lg-3 col-md-3 ">
                        {{ Form::numberVertical('vendor_price', trans('product::vendor.price'), $errors, $product, [ 'required' => true, 'placeholder' => trans('product::vendor.price')]) }}
                    </div>

                    <div class= "col-lg-3 col-md-3 ">
                        {{ Form::selectVertical('vendor_currency', trans('product::vendor.currency'), $errors, ['USD' => 'USD', 'IDR' => 'IDR'], $product) }}
                    </div>
                    <div class= "col-lg-3 col-md-3">
                        {{ Form::numberVertical('minimum_order', trans('product::vendor.minimum_order'), $errors, $product, [ 'required' => true, 'placeholder' => trans('product::vendor.minimum_order')]) }}
                    </div>


                    <div class= "col-lg-3 col-md-3 ">
                        {{ Form::selectVertical('stock_product_status_id', trans('product::vendor.stock_status'), $errors, $stock_status, $product) }}
                    </div>
                    <div class= "col-lg-3 col-md-3">
                        {{ Form::numberVertical('weight', trans('product::vendor.weight'), $errors, $product, [ 'required' => true, 'placeholder' => trans('product::vendor.weight')]) }}
                    </div>
                    <div class= "col-lg-3 col-md-3">
                        {{ Form::numberVertical('length', trans('product::vendor.length'), $errors, $product, [ 'required' => true, 'placeholder' => trans('product::vendor.length')]) }}
                    </div>
                    <div class= "col-lg-3 col-md-3">
                        {{ Form::numberVertical('height', trans('product::vendor.height'), $errors, $product, [ 'required' => true, 'placeholder' => trans('product::vendor.height')]) }}
                    </div>
                    <div class= "col-lg-3 col-md-3">
                        {{ Form::numberVertical('width', trans('product::vendor.width'), $errors, $product, [ 'required' => true, 'placeholder' => trans('product::vendor.width')]) }}
                    </div>
                    <?php
                        $format_intruction = '<p class="displaynone"> *please fill in following the format below <p>';
                        $format_intruction .= '<table width="100%">';
                        $format_intruction .= '<tr class="displaynone">
                                                    <td>Specification Title</td>
                                                    <td>Specification Value</td>
                                                </tr>';
                        for( $i = 0; $i<10; $i++ ) {
                            $format_intruction .= '<tr>
                                                    <td width="30%"></td>
                                                    <td width="70%"></td>
                                                </tr>';
                        }
                        $format_intruction .= '</table>';
                    ?>
                    <div id="product-attributes-wrapper" class= "col-lg-12 col-md-12">
                        <div class="media-picker-divider"></div>
                        <label control-label="">Atrributes</label>
                        <div class="table-responsive">
                            <table class="options table table-bordered">
                                <thead class="hidden-xs">
                                    <tr>
                                        <th></th>
                                        <th>{{ trans('attribute::admin.form.product.attribute') }}</th>
                                        <th>{{ trans('attribute::admin.form.product.values') }}</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="product-attributes">
                                    {{-- Product attributes will be added here dynamically using JS --}}
                                </tbody>
                            </table>
                        </div>
                        <button type="button" class="btn btn-default" id="add-new-attribute">
                            {{ trans('attribute::admin.form.product.add_new_attribute') }}
                        </button>
                    </div>

                    <div class= "col-lg-12 col-md-12">
                        {{ Form::wysiwygVertical('description', trans('product::vendor.description'), $errors, $product, [ 'required' => true]) }}
                        {{ Form::wysiwygVertical('specification', trans('product::vendor.specification'), $errors, $product, [ 'required' => true, 'format_intruction' => $format_intruction]) }}

                        @include('media::vendor.image_picker.single', [
                            'title' => trans('product::products.form.base_image'),
                            'inputName' => 'files[base_image]',
                            'file' => $product->baseImage,
                        ])

                        <div class="media-picker-divider"></div>
                            @include('media::vendor.image_picker.multiple', [
                                'title' => trans('product::products.form.additional_images'),
                                'inputName' => 'files[additional_images][]',
                                'files' => $product->additionalImages,
                            ])
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" value="Submit" class="btn btn-primary mr-auto">  {{ trans('admin::admin.buttons.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@include('attribute::admin.products.tabs.templates.attribute')
@push('globals')
    <script>
        FleetCart.data['product.attributes'] = '';
        FleetCart.errors['product.attributes'] = @json($errors->get('attributes.*'), JSON_FORCE_OBJECT);
    </script>
@endpush
@endsection

@include('product::vendor.products.partials.shortcuts')
