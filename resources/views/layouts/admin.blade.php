<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css" rel="stylesheet">
        

    <!-- Fontawesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
    <!-- jquery cdn link -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>


    <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
    <!-- <script sec="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script> -->
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>

    <!-- <script sec="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script sec="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script> -->
    <!-- Custom css link -->
    <link rel="stylesheet" href="{{ asset('public/css/style.css')}}">

    <title>@yield('title')</title>


    <script>
        const APP_URL = "{{ url('/')}}";
        var csrf_token = "{{ csrf_token() }}";
    </script>
</head>

<body>
    <div class="container-fluid px-0">
        <div class="main-content">
            <div class="total-main-content">

                @include('layouts.admin_sidebar')

                <div class="right-main-content width-eightyfive">
                    <div class="right-side">
                        @include('layouts.admin_topbar')

                        @yield('content')

                    </div>
                </div>
                      
            </div>
        </div>
    </div>
            
</body>
    <style>
        .modal-dialog{
            max-width: 864px;
        }

        div#DataTables_Table_0_filter {
            margin: 10px;
        }
        div#DataTables_Table_0_length {
            display: none;
        }
  </style>

    
    <script>
       

        $(".table").dataTable({
            "pageLength" : 10,
            "order" : [],
            dom: 'Bfrtip',
            buttons : [{extend: 'excel', text: 'Export'}
        ]
        });

        $(".bar-button").click(function(){
            $(".left-main-content").toggleClass("none");
            $(".profileImage").toggleClass("none2");
            $(".left-side-menu-name").toggleClass("none3");
            $(".right-side-top").toggleClass("right-side-top-width100");
        });

        $(".fileManagementSystem").click(function(){
            $(".fileManagementSystemMenu").slideToggle();
        });

       
        $('.logout').click(function (e) { 
            e.preventDefault();

            window.location.href = APP_URL+'/logout';
            
        });



        $('.editUser').click(function (e) { 
            e.preventDefault();
            var user = $(this).parent('td').parent('tr').find('.user').val();
            var name = $(this).parent('td').parent('tr').find('.name').text();
            var userName = $(this).parent('td').parent('tr').find('.userName').text();
            var email = $(this).parent('td').parent('tr').find('.email').text();
            var gender = $(this).parent('td').parent('tr').find('.gender').val();
            var role = $(this).parent('td').parent('tr').find('.role').val();
            var mobile_no = $(this).parent('td').parent('tr').find('.mob_no').val();
            var country_code = $(this).parent('td').parent('tr').find('.cun_code').val();
            country_code = country_code.replace('+','');
            $("#user_id").val(user);
            $("#first_name").val(name);
            //$("#last_name").val(name[1]);
            $("#email").val(email);
            $("#user_name").val(userName);
            $("#gender").val(gender).change();

            $("#role").val(role).change();
            $("#country_code").val(country_code).change();
            $("#mobile_no").val(mobile_no);


        });


        $('.save_changes').click(function (e) { 
            e.preventDefault();
            var errorMsg = '';
            var userId = $("#user_id").val();
            var first_name = $("#first_name").val();
            //var last_name = $("#last_name").val();
            var email = $("#email").val();
            var user_name = $("#user_name").val();
            var gender = $("#gender").val();
            var role = $("#role").val();
            var CSRF = "{{csrf_token()}}";
            var roleText = $("#role option:selected").text();

            var m_no = $("#mobile_no").val();
            var c_code = $("#cuntry_code").val();
            var beliver = $('input[name="beliver"]:checked').val();
            var dreams = $('input[name="dreams"]:checked').val();
            var prayer = $('input[name="prayer"]:checked').val();
            var question = $('input[name="question"]:checked').val();
            var event = $('input[name="event"]:checked').val();
            var holy_spirit = $('input[name="holy_spirit"]:checked').val();

          
            //var status = $("input[name='status']").val();

            $.ajax({
                type: "POST",
                url: APP_URL+"/admin/user-edit-store",
                data: {
                    first_name :first_name,
                    //last_name : last_name,
                    email : email,
                    user_name : user_name,
                    gender : gender,
                    _token: CSRF,
                    user_id : userId,
                    role : role,
                    m_number : m_no,
                    c_code : c_code,
                    beliver : beliver,
                    dreams : dreams,
                    prayer : prayer,
                    question : question,
                    event : event,
                    holy_spirit : holy_spirit

                },
                success: function (response) {
                    console.log(response);
                   if(response.status == 1){
                       
                       $.each(response.errors, function(index, value){
                            errorMsg+=value+"<br>";   
                       });

                        $(".alert-danger").show();
                        $(".alert-danger").html(errorMsg);
                   }else{
               
                   
                        var gender = response.a.gender == 1 ? 'Male' : (response.a.gender == 2 ? 'Female' : 'Transgender');

                        $("#tr_"+userId).find('.name').text(response.a.first_name);
                        $("#tr_"+userId).find('.userName').text(response.a.user_name);
                        $("#tr_"+userId).find('.email').text(response.a.email);
                        $("#tr_"+userId).find('.gender').val(response.a.gender);
                        $("#tr_"+userId).find('.status').val(response.a.status);
                        $("#tr_"+userId).find('.genderText').text(gender);
                        $("#tr_"+userId).find('.roleText').text(roleText);
                        $("#tr_"+userId).find('.mob_no').val(response.a.mobile_no);
                        $("#tr_"+userId).find('.cun_code').val(response.a.country_code);
                        
                        $(".alert-danger").hide();
                        $(".alert-danger").html('');
                        $(".cl").trigger('click');
                        swal({
                            title: "Success!",
                            text: "User Data Updated Successfully!",
                            icon: "success",
                            button: "Ok!",
                        });
                   }
                }
            });
            
            
        });


        $('.save_changes_admin').click(function (e) { 
            e.preventDefault();
            var errorMsg = '';
            var userId = $("#user_id").val();
            var first_name = $("#first_name").val();
            //var last_name = $("#last_name").val();
            var email = $("#email").val();
            var user_name = $("#user_name_admin").val();
            var gender = $("#gender").val();
            var role = $("#role").val();
            var CSRF = "{{csrf_token()}}";
            var roleText = $("#role option:selected").text();
            var m_no = $("#mobile_no").val();
            var c_code = $("#country_code").val();
           
          
            //var status = $("input[name='status']").val();

            $.ajax({
                type: "POST",
                url: APP_URL+"/admin/admin-edit-store",
                data: {
                    first_name :first_name,
                    //last_name : last_name,
                    email : email,
                    user_name : user_name,
                    gender : gender,
                    _token: CSRF,
                    user_id : userId,
                    role : role,
                    mob_number : m_no,
                    c_code : c_code,

                },
                success: function (response) {
                    console.log(response);
                   if(response.status == 1){
                       
                       $.each(response.errors, function(index, value){
                            errorMsg+=value+"<br>";   
                       });

                        $(".alert-danger").show();
                        $(".alert-danger").html(errorMsg);
                   }else{
               
                   
                        var gender = response.a.gender == 1 ? 'Male' : (response.a.gender == 2 ? 'Female' : 'Transgender');

                        $("#tr_"+userId).find('.name').text(response.a.full_name);
                        $("#tr_"+userId).find('.userName').text(response.a.user_name);
                        $("#tr_"+userId).find('.email').text(response.a.email);
                        $("#tr_"+userId).find('.gender').val(response.a.gender);
                        $("#tr_"+userId).find('.status').val(response.a.status);
                        $("#tr_"+userId).find('.genderText').text(gender);
                        $("#tr_"+userId).find('.roleText').text(roleText);
                        $("#tr_"+userId).find('.role').val(role);
                        $("#tr_"+userId).find('.mobile_no').text(response.a.country_code + ' ' + response.a.mobile_no);
                        $("#tr_"+userId).find('.mob_no').val(response.a.mobile_no);
                        $("#tr_"+userId).find('.cun_code').val(response.a.country_code);


                        
                        $(".alert-danger").hide();
                        $(".alert-danger").html('');
                        $(".cl").trigger('click');
                        swal({
                            title: "Success!",
                            text: "User Data Updated Successfully!",
                            icon: "success",
                            button: "Ok!",
                        });
                   }
                }
            });
            
            
        });

        $('.deleteUser').click(function(){
            var that = $(this).parent('td').parent('tr');
            var user = $(this).parent('td').parent('tr').find('.user').val();

            swal({
      title: "Are you sure?",
      text: "Do You Want to Delete this Record ?",
      icon: "warning",
      buttons: [
        'No, cancel it!',
        'Yes, I am sure!'
      ],
      dangerMode: true,
    }).then(function(isConfirm) {
      if (isConfirm) {
            $.ajax({
                type: "GET",
                url: APP_URL+"/admin/user-delete",
                data: { user_id : user},
                success: function (response) {
                    console.log(response);
                    if(response.status == 1){
                        that.remove();
                        swal({
                            title: 'Success!',
                            text: 'User successfully deleted!',
                            icon: 'success'
                        });
                    }
                   
                }
            });
        
        } else {
            swal("Cancelled", "Your imaginary record is safe :)", "error");
        }
    });
        });


        $(".status_check").click(function(){

            that = $(this);
            var user = $(this).parent('td').parent('tr').find('.user').val();

            if($(this).is(":checked")){
                $.ajax({
                    type: "GET",
                    url: APP_URL+"/admin/user-status-update",
                    data: {user_id: user, update : 0},
                    success: function (response) {
                        swal({
                            title: "Success!",
                            text: "User is now Active!",
                            icon: "success",
                            button: "Ok!",
                        });
                    }
                });
            }else{
                
                $.ajax({
                    type: "GET",
                    url: APP_URL+"/admin/user-status-update",
                    data: {user_id: user, update : 1},
                    success: function (response) {
                        swal({
                            title: "Success!",
                            text: "User is now Inactive!",
                            icon: "success",
                            button: "Ok!",
                        });
                    }
                });
            }
        });


        $(".all").click(function(){
            if($(this).is(":checked")){
                $(this).parent('label').parent('div').parent('div').find('.form-check-input').prop('checked',true);
            }else{
                $(this).parent('label').parent('div').parent('div').find('.form-check-input').prop('checked',false);
            }
        });

        
        $('.close-msg').click(function(){
            $(this).parent('div').hide();
        });


    </script>
</html>