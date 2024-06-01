@extends('dashboard.layout.admin_layout')
@section('content')
       <!-- Begin Page Content -->
   <div class="container-fluid">
    <div class="d-flex align-items-center mb-3">
        <h5 class="mb-0">Profile
        </h5>
        &nbsp;&nbsp;|&nbsp;&nbsp;
        <a href=""><i class="fa fa-user"></i></a>
        &nbsp;&nbsp;<i class="">&gt;</i>&nbsp;&nbsp;
        <h6 class="mb-0">Profile Setting</h6>
    </div>
<!-- Page Heading -->
    <form id="profile_form"  enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <h2 class="h4 mb-3">Update Profile</h2>								
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="">Name <span class="text-danger">*</span></label>
                                    <input type="text" value="{{Auth::user()->name}}"  name="user_name" id="user_name" class="form-control" placeholder="Enter product name">	
                                    @error('user_name')
                                    <div style="color: red;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>                                         
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="">Email<span class="text-danger">*</span></label>
                                    <input type="text" value="{{Auth::user()->email}}" readonly  name="email" id="email" class="form-control" placeholder="Enter unit of measurement">	
                                </div>
                            </div>     
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="">Profile Image<span class="text-danger">*</span></label>
                                    <input type="file" onchange="document.querySelector('#show_main_image').src=window.URL.createObjectURL(this.files[0])"  name="profile_image" id="profile_image" class="form-control">	

                                    <button type="button" class="btn position-relative mt-2">
                                        <img id="show_main_image" width="100"  height="100" src="" class="img-thumbnail img-flui" alt="Profile">
                                        <span class="position-absolute top-0 start-1 translate-middle p-2  border border-light rounded-circle bg-danger" style="width: 21px;height:22px;" id="cross_image_btn">
                                            
                                        </span>
                                    </button>
                                </div>
                            </div>     
                            <div class=" pt-3">
                                <button type="button" id="update_btn" class="btn btn-primary">Update</button>
                            </div>                                    
                        </div>
                    </div>	                                                                      
                </div>
            
            </div>
        </div>	
    </form>

    <hr>

    <form id="change_password_form"  enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <h2 class="h4 mb-3">Change Password</h2>								
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="">Password: <span class="text-danger">*</span></label>
                                    <input type="password"  name="current_password" id="current_password" class="form-control" placeholder="Enter your current password">	
                                </div>
                            </div>                                         
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="">New Password: <span class="text-danger">*</span></label>
                                    <input type="password"   name="new_password" id="new_password" class="form-control" placeholder="Enter password atleast 8">	
                                </div>
                            </div>     
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="">Confirm Password: <span class="text-danger">*</span></label>
                                    <input type="password"   name="new_password_confirmation" id="confirm_password" class="form-control" >	
                                </div>
                            </div>
                            <div class=" pt-3">
                                <button type="password" id="change_password_btn" class="btn btn-primary">Update</button>
                            </div>                                    
                        </div>
                    </div>	                                                                      
                </div>
               
            </div>
        </div>	
    </form>
  
<!-- DataTales Example -->


</div>
        <!-- /.container-fluid -->

            
        </div>
        <!-- End of Main Content -->
@endsection

@section('javascript')
    
<script>
      $("#cross_image_btn").click(function(){
        // alert("s");
        $("#profile_image").val("");
        $('#show_main_image').attr('src', '');
    });

    $("#update_btn").click(function(e){
        e.preventDefault();    
            var data = $("#profile_form")[0];
            let formData = new FormData(data);
            // alert("hit");
                $.ajax({
                        url: '/update_profile',
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                        beforeSend: function() {
                            $("#update_btn").attr('disabled', 'disabled').html('<div class="loader" disabled></div>');
                        },
                        success: function(response) {

                            $("#update_btn").removeAttr('disabled', 'disabled').html('Update');
                            if (response.status == true) {
                                $("#profile_form")[0].reset();
                                window.location.assign("/profile");
                                sweetalert("bottom-right","success",response.message);
                            }else if(response.status == false){
                                // window.location.assign("/profile");
                                const errors = response.errors;
                                const errorList = errors.map(error => `<li>${error}</li>`).join('');

                                Swal.fire({
                                    icon: "error",
                                    title: "Error!",
                                    html: `<ul style="list-style:none;color:red;">${errorList}</ul>`,
                                });
                            }
                        }
                });
    });
    $("#change_password_btn").click(function(e){
        // HERE I CHECK FILED IS NULL OR NOT
        // const errors = [];
        e.preventDefault();

            $.ajax({
                        url: '/update_password',
                        method: 'POST',
                        data: $("#change_password_form").serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                        beforeSend: function() {
                            $("#change_password_btn").attr('disabled', 'disabled').html('<div class="loader" disabled></div>');
                        },
                        success: function(response) {

                            $("#change_password_btn").removeAttr('disabled', 'disabled').html('Update');
                            if (response.status == true) {
                                $("#change_password_form")[0].reset();
                                Swal.fire({
                                    icon: "success",
                                    title: "Success!",
                                    html: `<ul style="list-style:none;"><li>${response.message}</li></ul>`,
                                });
                                window.location.assign("/logout");
                            }else if(response.status == false && response.message !== "Current password does not match"){
                                const errors = response.errors;
                                const errorList = errors.map(error => `<li>${error}</li>`).join('');

                                Swal.fire({
                                    icon: "error",
                                    title: "Error!",
                                    html: `<ul style="list-style:none;color:red;">${errorList}</ul>`,
                                });
                            }else if(response.status == false && response.message === "Current password does not match"){
                                Swal.fire({
                                    icon: "error",
                                    title: "Error!",
                                    html: `<ul style="list-style:none;color:red;"><li>${response.message}</li></ul>`,
                                });
                            }
                        }
                });
        // };
    });
</script>

@endsection