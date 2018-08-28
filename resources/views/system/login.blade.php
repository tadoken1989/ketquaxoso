@extends('system.layouts.app')
@section('content')
    <div class="login-box">
        <div class="login-logo">
            <a href="{{ route('admin.index') }}"><b>{{ __('system.title_login') }}</b>CP</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Sign in to start your session</p>

            <form action="{{ route('login') }}" role="form" method="POST">
                {{ csrf_field() }}
                <div class="form-group has-feedback">
                    <input id="log" type="text" placeholder="@lang('Login')" class="form-control" name="log" value="{{ old('log') }}" required autofocus />
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                @if ($errors->has('log'))
                    <span class="help-block">
                            <strong>{{ $errors->first('log') }}</strong>
                        </span>
                @endif
                <div class="form-group has-feedback">
                    <input id="password" type="password" class="form-control" name="password" required
                           placeholder="Password"/>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
                <div class="row">
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
@endsection