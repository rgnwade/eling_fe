@extends('public.layout')

@section('title',  trans('page::pages.news'))



@section('content')

    @foreach($pages as $page)

    <div class=" col-lg-12" style="margin-bottom : 60px">
        <h4> <a  style="color: #626060;" href="{{ route('news.show', $page->slug) }}"> {{$page->name}} </a></h4>
        <h6 style="color: silver;"> {{trans('page::pages.news')}},  {{ $page->created_at->toFormattedDateString() }},  {{$page->admin->full_name}}  </h6>
        <hr  style="margin-top : 5px"/>

        <div class="col-lg-5">
            <a href="{{ route('news.show', $page->slug) }}"> <img  style="max-height: 250px; max-width: 100%;" src="{{$page->base_image->path}}"  /> </a>
        </div>

        <div class="col-lg-7">
            {!! substr($page->body, 0, 700) !!}
            <a href="{{ route('news.show', $page->slug) }}"> {{ trans('page::pages.read_more')}} </a>
        </div>
    </div>

    @endforeach

     <div class="pull-right">
                    {{ $pages->links() }}
                </div>
@endsection
