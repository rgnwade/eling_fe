@extends('admin::layout')

@section('title', trans('vendor::resource.enable', ['resource' => trans('user::users.google2fa')]))

@section('content')
  <div class="container">
        @if ($errors->any())
            {!! implode('', $errors->all('<div class="alert alert-danger" role="alert">:message</div>')) !!}
        @endif

    <form method="POST" action="{{ route('vendor.google2fa.post') }}" class="form-horizontal" id="profile-form" novalidate>
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{trans('vendor::resource.enable', ['resource' => trans('user::users.google2fa')])}}</div>
                    <div class="panel-body">
                    @if(empty($currentUser->google2fa_secret))
                        <div class="row">
                            <div class="form-group  col-lg-4 ">
                                <div>
                                    <img src="{{$qr}}">
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <p>{{trans('user::users.google2fa_text')}} {{$secret}}</p>
                                <input type="hidden" value="{{$secret}}" name="google2fa_secret">


                            <div class="form-group row col-lg-12">
                                    <input type="text" name="secret"  class="form-control  " placeholder="{{ trans('user::users.google2fa_place_holder') }}" autofocus>
                            </div>
                            <div class="form-group row col-lg-6">
                                    <button type="submit" class="btn btn-primary" data-loading>
                                    {{trans('vendor::resource.enable', ['resource' => trans('user::users.google2fa')])}}
                                </button>

                            </div>
                        </div>
                    </div>
                    @else
                        {{trans('user::users.google2fa_text_not_empty')}}
                    @endif

                </div>
            </div>
        </div>
    </form>
</div>
@endsection
