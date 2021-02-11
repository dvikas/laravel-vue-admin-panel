@extends('layouts.app')

@section('content')
    <div style="margin-top:100px;">

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
        @if ($errors->has('email'))
            <div class="alert alert-danger">
                {{ $errors->first('email') }}
            </div>
        @endif

        @if ($errors->has('password'))
            <div class="alert alert-danger">
                {{ $errors->first('password') }}
            </div>
        @endif

        @if ($errors->has('password_confirmation'))
            <div class="alert alert-danger">
                {{ $errors->first('password_confirmation') }}
            </div>
        @endif
        <p>Reset Password</p>
        <form  method="POST" action="{{ route('password.request') }}">
            {{ csrf_field() }}
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group form-group-default {{ $errors->has('email') ? ' has-error' : '' }}" id="emailGroup">
                <label for="email" >E-Mail Address</label>

                <div class="controls">
                    <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>

                </div>
            </div>

            <div class="form-group form-group-default {{ $errors->has('password') ? ' has-error' : '' }}" >
                <label for="password"  >Password</label>

                <div class="controls">
                    <input id="password" type="password" class="form-control" name="password" required>
                </div>
            </div>

            <div class="form-group form-group-default {{ $errors->has('password_confirmation') ? ' has-error' : '' }}" >
                <label for="password-confirm"  >Confirm Password</label>

                <div class="controls">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                </div>
            </div>

            <div style="margin-bottom:10px;">
                <small><a href="{{ env('SITE_FRONT_URL') }}/login">Go back to login
                        <i class="fa fa-long-arrow-right"></i></a></small>
            </div>

            <button type="submit" class="btn btn-primary">
                Reset Password
            </button>

        </form>
    </div>

@endsection
