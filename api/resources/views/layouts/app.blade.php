<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app" class="login">


    <div class="container-fluid">
        <div class="row">
            <div class="faded-bg animated"></div>
            <div class="hidden-xs col-sm-7 col-md-8">
                <div class="clearfix">
                    <div class="col-sm-12 col-md-10 col-md-offset-2">
                        <div class="logo-title-container">
                            <img class="img-responsive pull-left logo hidden-xs animated fadeIn"
                                 src="{{ asset('img/house.svg') }}" alt="Logo Icon">
                            <div class="copy animated fadeIn">
                                <h1>Builder Management</h1>
                                <p>Welcome to All Renos backend.</p>
                            </div>
                        </div> <!-- .logo-title-container -->
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-5 col-md-4 login-sidebar">

                <div class="login-container">


                    <div >

                        @yield('content')

                        <div style="clear:both"></div>
                        <hr>


                    </div>
                </div> <!-- .login-container -->

            </div> <!-- .login-sidebar -->
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->


</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
