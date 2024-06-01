@extends('dashboard.layout.admin_layout')
@section('content')
                 <!-- Begin Page Content -->
                 <div class="container-fluid">
                    <div class="row mt-3 mb-3">
                         <div class="col-6 d-flex justify-content-space-between">
                             <div class="d-flex align-items-center mb-3">
                                 <h5 class="mb-0">Bills</h5>
                                 &nbsp;&nbsp;|&nbsp;&nbsp;
                                 <a href=""><i class="fa fa-home"></i></a>
                                 &nbsp;&nbsp;<i class="">&gt;</i>&nbsp;&nbsp;
                                 <h6 class="mb-0">Bills</h6>
                             </div>
                         </div>
                         <div class="col-6 text-end">
                             <a href="/bills_create_page"  class="btn btn-primary">Add Bill</a>
                         </div>
                    </div>
                 <!-- Page Heading -->
                     <form id="search_by_form" >
                         <div class="row">
                             <div class="col-md-12">
                                 <div class="card mb-3">
                                     <div class="card-body">
                                         {{-- <h2 class="h6 mb-3">Search By</h2>								 --}}
                                         <div class="row">
                                             <div class="col-md-6">
                                                 <div class="mb-3">
                                                     <label for="">Search By</label>
                                                     {{-- <input type="text"  name="product_name" id="product_name" class="form-control" placeholder="Enter product name">	 --}}
                                                     <select name="search_by" id="search_by" class="form-select">
                                                         <option value="">Choose</option>
                                                         <option value="date">Date</option>
                                                         <option value="created-at">Created at</option>
                                                     </select>
                                                 </div>
                                             </div>                                         
                                             <div class="col-md-6">
                                                 <div class="mb-3">
                                                     <label for="">Date</label>
                                                     <input type="date"  name="date" id="date" class="form-control" placeholder="Enter unit of measurement">	
                                                 </div>
                                             </div>     
                                             <div class=" pt-3">
                                                 <button type="submit" id="search_btn" class="btn btn-primary">Search</button>
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
                                         <th scope="col">#</th>
                                         <th scope="col">Supplier</th>
                                         <th scope="col">Date</th>
                                         <th scope="col">Total</th>
                                         <th scope="col">Created at</th>
                                         <th scope="col">Action</th>
                                     </tr>
                                 </thead>
                                 <tbody id="t-body">
                                     <tr>
                                         <td colspan="12" class="text-center">Products not available</td>
                                     </tr>
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
 {{-- MIDAL --}}
 <div class="modal fade" id="show_customer_detail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Bill Detail</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Item</th>
                    <th scope="col">Unit</th>
                    <th scope="col">Qty</th>
                    <th scope="col">Price</th>
                    <th scope="col">Total</th>
                  </tr>
                </thead >
                <tbody id="t-body-1">
                  
                </tbody>
              </table>
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
  var arrayList = ['search_by','date'];
$("#search_by_form").submit(function(e){
//    alert(".submit");
   e.preventDefault();
  


   // alert("hit");
   var formData = new FormData($('#search_by_form')[0]); // Create FormData object with the form data
       $.ajax({
               url: '/search_by',
               method: 'POST',
               data: formData,
               contentType:false,
               processData:false,
               headers: { 
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               },
               beforeSend: function() {
                   $("#search_btn").attr('disabled', 'disabled').html('<div class="loader" disabled></div>');
               },
               success: function(response) {
                   $("#search_btn").removeAttr('disabled', 'disabled').html('search');
                   if (response.status == true) {
                       html = "";
                       if (response.data && response.data.length > 0) {
                           response.data.forEach((element,key)=> {
                                    const createdAtDate = new Date(element.created_at);
                                    const formattedDate = createdAtDate.toISOString().split('T')[0]; // YYYY-MM-DD format
                                  
                                html += `
                                    <tr>
                                        <td>${key+1}</td>
                                        <td>${element.supplier_name}</td>
                                        <td>${element.date}</td>
                                        <td>${element.total_amount}</td>
                                        <td>${formattedDate}</td>
                                        <td>
                                            <a href="javascript:void(0);" class="btn btn-primary btn-sm" onclick="show_detail_modal('${element.id}')"><i class="fa fa-eye"></i><a>
                                                <a href="/bills-edit/${element.id}" class="btn btn-warning btn-sm" ><i class="fa fa-edit"></i><a>
                                                <a href="javascript:void(0);" class="btn btn-danger btn-sm" onclick="delete_data('${element.id}')"><i class="fa fa-trash"></i><a>
                                        </td>
                                    </tr>
                                `;
                                });
                            }else{
                                html =`<tr>
                                            <td colspan="12" class="text-center">${response.message}</td>
                                        </tr>`;
                            }

                                $("#t-body").html(html);
                    }else if(response.status == false){
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
                    url: '/fetch_bills',
                    method: 'get',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
                    beforeSend: function() {
                        // $("#create_btn").attr('disabled', 'disabled').html('<div class="loader" disabled></div>');
                    },
                    success: function(response) {

                        // $("#create_btn").removeAttr('disabled', 'disabled').html('Create');
                        if (response.status == true) {
                          html = "";
                            if (response.data && response.data.length > 0) {
                                response.data.forEach((element,key)=> {
                                  
                                html += `
                                    <tr>
                                        <td>${key+1}</td>
                                        <td>${element.supplier_name}</td>
                                        <td>${element.date_only}</td>
                                        <td>${element.total_amount}</td>
                                        <td>${element.created_at_date}</td>
                                        <td>
                                            <a href="javascript:void(0);" class="btn btn-primary btn-sm" onclick="show_detail_modal('${element.id}')"><i class="fa fa-eye"></i><a>
                                                <a href="/bills-edit/${element.id}" class="btn btn-warning btn-sm" ><i class="fa fa-edit"></i><a>
                                                <a href="javascript:void(0);" class="btn btn-danger btn-sm" onclick="delete_data('${element.id}')"><i class="fa fa-trash"></i><a>
                                        </td>
                                    </tr>
                                `;
                                });
                            }else{
                                html =`<tr>
                                            <td colspan="12" class="text-center">Products not available</td>
                                        </tr>`;
                            }
                            
                                $("#t-body").html(html);
                        }else if(response.status == false){
                            html =`<tr>
                                            <td colspan="12" class="text-center">Products not available</td>
                                        </tr>`;
                                $("#t-body").html(html);

                            // sweetalert("bottom-end","error",response.message);
                        }
                    }
            });
    }
function show_detail_modal(id) {
    // alert(id);
    $.ajax({
        method: "get",
        url: "/fetch_bills_items",
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
            html = "";
            response.data.forEach((element,key) => {
                html += `
                <tr>
                    <td >${key+1}</td>
                    <td >${element.product_name}</td>
                    <td >${element.unit}</td>
                    <td >${element.qty}</td>
                    <td >${element.product_price}</td>
                    <td >${element.sub_total}</td>
                  </tr>
                `;
            });
            $("#t-body-1").html(html);
            $("#show_customer_detail").modal("show");
        }
    });
};

 // DELETE FUNCTION
 function delete_data(id) {
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
                url: '/delete_bills',
                method: 'get',
                data: {id},
                success: function(response) {
                    // $("#form-div").hide();
                    //   $("#classes").show();
                    if (response.status == true) {
                        sweetalert("top-end","success",response.message)                        
                        fetch_items();
                    }else{
                        fetch_items();
                        sweetalert("top-end","error",response.message)                        
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
        });
       
    }
</script>

@endsection