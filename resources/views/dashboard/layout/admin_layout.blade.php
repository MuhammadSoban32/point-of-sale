<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset("/dashboard/vendor/fontawesome-free/css/all.min.css") }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset("/dashboard/css/sb-admin-2.min.css") }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<style>
    /* HTML: <div class="loader"></div> */
.loader {
  width: 28px;
  padding: 8px;
  aspect-ratio: 1;
  border-radius: 50%;
  background: #ffff;
  --_m: 
    conic-gradient(#0000 10%,#000),
    linear-gradient(#000 0 0) content-box;
  -webkit-mask: var(--_m);
          mask: var(--_m);
  -webkit-mask-composite: source-out;
          mask-composite: subtract;
  animation: l3 1s infinite linear;
}
@keyframes l3 {to{transform: rotate(1turn)}}
.loader-background {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Dims the background */
            z-index: 9998;
            align-items: center;
            justify-content: center;
        }
</style>
<body id="page-top">
    
    <!-- Page Wrapper -->
    <div id="wrapper">
        
      {{-- @include('dashboard.attachments.sidebar') --}}
        <!-- Sidebar -->
        @include('dashboard.components.sidebar')
        <!-- End of Sidebar -->
     
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                @include('dashboard.components.header')
                <!-- End of Topbar -->
                
                   <!-- Begin Page Content -->
                        @yield('content')
                   <!-- End of Main Content -->

            <!-- Footer -->
            {{-- @include('dashboard.attachments.footer') --}}
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->
            
            </div>
            <!-- End of Content Wrapper -->
            
            </div>
            <!-- End of Page Wrapper -->
            
            <!-- Scroll to Top Button-->
            <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
            </a>
            
            <!-- Logout Modal-->
            <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="/logout">Logout</a>
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
            
            <!-- Page level plugins -->
            <script src="{{ asset("/dashboard/vendor/chart.js/Chart.min.js") }}"></script>
            
            <!-- Page level custom scripts -->
            <script src="{{ asset("/dashboard/js/demo/chart-area-demo.js") }}"></script>
            <script src="{{ asset("/dashboard/js/demo/chart-pie-demo.js") }}"></script>
            {{-- SWEETALERT CDN --}}
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
            <script>
                // SWEET ALERT FUNCTION 
                function sweetalert(position,icon,message) {
                        const Toast = Swal.mixin({
                        toast: true,
                        position: position,
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.onmouseenter = Swal.stopTimer;
                            toast.onmouseleave = Swal.resumeTimer;
                        }
                        });
                        Toast.fire({
                        icon: icon,
                        title: message
                        });
                    }
            </script>
            @yield('javascript')
</body>
</html>