@extends('admin::layout')

@section('title', trans('admin::resource.enable', ['resource' => trans('user::users.google2fa')]))


@section('content')
  <div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{trans('user::users.google2fa')}}</div>
​
                <div class="panel-body">
                    @if(Auth::user()->isAdmin())
                        <form class="form-horizontal" method="POST" action="{{ route('2fa') }}">
                    @else
                        <form class="form-horizontal" method="POST" action="{{ route('vendor.2fa') }}">
                    @endif
                        {{ csrf_field() }}
​
                        <div class="form-group">
                            <label for="one_time_password" class="col-md-4 control-label">{{trans('user::users.one_time_password')}}</label>
​
                            <div class="col-md-6">
                                <input id="one_time_password" type="number" class="form-control" name="one_time_password" required autofocus>
                            </div>
                        </div>
​
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
