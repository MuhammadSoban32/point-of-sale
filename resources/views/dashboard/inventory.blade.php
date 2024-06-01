@extends('dashboard.layout.admin_layout')
@section('content')
                 <!-- Begin Page Content -->
                 <div class="container-fluid">
                    <div class="d-flex align-items-center mb-3">
                        <h5 class="mb-0">Inventory</h5>
                        &nbsp;&nbsp;|&nbsp;&nbsp;
                        <a href=""><i class="fa fa-home"></i></a>
                        &nbsp;&nbsp;<i class="">&gt;</i>&nbsp;&nbsp;
                        <h6 class="mb-0">Inventory</h6>
                    </div>
                <!-- Page Heading -->
                    <form id="product_form"  enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h2 class="h4 mb-3">Add Inventory</h2>								
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="">Product Name <span class="text-danger">*</span></label>
                                                    <input type="text"  name="product_name" id="product_name" class="form-control" placeholder="Enter product name">	
                                                </div>
                                            </div>                                         
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for="">Measurement Kg/L <span class="text-danger">*</span></label>
                                                    <input type="text"  name="measurement_unit" id="measurement_unit" class="form-control" placeholder="Enter unit of measurement">	
                                                </div>
                                            </div>     
                                            <div class=" pt-3">
                                                <button type="button btn btn-primary" id="create_btn" class="btn btn-primary">Add</button>
                                            </div>                                    
                                        </div>
                                    </div>	                                                                      
                                </div>
                               
                            </div>
                        </div>	
                    </form>
                <!-- DataTales Example -->
                <div class="card shadow mb-4">
                    {{-- <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
                    </div> --}}
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>S#</th>
                                        <th>Product Name</th>
                                        <th>Measure</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="t-body">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            
            </div>
            <!-- /.container-fluid -->
            
                            
                        </div>
                        <!-- End of Main Content -->
             {{-- MIDAL --}}
             <div class="modal fade" id="show_edit_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="exampleModalLabel">Product Update</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                       <div class="container">
                        <form id="product_edit_form"  >
                            <div class="row">
                                <div class="col-md-12">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="">Product Name <span class="text-danger">*</span></label>
                                                        <input type="text"  name="product_name" id="product_name_modal" class="form-control" placeholder="Enter product name">	
                                                        <input type="hidden"  name="product_id" id="product_id_modal" >	
                                                    </div>
                                                </div>                                         
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <label for="">Measurement Kg/L <span class="text-danger">*</span></label>
                                                        <input type="text"  name="measurement_unit" id="measurement_unit_modal" class="form-control" placeholder="Enter unit of measurement">	
                                                    </div>
                                                </div>     
                                                <div class="text-end pt-3">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" id="edit_btn" class="btn btn-primary">Save Changes</button>
                                                </div>                                    
                                            </div>
                                        </div>	                                                                                             
                                </div>
                            </div>	
                        </form>
                       </div>
                    </div>
                    {{-- <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="button" class="btn btn-primary">Save changes</button>
                    </div> --}}
                  </div>
                </div>
            </div>
@endsection
@section('javascript')
    
<script>
    $("#create_btn").click(function(e){
        e.preventDefault();
            
            // alert("hit");
                $.ajax({
                        url: '/add-item',
                        method: 'POST',
                        data: $("#product_form").serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                        beforeSend: function() {
                            $("#create_btn").attr('disabled', 'disabled').html('<div class="loader" disabled></div>');
                        },
                        success: function(response) {

                            $("#create_btn").removeAttr('disabled', 'disabled').html('Create');
                            if (response.status == true) {
                                $("#product_form")[0].reset();
                                fetch_items();
                                sweetalert("bottom-right","success",response.message);
                                // $("#categories_insert_modal").modal("hide"); 
                            }else if(response.status == false){
                                // sweetalert("bottom-end","error",response.message);
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

    fetch_items();
    // FETCH ITEMS
    function fetch_items() {
        $.ajax({
                    url: '/fetch-item',
                    method: 'get',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
                    beforeSend: function() {
                        $("#create_btn").attr('disabled', 'disabled').html('<div class="loader" disabled></div>');
                    },
                    success: function(response) {

                        $("#create_btn").removeAttr('disabled', 'disabled').html('Create');
                        if (response.status == true) {
                          html = "";
                            if (response.items && response.items.length > 0) {
                                response.items.forEach((element,key)=> {
                                html += `
                                    <tr>
                                        <td>${key+1}</td>
                                        <td>${element.name}</td>
                                        <td>${element.unit}</td>
                                        <td>
                                            <button type="buttom" onclick="show_edit_modal('${element.id}')" class="btn btn-warning btn-sm" ><i class="fa fa-edit"></i></button>
                                            <a href="javascript:void(0);" class="btn btn-danger btn-sm" onclick="delete_items('${element.id}')"><i class="fa fa-trash"></i><a>
                                        </td>
                                    </tr>
                                `;
                                });
                            }else{
                                html =`<tr>
                                            <td colspan="4" class="text-center">Products not available</td>
                                        </tr>`;
                            }
                            
                                $("#t-body").html(html);
                        }else if(response.status == false){
                            sweetalert("bottom-end","error",response.message);
                        }
                    }
            });
    }

       // DELETE FUNCTION
       function delete_items(id) {
                Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
        }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/delete-item',
                method: 'get',
                data: {id},
                success: function(response) {
                    if (response.status == true) {
                        sweetalert("bottom-end","success",response.message)                        
                        fetch_items();
                    }else{
                        sweetalert("bottom-end","error",response.message)                        
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
        });
       
    }
       // EDIT FUNCTION
    function show_edit_modal(id) {
        $.ajax({
        method: "get",
        url: "/edit-items-modal",
        data: {id:id},
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, 
        beforeSend: function(){
                $('.loader-background').css('display', 'flex');
        }
    })
    .done(function(response){
        if (response.status == false) {
            // alert(response.message);
            sweetalert("bottom-end","error",response.message);
        }else{
            $("#product_id_modal").val(response.items.id);
            $("#product_name_modal").val(response.items.name);
            $("#measurement_unit_modal").val(response.items.unit);
            $("#show_edit_modal").modal("show");
        }
    });
 
};

$("#edit_btn").click(function(e){
        e.preventDefault();
            // alert("hit m");
                $.ajax({
                        url: '/edit-items',
                        method: 'POST',
                        data: $("#product_edit_form").serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                        beforeSend: function() {
                            $("#edit_btn").attr('disabled', 'disabled').html('<div class="loader" disabled></div>');
                        },
                        success: function(response) {

                            $("#edit_btn").removeAttr('disabled', 'disabled').html('Create');
                            if (response.status == true) {
                                $("#product_form")[0].reset();
                                $("#show_edit_modal").modal("hide");
                                fetch_items();
                                sweetalert("bottom-right","success",response.message);
                                // $("#categories_insert_modal").modal("hide"); 
                            }else if(response.status == false ){
                                // sweetalert("bottom-end","error",response.message);
                                const errors = response.errors;
                                const errorList = errors.map(error => `<li>${error}</li><br>`).join('');
                                Swal.fire({
                                    icon: "error",
                                    title: "Error!",
                                    html: `<ul style="list-style:none;color:red;">${errorList}</ul>`,
                        });
                            }
                        }
                });
       
    });
</script>

@endsection