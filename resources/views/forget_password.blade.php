<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('public/images/apple-icon-57x57.png')}}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('public/images/apple-icon-60x60.png')}}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('public/images/apple-icon-72x72.png')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('public/images/apple-icon-76x76.png')}}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('public/images/apple-icon-114x114.png')}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('public/images/apple-icon-120x120.png')}}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('public/images/apple-icon-144x144.png')}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('public/images/apple-icon-152x152.png')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('public/images/apple-icon-180x180.png')}}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('public/images/android-icon-192x192.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('public/images/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('public/images/favicon-96x96.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('public/images/favicon-16x16.png')}}">
    <link rel="manifest" href="{{ asset('public/images/manifest.json')}}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('public/images/ms-icon-144x144.png')}}">
    <meta name="theme-color" content="#ffffff">
    
    <!-- Bootstrap CSS -->
    <link href="{{ asset('public/css_login/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">

    <!-- Fontawesome 4.7.0 link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

    <!-- Fontawesome 6.1.1 link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />

     <!--Hover link -->
     <link rel="stylesheet" href="{{ asset('public/css_login/hover.css')}}">

     <!-- Custom CSS link -->
     <link rel="stylesheet" href="{{ asset('public/css_login/style.css')}}">

    <title>Remnant | Forget Password</title>
</head>
<body>
    
    <div class="container">
        <div class="login-box">
            <div class="row">
                <div class="col-lg-12">
                    <div class="logo">
                        <img src="{{ asset('public/images/logo.png')}}" alt="logo">
                    </div>
                </div>
                <div class="col-lg-12 login-title">
                    <h4>Forgot Password</h2>
                    @include('flash-message')
                </div>

                <div class="col-lg-12 login-form">
                    <form method="POST" action="{{ url('/forget-password-action')}}" autocomplete="off">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="input-container">
                                    <input id="firstName" name="email" class="input" type="email" placeholder=" " required>
                                    <div class="cut cut-email"></div>
                                    <label for="firstName" class="placeholder">Email</label>
                                </div>
                            </div>
                            
                            <div class="col-lg-12 login-btm login-button">
                                <button type="submit" class="btn btn-outline-primary hvr-float-shadow">Submit</button>
                            </div>
                            <div class="col-lg-12">
                                <a href="{{ url('/')}}" class="forgot-password"><h6>Click Here To Login Again</h6></a>
                            </div>
                        </div>
                    </form> 
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper --> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="js_login/bootstrap.bundle.min.js"></script>
</body>
</html>