<?php $__env->startSection('body-attributes'); ?>
    class="homepage1-body"
<?php $__env->stopSection(); ?>

<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('layouts.partials.header.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('layouts.partials.mobile-nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
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
                            <span><a href=<?php echo e(route('any', 'index')); ?>>Home</a></span>
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
                                <a href=<?php echo e(route('any', 'index')); ?> class="header-btn1">Back To Home <span><i class="fa-solid fa-arrow-right"></i></span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--===== 404 AREA ENDS =======-->

    <?php echo $__env->make('layouts.partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', ['title' => '404'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH I:\Helpy\resources\views/pages/404.blade.php ENDPATH**/ ?>