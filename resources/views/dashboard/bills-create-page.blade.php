@extends('dashboard.layout.admin_layout')
@section('content')
<div class="container-fluid">
    <form id="create_products_form"  enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-3">
                    <h5 class="text-center">Bill Create</h5>
                    <div class="card-body">								
                        <div class="row" id="add-row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title">Supplier Name</label>
                                    <input type="text" name="supplier_name" id="supplier_name" class="form-control" >	
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title">Date</label>
                                    <input type="date" name="date" id="date" class="form-control" >	
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="title">Item Name</label>
                                    <select name="product_name[]"  class="form-select product_name">
                                        <option  value=""  selected >select product</option>
                                            @foreach ($products as $item)
                                                <option  value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                    </select>                                    
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="" class="form-label">Measure Unit</label>
                                    <input type="text" readonly name="product_unit[]" id="unit" class="form-control unit"  placeholder="">
                                </div>
                            </div>   
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Quantity</label>
                                    <input type="number" name="qty[]" min="0" id="qty" class="form-control "  placeholder="Quantity">
                                </div>
                            </div>                                          
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Price</label>
                                    <input type="number" name="price[]" min="0" id="price" class="form-control "  placeholder="Price">
                                </div>
                            </div>   
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Sub Total</label>
                                    <input type="number" name="sub_total[]"  id="sub_total" class="form-control "  placeholder="Sub-Total" readonly>
                                </div>
                            </div>   
                            <div class="col-md-2">
                                <div class="mb-3">
                                    <label for="description" class="form-label"></label>
                                    <button type="button" class="btn w-100 btn-success" id="add-row-btn"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>    
                        </div>
                        <div class="col-md-10 text-end">
                            <div class="mb-3 me-5">
                                <span class="fw-bold">Total: </span><span  class="fw-bold" id="total">00.00</span>
                                <input type="hidden" id="total-amount" name="total_amount">
                            </div>
                        </div>  
                    </div>
                </div>
            </div>
        </div>	
        <div class="pb-5 pt-3">
            <button type="submit" id="create_btn" class="btn btn-sm btn-primary">Create</button>
            <a href="/admin/bills" class="btn btn-sm btn-outline-dark ml-3">Cancel</a>
        </div>
    </form>
</div>
@endsection
@section('javascript')
    
<script>
    $(".product_name").change(function(){
       var product_id = [];
       product_id = $(this).val();
    //    alert(product_id);
       $.ajax({
                   url: '/get_item_unit',
                   method: 'POST',
                   data: {id: product_id},
                   headers: { 
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                   },
                   beforeSend: function() {
                    //    $("#create_btn").attr('disabled', 'disabled').html('<div class="loader" disabled></div>');
                   },
                   success: function(response) {
                    //    $("#create_btn").removeAttr('disabled', 'disabled').html('Create');
                       if (response.status == true) {
                            $(".unit").val(response.unit.unit);
                       }else if(response.status == false){
                        
                       }
                   }
           });
   });
