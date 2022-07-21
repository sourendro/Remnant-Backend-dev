@extends('layouts.admin')

@section('title','Password Change')

@section('content')

<div class="container-fluid">
    <div class="main-page-content">
        <div id="firstTab" class="tabcontent">
            <div class="row">
                <div class="col-md-12">
                    <div class="ch-password">
                    <form method="POST" action="{{ url('admin/change-password-update') }}" autocomplete="off">  

                        <div class="col-md-12 padding"><h3 style="color: #0d6efd;">Password Change</h3><hr style="border: 1px solid black;"></div>
                       
                                           @if (session('error'))
                       
                                            <div class=" col-md-12 alert alert-danger">
                        
                                            {{ session('error') }}
                        
                                            </div>
                       
                                           @endif
                       
                                           
                       
                                           @if (session('success'))
                       
                                           <div class=" col-md-12 alert alert-success">
                       
                                           {{ session('success') }}
                       
                                           </div>
                       
                                           @endif
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
                       
                                        <div class="form-group row">  
                       
                                               @csrf
                       
                                           <div class="form-row ">  
                       
                                               <div class="form-group  col-md-12"> 
                       
                                                   <label for="old_password" class="form-label col-lg-12">Current Password </label>
                       
                                                   <div class="input-group">
                       
                                                     <input type="password" class="form-control col-lg-12" id="old_password" placeholder="Enter Current Password" name="old_password"  required>
                       
                                                     <div class="input-group-prepend">
                       
                                                       <span class="input-group-text" id="inputGroupPrepend" style="padding: 17px;"><i class="fa fa-eye open" style="cursor: pointer;" aria-hidden="true"></i></span>
                       
                                                     </div>
                       
                                                   </div>
                       
                                                 </div>
                       
                       
                       
                                                 <div class="form-group col-md-12 mt-2"> 
                       
                                                   <label for="new_password" class="form-label col-lg-12">New Password </label>
                       
                                                   <div class="input-group">
                       
                                                       <input type="password" class="form-control col-lg-12" name="new_password" id="new_password" placeholder="Enter New Password" required>  
                       
                                                     <div class="input-group-prepend">
                       
                                                       <span class="input-group-text" id="inputGroupPrepend" style="padding: 17px;"><i class="fa fa-eye open"  style="cursor: pointer;"  aria-hidden="true"></i></span>
                       
                                                     </div>
                       
                                                   </div>
                       
                                                 </div>
                       
                       
                       
                                                 <div class="form-group  col-md-12 mt-2"> 
                       
                                                   <label for="con_password" class="form-label col-lg-12">Re-enter New Password</label>  
                       
                                                   <div class="input-group">
                       
                                                       <input type="password" class="form-control col-lg-12" name="con_password" id="con_password" placeholder="Re-entre New Password" required> 
                       
                                                     <div class="input-group-prepend">
                       
                                                       <span class="input-group-text" id="inputGroupPrepend" style="padding: 17px;"><i class="fa fa-eye open" style="cursor: pointer;"  aria-hidden="true"></i></span>
                       
                                                     </div>
                       
                       
                       
                                                     
                       
                                                   </div>
                       
                                                   <p id="con_pass_msg" style="color: red;font-weight: 700;"></p>
                       
                                                   <div class="form-group col-lg-12">  
                       
                                                       <button type="submit" class=" btn btn-primary padding-top mt-3">Submit</button>  
                       
                                                   </div> 
                       
                                                 
                       
                                                 </div>
                       
                                           </div>
                       
                       </div>
                       
                           </form>
                    </div>
                </div>
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

.invalid .fa{
        font-size : 12px;
    }

#pswd_info h6 {
    margin:0 0 10px 0;
    padding:0;
    font-weight:normal;
}

#pswd_info ul 
    {
        background-color : #f8d7da;
        border-color : #f5c2c7;
        margin: 0 10px;
        padding-right : 10px;
        border-radius: 7px;
        text-align: left;
        padding-bottom: 12px;
        padding-top: 12px;
        

    }

.invalid {
    padding-left:10px;
    line-height:24px;
    color:#ec3f41;

}
.valid {
   
    padding-left:10px;
    line-height:24px;
    color:#3a7d34;
}

ol, ul {
    padding-left: 0rem !important;
}

</style>
   
<script>



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
            $('.btn-primary').show();
            $('.btn-primary').removeAttr('disabled',false);
        }else{
            $('.btn-primary').hide();
            $('.btn-primary').attr('disabled',true);
        }
    });

    $('#new_password').focus(function() {
        $('#pswd_info').show();
    });

    $('#new_password').blur(function() {
        
    });

    

    $(".open").on('click',function(){

        

        var type = $(this).parent('span').parent('div').parent('div').find('.form-control').attr('type');



        var value = $(this).parent('span').parent('div').parent('div').find('.form-control').val();



        if($.trim(value) != '')

        {



            if(type == 'password')

            {

                $(this).parent('span').parent('div').parent('div').find('.form-control').attr('type','text');



                $(this).removeClass('fa-eye').addClass('fa-eye-slash');

            }

            else

            {

                $(this).parent('span').parent('div').parent('div').find('.form-control').attr('type','password');



                $(this).removeClass('fa-eye-slash').addClass('fa-eye');

            }

        }

        

    });


    $('.pswd_info').show();


    $("#con_password").on('keyup',function(){

        var password = $("#new_password").val();



        var con_pass = $(this).val();



        if(password != con_pass)

        {

            $(this).css('border','2px solid red');

            $("#con_pass_msg").text('New password and Re-entered password do not match.');

            $('.btn-primary').hide();

            

        }

        else

        {

            $(this).css('border','2px solid green');

            $("#con_pass_msg").text('');

            $('.btn-primary').show();

            

        }

    });



    





    

</script>
@endsection