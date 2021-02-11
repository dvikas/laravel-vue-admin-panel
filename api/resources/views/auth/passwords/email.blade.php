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

        <p>Reset Password</p>
        <form  method="POST" action="{{ route('password.email') }}">
            {{ csrf_field() }}

            <div class="form-group form-group-default {{ $errors->has('email') ? ' has-error' : '' }}" id="emailGroup">
                <label for="email" >E-Mail Address</label>

                <div class="controls">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                </div>
            </div>

            <div style="margin-bottom:10px;">
                <small><a href="{{ env('SITE_FRONT_URL') }}/login">Go back to login
                        <i class="fa fa-long-arrow-right"></i></a></small>
            </div>

            <button type="submit" class="btn btn-primary">
                Send Password Reset Link
            </button>

        </form>
    </div>

@endsection
