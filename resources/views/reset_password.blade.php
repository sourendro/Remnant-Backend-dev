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

    <title>Remnant | Reset Password</title>
</head>
<body>
    <div class="container">
        <div class="login-box">
            <div class="row">
                <div class="col-lg-12">
                    <div class="logo">
                        <img src="{{ asset('public/images/logo.png')}}" alt="logo">
                    </div>
                    <h2>Reset Password</h2>
                    <div id="pswd_info">
                        <h6>Password must meet the following requirements:</h6>
                        <ul>
                            <li id="letter" class="invalid"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;<strong>Password must contain at least 1 lowercase</strong></li>
                            <li id="capital" class="invalid"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;<strong>Password must contain at least 1 uppercase</strong></li>
                            <li id="number" class="invalid"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;<strong>Password must contain at least 1 number</strong></li>
                            <li id="special" class="invalid"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;<strong>Password must contain at least 1 special character</strong></li>
                            <li id="length" class="invalid"><i class="fa fa-times" aria-hidden="true"></i>&nbsp;<strong>Password must contain at least 8 characters</strong></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-12 login-title">
                    
                    @include('flash-message')
                </div>

                <div class="col-lg-12 login-form">
                    <form method="POST" action="{{ url('/reset-password-action')}}" autocomplete="off">
                        @csrf
                        <input type="hidden" name="key" value="{{ $id}}">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="input-container">
                                    <input type="password" id="new_password" name="new_password" class="input" required>
                                    <div class="cut new_password_cute"></div>
                                    <label for="new_password" class="placeholder">New Password</label>
                                   <small><input type="checkbox" name="show" id="show">&nbsp;&nbsp;show password</small>
                                </div>
                            </div>
                            

                            <div class="col-lg-12">
                                <div class="input-container input-container2">
                                    <input id="confirm_password" class="input"  name="confirm_password" type="password" required>
                                    <div class="cut confirm_password_cute"></div>
                                    <label for="confirm_password" class="placeholder">Confirm Password</label>
                                </div>
                            </div>
                            <div class="col-lg-12 login-btm login-button">
                                <button type="submit" class="submit btn btn-outline-primary hvr-float-shadow">Submit</button>
                            </div>
                            <div class="col-lg-12 login-btm login-button">
                            <a href="{{ url('/') }}" class="btn btn-outline-primary hvr-float-shadow">Login</a>
                            </div>
                        </div>
                    </form> 
                </div>
            </div>
        </div>
    </div>

    <style>
        .ch-password {
        border: 2px solid #0002;
        padding: 20px;
        margin: -2% 28%;
        border-radius: 17px;
    }
    
    #letter {
        letter-spacing: 1.9px;
    }
    #capital {
        letter-spacing: 1.9px;
    }
    #number {
        letter-spacing: 1.9px;
    }
    #special {
        letter-spacing: 1.9px;
    }
    #length {
        letter-spacing: 1.9px;
    }
    
    /* .fa-times{

    } */

    #pswd_info h6 {
        margin:0 0 10px 0;
        padding:0;
        font-weight:normal;
        /* letter-spacing: 2px; */

    }
    /* FOR CHENGING FA ICONE SIZE */
    .invalid .fa{
        font-size : 12px;
    }
    /* END CHENGING FA ICONE SIZE */
    .invalid {
        padding-left:10px;
        line-height:24px;
        color:#ec3f41;
        list-style-type: none;
    
    }
    .valid {
       
        padding-left:10px;
        line-height:24px;
        color:#3a7d34;
        list-style-type: none;
    }
    
    ol, ul {
        padding-left: 0rem !important;
    }

    #pswd_info ul 
    {
        background-color : #f8d7da;
        border-color : #f5c2c7;
        margin: 0 10px;
        padding-right : 10px;
        border-radius: 7px;
        text-align: left;

    }

    #pswd_info ul li {
        font-size: 13px;
        
        
    }

    
    
    </style>
</body>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="js_login/bootstrap.bundle.min.js"></script>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
      crossorigin="anonymous"></script>
    <script>
        $('.close-msg').click(function(){
                $(this).parent('div').hide();
            });


            $('#pswd_info').hide();
    $('.close-msg').click(function(){
            $(this).parent('div').hide();
        });

        $('#pswd_info').hide();

$('#new_password').keyup(function() {
    var pswd = $(this).val();

    var pass = 0;

    if ( pswd.match(/[a-z]/) ) {
        $('#letter').removeClass('invalid').addClass('valid');
        $('#letter').find('i').removeClass('fa-times').addClass('fa-check');
    } else {
        $('#letter').removeClass('valid').addClass('invalid');
        $('#letter').find('i').removeClass('fa fa-check').addClass('fa fa-times');
        pass = 1;
    }


    //<i class="fa fa-check" aria-hidden="true"></i>
    //validate capital letter
    if ( pswd.match(/[A-Z]/) ) {
        $('#capital').removeClass('invalid').addClass('valid');

        $('#capital').find('i').removeClass('fa-times').addClass('fa-check');
     
    } else {
        $('#capital').removeClass('valid').addClass('invalid');
        $('#capital').find('i').removeClass('fa fa-check').addClass('fa fa-times');
        pass = 1;
    }

    //validate number
    if ( pswd.match(/\d/) ) {
        $('#number').removeClass('invalid').addClass('valid');
        $('#number').find('i').removeClass('fa-times').addClass('fa-check');
       
    } else {
        $('#number').removeClass('valid').addClass('invalid');
        $('#number').find('i').removeClass('fa fa-check').addClass('fa fa-times');
        pass = 1;
    }

    if ( pswd.match(/[$%#@!&*^]/) ) {
        $('#special').removeClass('invalid').addClass('valid');
        $('#special').find('i').removeClass('fa-times').addClass('fa-check');
      
    } else {
        $('#special').removeClass('valid').addClass('invalid');
        $('#special').find('i').removeClass('fa fa-check').addClass('fa fa-times');
        pass = 1;
    }

    if ( pswd.length < 8 ) {
        $('#length').removeClass('valid').addClass('invalid');
        $('#length').find('i').removeClass('fa fa-check').addClass('fa fa-times');
        pass = 1;
       
    } else {
        $('#length').removeClass('invalid').addClass('valid');
        $('#length').find('i').removeClass('fa-times').addClass('fa-check');
        
    }


    if(pass == 0){

        // $("button[type='submit']").show();
        // $('.submit').show();
        // $('.submit').removeAttr('disabled',false);
    }else{
        // $('.submit').hide();
        // $('.submit').attr('disabled',true);
        // $("button[type='submit']").hide();
    }
});

$('#new_password').focus(function() {
    $('#pswd_info').show();
});

$('#new_password').blur(function() {
    
});



$("#show").on('click',function(){

    if($(this).is(":checked"))
    {
        $("#new_password").attr('type','text');
        $("#confirm_password").attr('type','text');
    }
    else
    {
        $("#new_password").attr('type','password');
        $("#confirm_password").attr('type','password');
    }
    

    

});


$('.pswd_info').show();


$("#confirm_password").on('keyup',function(){

    var password = $("#new_password").val();
    var con_pass = $(this).val();

    if(password != con_pass)
    {
        $(this).css('border','2px solid red');

        $("#con_pass_msg").text('New password and Re-entered password does not match.');

        $('submit').hide();
    }
    else
    {
        $(this).css('border','2px solid green');

        $("#con_pass_msg").text('');

        $('submit').show();
    }

});
    </script>
</html>

