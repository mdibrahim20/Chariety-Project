@extends('layouts.base', ['title' => '404'])

@section('body-attributes')
    class="homepage1-body"
@endsection

@section('header')
    @include('layouts.partials.header.navbar')
    @include('layouts.partials.mobile-nav')
@endsection

@section('content')
    <!--===== BREADCRUMB AREA STARTS =======-->
    <section class="vl-breadcrumb" style="background-image: url(/img/breadcrumb/vl-error-bg.png);">
        <div class="shape1"><img src="/img/breadcrumb/breadcrumb-shape-1.1.png" alt=""></div>
        <div class="shape2"><img src="/img/breadcrumb/breadcrumb-shape-1.2.png" alt=""></div>
        <div class="shape2"><img src="/img/breadcrumb/breadcrumb-shape-1.3.png" alt=""></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="vl-breadcrumb-title">
                        <h2 class="heading">Error 404</h2>
                        <div class="vl-breadcrumb-list">
                            <span><a href={{ route('any', 'index') }}>Home</a></span>
                            <span class="dvir"><i class="fa-solid fa-angle-right"></i></span>
                            <span><a class="active" href="#">Error 404</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--===== BREADCRUMB AREA ENDS =======-->

    <!--===== 404 AREA ENDS =======-->
    <section class="vl-error-section sp1">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="error-content text-center">
                        <!-- thumbnail -->
                        <div class="thumb">
                            <img class="w-100" src="/img/error/vl-error-thmb.png" alt="">
                        </div>
                        <!-- content -->
                        <div class="content">
                            <h4 class="title"> Sorry, Page Not Found!</h4>
                            <p class="para">Sorry, the page you are looking for doesn’t exist or <br> has been moved. Here are some helpful links.</p>
                            <div class="btn-area">
                                <a href={{ route('any', 'index') }} class="header-btn1">Back To Home <span><i class="fa-solid fa-arrow-right"></i></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--===== 404 AREA ENDS =======-->

    @include('layouts.partials.footer')
@endsection
