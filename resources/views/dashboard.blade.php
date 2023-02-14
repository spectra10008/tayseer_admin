@extends('layouts.app')
@section('title', 'الرئيسية')
@section('content')
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-left mb-0">Fixed Navbar</h2>
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="sk-layout-2-columns.html">Home</a>
                            </li>
                            <li class="breadcrumb-item"><a href="#">Starter Kit</a>
                            </li>
                            <li class="breadcrumb-item active">Fixed Navbar
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-header-right text-md-right col-md-3 col-12 d-md-block d-none">
            <div class="form-group breadcrum-right">
                <div class="dropdown">
                    <button class="btn-icon btn btn-primary btn-round btn-sm dropdown-toggle" type="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                            class="feather icon-settings"></i></button>
                    <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item" href="#">Chat</a><a
                            class="dropdown-item" href="#">Email</a><a class="dropdown-item"
                            href="#">Calendar</a></div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-body">
        <!-- Description -->
        <section id="description" class="card">
            <div class="card-header">
                <h4 class="card-title">Description</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="card-text">
                        <p>The fixed navbar layout has a fixed navbar and navigation menu and footer. Only
                            navbar section is fixed to user. In this page you can experience it.</p>
                    </div>
                </div>
            </div>
        </section>
        <!--/ Description -->
        <!-- CSS Classes -->
        <section id="css-classes" class="card">
            <div class="card-header">
                <h4 class="card-title">CSS Classes</h4>
            </div>
            <div class="card-content">
                <div class="card-body">
                    <div class="card-text">
                        <p>This table contains all classes related to the fixed navbar layout. This is a custom
                            layout classes for fixed navbar layout page requirements.</p>
                        <p>All these options can be set via following classes:</p>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Classes</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row"><code>.navbar-sticky</code></th>
                                        <td>To set navbar fixed you need to add <code>navbar-sticky</code> class
                                            in <code>&lt;body&gt;</code> tag.</td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><code>.fixed-top</code></th>
                                        <td>To set navbar fixed you need to add <code>fixed-top</code> class in
                                            <code>&lt;nav&gt;</code> tag.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--/ CSS Classes -->
        <!-- HTML Markup -->
        <section id="html-markup" class="card">
            <div class="card-header">
                <h4 class="card-title">HTML Markup</h4>
            </div>
            <div class="card-content collapse show">
                <div class="card-body">
                    <div class="card-text">
                        <p>This section contains HTML Markup to create fixed navbar layout. This markup define
                            where to add css classes to make navbar fixed. Navbar Menu has not spacing between
                            navigation menu and navbar menu.</p>
                        <p>Vuexy has a ready to use starter kit, you can use this layout directly by using the
                            starter kit pages from the
                            <code>vuexy-html-bootstrap-admin-template/starter-kit</code> folder.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <!--/ HTML Markup -->

    </div>
@endsection