$(document).ready(function() {
   // Function to calculate subtotal
   function calculateSubtotal() {
       var total = 0;  // Initialize the total to 0
       $('[id^=qty]').each(function(index, element) {  // Loop through each element with an id starting with 'qty'
           var rowId = $(this).attr('id').replace('qty', '');  // Get the row ID by removing 'qty' from the element's id
           var qty = parseFloat($(this).val()) || 0;  // Get the quantity value, default to 0 if it's not a number
           var price = parseFloat($('#price' + rowId).val()) || 0;  // Get the price value for the same row, default to 0 if it's not a number
           var subtotal = qty * price;  // Calculate the subtotal for the row
           $('#sub_total' + rowId).val(subtotal);  // Set the subtotal value in the corresponding input field, formatted to 2 decimal places
           total += subtotal;  // Add the row's subtotal to the total
       });
       $('#total').text(total);  // Update the total displayed on the page, formatted to 2 decimal places
       $('#total-amount').val(total);  // Update the total displayed on the page, formatted to 2 decimal places
   }

   // Bind event listeners to the existing fields
   $('#qty, #price').on('input', function() {  // Attach an event listener to the qty and price fields for the 'input' event
       calculateSubtotal();  // Call the calculateSubtotal function whenever the qty or price values change
   });

  
   // Add new row
   var row = 1;
   sessionStorage.setItem('selectedProducts',row);
   $("#add-row-btn").on("click", function() {
       var newRow = `
           <div class="delete-row" style="display: contents;">
               <div class="col-md-2 mt-2">
                   <div class="mb-3">
                       <select name="product_name[]" id="product_name${row}" class="form-select product_name">
                           <option value="" selected>select product</option>
                               @foreach ($products as $item)
                                   <option value="{{$item->id}}">{{$item->name}}</option>
                               @endforeach
                       </select>
                   </div>
               </div>
               <div class="col-md-2 mt-2">
                   <div class="mb-3">
                       <input type="text" name="product_unit[]" id="unit${row}" class="form-control" placeholder="Unit">
                   </div>
               </div>  
               <div class="col-md-2 mt-2">
                   <div class="mb-3">
                       <input type="number" name="qty[]" id="qty${row}" class="form-control" placeholder="Quantity">
                   </div>
               </div>   
               <div class="col-md-2 mt-2">
                   <div class="mb-3">
                       <input type="number" name="price[]" id="price${row}" class="form-control" placeholder="Price">
                   </div>
               </div>                                           
               <div class="col-md-2 mt-2">
                   <div class="mb-3">
                       <input type="number" name="sub_total[]" id="sub_total${row}" class="form-control" placeholder="Sub Total" readonly>
                   </div>
               </div>
               <div class="col-md-2 mt-2">
                   <div class="mb-3">
                       <button type="button" class="btn w-100 btn-danger remove-row-btn"><i class="fa fa-minus"></i></button>
                   </div>
               </div> 
           </div>`;
       $('#add-row').append(newRow);

       // Bind event listeners to the new fields
       $('#qty' + row + ', #price' + row).on('input', function() {
           calculateSubtotal();
       });

       row++;
       sessionStorage.setItem('selectedProducts',row);
   });

   // Remove row
   $(document).on("click", ".remove-row-btn", function() {
       $(this).closest('.delete-row').remove();
       calculateSubtotal();
       row--;
       // sessionStorage.setItem('selectedProducts',row); 
   });
});

      $.ajaxSetup({
            headers: { 
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
   var arrayList = ['supplier_name','date','product_name','price','qty','sub_total'];

    $("#create_products_form").submit(function(e){
        e.preventDefault();
    //    const errors = [];
    //    var permission = 0;
    //    for (let i = 0; i < arrayList.length; i++) {
    //       var check = $("#"+arrayList[i]).val();
    //    //    alert(check);
    //         if (check == '') {
    //                     permission++;
    //                     // sweetalert("bottom-end","error","please enter "+arrayList[i]);  
    //                     if (arrayList[i] === "supplier_name") {
    //                         errors.push("supplier name fieled is required");
    //                     }else if(arrayList[i] === "date"){
    //                         errors.push("date fieled is required");
    //                     }else if(arrayList[i] === "product_name"){
    //                         errors.push("product name fieled is required");
    //                     }else if(arrayList[i] === "price"){
    //                         errors.push("price fieled is required");
    //                     }else if(arrayList[i] === "qty"){
    //                         errors.push("quantity fieled is required");
    //                     }
    //         }
    //     }

        // if (permission !== 0) {
        //     const errorList = errors.map(error => `<li>${error}</li>`).join('');

        //     Swal.fire({
        //         icon: "error",
        //         title: "Error!",
        //         html: `<ul style="list-style:none;color:red;">${errorList}</ul>`,
        //     });
        // }


       // alert("hit");
       var formData = new FormData($('#create_products_form')[0]); // Create FormData object with the form data
           $.ajax({
                   url: '/bill_create',
                   method: 'POST',
                   data: formData,
                   contentType:false,
                   processData:false,
                   headers: { 
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                   },
                   beforeSend: function() {
                       $("#create_btn").attr('disabled', 'disabled').html('<div class="loader" disabled></div>');
                   },
                   success: function(response) {
                       $("#create_btn").removeAttr('disabled', 'disabled').html('Create');
                       if (response.status == true) {
                           // sweetalert("bottom-end","success",response.message);
                           // $("#form-div").hide();
                           // $("#classes").show();
                           // table.ajax.reload(); 
                           // $("#Modalusercreate").modal("hide"); 
                           $("#create_products_form")[0].reset();
                           location.assign("/bills");
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

  
</script>

@endsection