<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SB Admin 2 - Login</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset("/dashboard/vendor/fontawesome-free/css/all.min.css") }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset("/dashboard/css/sb-admin-2.min.css") }}" rel="stylesheet">

</head>

<body class="bg-gradient-primary">
<style>
    
.icon {
    position: relative;
    right: 13px;
    top: -34px;
    float: right;
}

.icon i {
  cursor: pointer;
}
</style>
    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                            @foreach ($errors->all() as $error)
                                                {{ $error }}
                                            @endforeach
                                    </div>
                                @endif
                                      <form  action="/login" method="POST"  class="user">
                                        @csrf
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                              aria-describedby="emailHelp"
                                                placeholder="Enter Email Address..." value="{{ old('email') }}" name="email" id="email">
                                                {{-- @error('email')
                                                <div style="color: red;">{{ $message }}</div>
                                                @enderror --}}
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user"
                                               placeholder="Password" name="password"  class="form-control" id="password">
                                               <span class="icon" id="eyetoggle">
                                                <i class="fa fa-eye-slash" ></i>
                                              </span>
                                               {{-- @error('password')
                                               <div style="color: red;">{{ $message }}</div>
                                                @enderror --}}
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox"      class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <button type="submit" id="submitbtn" class="btn btn-primary btn-user btn-block">
                                            Login
                                        </button>
                                        <hr>
                                        <a href="index.html" class="btn btn-google btn-user btn-block">
                                            <i class="fab fa-google fa-fw"></i> Login with Google
                                        </a>
                                        <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                            <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                                        </a>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="forgot-view">Forgot Password?</a>
                                    </div>
                                    {{-- <div class="text-center">
                                        <a class="small" href="register-view">Create an Account!</a>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset("/dashboard/vendor/jquery/jquery.min.js") }}"></script>
    <script src="{{ asset("/dashboard/vendor/bootstrap/js/bootstrap.bundle.min.js") }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset("/dashboard/vendor/jquery-easing/jquery.easing.min.js") }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset("/dashboard/js/sb-admin-2.min.js") }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
          $("#eyetoggle").click(function(){
        if ($("#password").attr("type") == "text") {
            $("#password").attr("type", "password");            
            $("#eyetoggle").html('<i class="fa fa-eye-slash" ></i>');    
        }else{
            $("#password").attr("type", "text");
            $("#eyetoggle").html('<i class="fa fa-eye" ></i>');     
        }
    });
        // function check(event) {
        //     event.preventDefault();

        //     var permission = 0;
        //     var arrayList = ['email','password'];   
        //     for (let i = arrayList.length; i >= 0; i--) {
        //         var checkvalue = $("#"+arrayList[i]).val();
        //         if (checkvalue == '') {
        //             // alert(arrayList[i] + " is null");
        //                 const Toast = Swal.mixin({
        //                 toast: true,
        //                 position: "bottom-end",
        //                 showConfirmButton: false,
        //                 timer: 3000,
        //                 timerProgressBar: true,
        //                 didOpen: (toast) => {
        //                     toast.onmouseenter = Swal.stopTimer;
        //                     toast.onmouseleave = Swal.resumeTimer;
        //                 }
        //                 });
        //                 Toast.fire({
        //                 icon: "error",
        //                 title: "Please Enter "+arrayList[i]
        //                 });
        //             permission++;
        //         }
        //     }

        //     if (permission == 0) {
        //         var fd = new FormData();
        //         fd.append('email', $("#email").val());
        //         fd.append('password', $("#password").val());

        //         $.ajax({
        //             method: "post",
        //             url: "/login",
        //             processData: false,
        //             contentType: false,
        //             data: fd,
        //             headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, 
        //             beforeSend: function(){
        //                 $('#submitbtn').attr('disabled', 'disabled').html('checking...');
        //             }
        //         })
        //         .done(function(response){
        //             $("#submitbtn").removeAttr('disabled', 'disabled').html('sign in');
                    
        //             if (response.status == false) {
        //                 if(response.errors.email) {
        //                         $('#emailError').text(response.errors.email[0]);
        //                     }
        //                     if(response.errors.password) {
        //                         $('#passwordError').text(response.errors.password[0]);
        //                     }
        //             }else{
        //                 // location.assign("/");
        //             }
        //         });
        //     }
        // }
    </script>
</body>

</html>
