@extends('public.layout')

@section('title', $page->name)

@push('meta')
    <meta name="title" content="{{ $page->meta->meta_title }}">
    <meta name="keywords" content="{{ implode(',', $page->meta->meta_keywords) }}">
    <meta name="description" content="{{ $page->meta->meta_description }}">
    <meta property="og:title" content="{{ $page->meta->meta_title }}">
    <meta property="og:description" content="{{ $page->meta->meta_description }}">
@endpush

@section('breadcrumb')
    <li><a href="{{ route('news') }}">{{trans('page::pages.news')}}</a></li>
    <li class="active">{{ $page->name }}</li>
@endsection

@section('content')
    <div class="page-wrapper clearfix">
        <div class=" col-lg-12" style="margin-bottom : 60px">
        <img  style="max-height: 350px; max-width: 100%; margin-bottom : 30px" src="{{$page->base_image->path}}"  />
            <h4  style="color: #626060;">{{$page->name}}</h2>
            <h6 style="color: silver;"> {{trans('page::pages.news')}},  {{ $page->created_at->toFormattedDateString() }},  {{$page->admin->full_name}}  </h6>
            <hr  style="margin-top : 5px"/>
                {!! $page->body !!}
        </div>
    </div>
@endsection
