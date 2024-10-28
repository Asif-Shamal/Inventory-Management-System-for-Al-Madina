<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $direction ?? 'ltr' }}">
    <head>
        <meta charset="utf-8" />
        <title>Al-Madina</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta
            content="Premium Multipurpose Admin & Dashboard Template"
            name="description"
        />
        <meta content="Themesdesign" name="author" />

        <!-- App favicon -->
        <link
            rel="shortcut icon"
            href="{{ asset('backend/assets/images/favicon.ico') }}"
        />

        <!-- Select 2 -->
        <link
            href="{{ asset('backend/assets/libs/select2/css/select2.min.css') }}"
            rel="stylesheet"
            type="text/css"
        />
        <!-- end Select 2  -->

        <!-- jquery.vectormap css -->
        <link
            href="{{ asset('backend/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}"
            rel="stylesheet"
            type="text/css"
        />

        <!-- DataTables -->
        <link
            href="{{ asset('backend/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}"
            rel="stylesheet"
            type="text/css"
        />

        <!-- Responsive datatable examples -->
        <link
            href="{{ asset('backend/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
            rel="stylesheet"
            type="text/css"
        />

        <!-- Bootstrap Css -->
        <link
            href="{{ asset('backend/assets/css/bootstrap.min.css') }}"
            id="bootstrap-style"
            rel="stylesheet"
            type="text/css"
        />
        <!-- Icons Css -->
        <link
            href="{{ asset('backend/assets/css/icons.min.css') }}"
            rel="stylesheet"
            type="text/css"
        />
        <!-- App Css-->
        <link
            href="{{ asset('backend/assets/css/app.min.css') }}"
            id="app-style"
            rel="stylesheet"
            type="text/css"
        />

        <link
            rel="stylesheet"
            type="text/css"
            href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
        />

        {{-- Bootstrap rtl --}}
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css"
            integrity="sha384-gXt9imSW0VcJVHezoNQsP+TNrjYXoGcrqBZJpry9zJt8PCQjobwmhMGaDHTASo9N"
            crossorigin="anonymous"
        />

        {{-- charts --}}

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        {{-- persian font --}}
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?          family=Amiri:ital,wght@0,400;0,700;1,400;1,700&family=Noto+Nastaliq+Urdu:wght@400..7        00&family=Noto+Sans+Arabic:wght@100..900&family=Vazirmatn:wght@100..900&display=swap        "
            rel="stylesheet"
        />
        {{-- Language style important --}}
        <link
            rel="stylesheet"
            type="text/css"
            href="{{ asset('css/langStyle.css') }}"
        />

    </head>

    <body data-topbar="dark">
        
        {{-- Spinner --}}
        <div class="spinner-wrapper">
            <div class="spinner-border text-danger" role="status">
                <span class="visually-hidden">Loading</span>
            </div>
        </div>

        <!-- <body data-layout="horizontal" data-topbar="dark"> -->

        <!-- Begin page -->
        <div id="layout-wrapper">
            <header>@include('admin.body.header')</header>

            @include('admin.body.sidebar')
            <!-- ========== Left Sidebar Start ========== -->
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div>
                {{-- main-content --}}
                <main 
                    class=" {{ app()->getLocale() === 'fa' ? 'container' : 'main-content' }}"
                >
                    @yield('admin') @include('admin.body.footer')

                    <!-- End Page-content -->
                </main>
            </div>
            <!-- end main content-->
        </div>
        <!-- END layout-wrapper -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- JAVASCRIPT -->

        <script src="{{ asset('backend/assets/libs/jquery/jquery.min.js') }}"></script>

        <!-- loading spinner -->
        <script src="{{ asset('js/spinner.js') }}"></script>

        <script src="{{ asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('backend/assets/libs/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ asset('backend/assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('backend/assets/libs/node-waves/waves.min.js') }}"></script>

        <!-- apexcharts -->
        <script src="{{ asset('backend/assets/libs/apexcharts/apexcharts.min.js') }}"></script>

        <!-- jquery.vectormap map -->
        <script src="{{ asset('backend/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
        <script src="{{ asset('backend/assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js') }}"></script>

        <!-- Required datatable js -->
        <script src="{{ asset('backend/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('backend/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

        <!-- Responsive examples -->
        <script src="{{ asset('backend/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('backend/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

        <script src="{{ asset('backend/assets/js/pages/dashboard.init.js') }}"></script>

        <!-- App js -->
        <script src="{{ asset('backend/assets/js/app.js') }}"></script>

        <script
            type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        ></script>

        <script>
            @if(Session::has('message'))
            var type = "{{ Session::get('alert-type','info') }}"
            switch(type){
               case 'info':
               toastr.info(" {{ Session::get('message') }} ");
               break;

               case 'success':
               toastr.success(" {{ Session::get('message') }} ");
               break;

               case 'warning':
               toastr.warning(" {{ Session::get('message') }} ");
               break;

               case 'error':
               toastr.error(" {{ Session::get('message') }} ");
               break;
            }
            @endif
        </script>

        
        <!-- Required datatable js -->
        <script src="{{ asset('backend/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('backend/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

        <!-- Datatable init js -->
        {{-- searchBar --}}
        <script src="{{ asset('backend/assets/js/pages/datatables.init.js') }}"></script>

        <script src="{{ asset('backend/assets/js/validate.min.js') }}"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

        <script src="{{ asset('backend/assets/js/code.js') }}"></script>

        <script src="{{ asset('backend/assets/js/handlebars.js') }}"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>

        <!--  For Select2 -->
        <script src="{{ asset('backend/assets/libs/select2/js/select2.min.js') }}"></script>
        <script src="{{ asset('backend/assets/js/pages/form-advanced.init.js') }}"></script>
        <!-- end  For Select2 -->
    </body>
</html>
