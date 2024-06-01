@extends('dashboard.layout.admin_layout')
@section('content')
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
@endsection