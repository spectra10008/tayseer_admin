<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="rtl">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    {{-- <meta name="description"
        content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app"> --}}
    <meta name="author" content="TJOINT">
    <title>لوحة التحكم - @yield('title')</title>
    <link rel="apple-touch-icon" href="{{ asset('/img/1.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/img/1.png') }}">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/vendors/css/vendors-rtl.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/vendors/css/ui/prism.min.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css-rtl/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css-rtl/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css-rtl/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css-rtl/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css-rtl/themes/dark-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css-rtl/themes/semi-dark-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css-rtl/pages/app-user.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/vendors/css/forms/select/select2.min.css') }}">

    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('/app-assets/css-rtl/core/menu/menu-types/vertical-menu.css') }}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css-rtl/custom-rtl.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/style-rtl.css') }}">
    <!-- END: Custom CSS-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700&display=swap"
        rel="stylesheet">
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->
<style>
    a,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    span {
        font-family: 'Tajawal', sans-serif
    }
</style>

<body class="vertical-layout vertical-menu-modern semi-dark-layout 2-columns  navbar-floating footer-static  " data-open="click"
    data-menu="vertical-menu-modern" data-col="2-columns" style="font-family: 'Tajawal', sans-serif;">

    <!-- BEGIN: Header-->
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <nav class="header-navbar navbar-expand-lg navbar navbar-with-menu fixed-top navbar-light navbar-shadow">
        <div class="navbar-wrapper">
            <div class="navbar-container content">
                <div class="navbar-collapse" id="navbar-mobile">

                    <ul class="nav navbar-nav float-left ml-auto">
                        {{-- <li class="dropdown dropdown-language nav-item">
                            <a class="dropdown-toggle nav-link" id="dropdown-flag" href="#" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"><i class="flag-icon flag-icon-us"></i><span
                                    class="selected-language">English</span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdown-flag">
                                <a class="dropdown-item" href="#" data-language="en"><i
                                        class="flag-icon flag-icon-us"></i>
                                    English</a>
                            </div>
                        </li> --}}
                        <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand"><i
                                    class="ficon feather icon-maximize"></i></a></li>
                        <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label read_all"
                                href="#" data-toggle="dropdown"><i class="ficon feather icon-bell"></i><span
                                    class="badge badge-pill badge-up notify_count"
                                    style="background-color: #e1141b">{{ $mfi_notifications->count() }}</span></a>
                            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                                <li class="dropdown-menu-header">
                                    <div class="dropdown-header m-0 p-2">
                                        <h3 class="white notify_count_new">{{ $mfi_notifications->count() }} </h3>
                                        <span class="grey darken-2">
                                            اشعارات التطبيق جديدة </span>
                                    </div>
                                </li>
                                <li class="scrollable-container media-list">
                                    @foreach ($mfi_notifications as $new_notification)
                                        <a class="d-flex justify-content-between" href="javascript:void(0)">
                                            <div class="media d-flex align-items-start">
                                                <div class="media-left"><i
                                                        class="feather icon-plus-square font-medium-5 primary"></i>
                                                </div>
                                                <div class="media-body">
                                                    <h6 class="primary media-heading">{{ $new_notification->title }}
                                                    </h6><small class="notification-text">
                                                        {{ $new_notification->content }}</small>
                                                </div><small>
                                                    <time class="media-meta"
                                                        datetime="2015-06-11T18:29:20+08:00">{{ $new_notification->created_at->diffForHumans() }}</time></small>
                                            </div>
                                        </a>
                                    @endforeach

                                </li>
                                <li class="dropdown-menu-footer"><a class="dropdown-item p-1 text-center"
                                        href="/panel-mfi/notifications">قراءة كل الاشعارات</a></li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-user nav-item"><a
                                class="dropdown-toggle nav-link dropdown-user-link" href="#"
                                data-toggle="dropdown">
                                <div class="user-nav d-sm-flex d-none"><span
                                        class="user-name text-bold-600">{{ Auth::user()->name }}</span><span
                                        class="user-status">متوفر</span></div><span><img class="round"
                                        src="{{ asset(Auth::guard('mfis_providers')->user()->profile_pic) }}" alt="avatar" height="40"
                                        width="40"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item"
                                    href="/panel-mfi/edit_profile"><i class="feather icon-user"></i>
                                    البروفايل</a>
                                <div class="dropdown-divider"></div><a class="dropdown-item"
                                    href="/panel-mfi/logout"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();"><i
                                        class="feather icon-power"></i> تسجيل
                                    الخروج</a>
                                <form id="logout-form" action="/panel-mfi/logout" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto"><a class="navbar-brand" href="/panel-mfi/dashboard">
                        <img src="{{ asset('/img/white.png') }}" alt="" width="70px">  <span class="ml-1 text-white" style="font-size: 24px">لوحة التحكم</span>
                    </a></li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i
                            class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i
                            class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block primary"
                            data-ticon="icon-disc"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content" style="margin-top: 10px">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                <li class="nav-item  {{ request()->is('panel-mfi/dashboard') ? 'active' : '' }}"><a
                        href="/panel-mfi/dashboard"><i class="feather icon-home"></i><span class="menu-title"
                            data-i18n="Dashboard">الرئيسية</span></a>
                </li>
                <li class=" navigation-header"><span>القائمة</span>
                </li>
                <li class="nav-item {{ request()->is('panel-mfi/form-requets') ? 'active' : '' }}"><a
                        href="/panel-mfi/form-requets"><i class="fa fa-file-text-o"></i><span class="menu-title"
                            data-i18n="Email">طلبات التمويل</span></a>
                </li>
                <li class="nav-item {{ request()->is('panel-mfi/loans') ? 'active' : '' }}"><a
                        href="/panel-mfi/loans"><i class="fa fa-folder-open"></i><span class="menu-title"
                            data-i18n="Email">القروض</span></a>
                </li>
                <li class="nav-item {{ request()->is('panel-mfi/installments') ? 'active' : '' }}"><a
                        href="/panel-mfi/installments"><i class="fa fa-money"></i><span class="menu-title"
                            data-i18n="Email">الأقساط</span></a>
                </li>
                <li class="nav-item {{ request()->is('panel-mfi/vendors') ? 'active' : '' }}"><a
                        href="/panel-mfi/vendors"><i class="fa fa-shopping-cart"></i><span class="menu-title"
                            data-i18n="Email">التجار</span></a>
                </li>
                <li class=" navigation-header"><span>الإعدادات</span>
                </li>
                <li class="nav-item {{ request()->is('panel-mfi/mfi-users') ? 'active' : '' }}"><a
                        href="/panel-mfi/mfi-users"><i class="fa fa-users"></i><span class="menu-title"
                            data-i18n="Email">مستخدمين
                            النظام</span></a>
                </li>
            </ul>
        </div>
    </div>
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light">
        <p class="clearfix blue-grey lighten-2 mb-0"><span class="float-md-left d-block d-md-inline-block mt-25">حقوق
                الطبع {{ date('Y') }}<a class="text-bold-800 grey darken-2" href="https://tjoint-finance.com"
                    target="_blank">تي جوينت للخدمات المتكاملة ,</a>كل الحقوق محفوظة</span><span
                class="float-md-right d-none d-md-block">Hand-crafted & Made with<i
                    class="feather icon-heart pink"></i></span>
            <button class="btn btn-primary btn-icon scroll-top" type="button"><i
                    class="feather icon-arrow-up"></i></button>
        </p>
    </footer>
    <!-- END: Footer-->


    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('/app-assets/vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('/app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>


    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('/app-assets/vendors/js/ui/prism.min.js') }}"></script>
    <script src="{{ asset('/app-assets/js/scripts/pages/app-user.js') }}"></script>
    <script src="{{ asset('/app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>

    <!-- END: Page Vendor JS-->
    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('/app-assets/vendors/js/tables/datatable/pdfmake.min.js') }}"></script>
    <script src="{{ asset('/app-assets/vendors/js/tables/datatable/vfs_fonts.js') }}"></script>
    <script src="{{ asset('/app-assets/vendors/js/tables/datatable/datatables.min.js') }}"></script>
    <script src="{{ asset('/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js') }}"></script>
    <script src="{{ asset('/app-assets/vendors/js/tables/datatable/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('/app-assets/vendors/js/tables/datatable/buttons.print.min.js') }}"></script>
    <script src="{{ asset('/app-assets/vendors/js/tables/datatable/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('/app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
    <!-- END: Page Vendor JS-->


    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('/app-assets/js/core/app-menu.js') }}"></script>
    <script src="{{ asset('/app-assets/js/core/app.js') }}"></script>
    <script src="{{ asset('/app-assets/js/scripts/forms/select/form-select2.js') }}"></script>

    <!-- BEGIN: Page JS-->
    <script src="{{ asset('/app-assets/js/scripts/datatables/datatable.js') }}"></script>
    <script>
        $('#datepicker').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'yyyy-mm-dd'
        });

        $('#datepicker2').datepicker({
            uiLibrary: 'bootstrap4',
            format: 'yyyy-mm-dd'
        });
    </script>
    <!-- END: Page JS-->
    <!-- END: Theme JS-->
    @yield('scriptjs')
    <!-- BEGIN: Page JS-->
    <!-- END: Page JS-->
    <script>
        $(".read_all").click(function() {
            $.get("/panel-mfi/notifications_read", function(data, status) {
                console.log('success')
                $('.notify_count').text(0);
            });
        });
    </script>
</body>
<!-- END: Body-->

</html>
