<?php $__env->startSection('body-attributes'); ?>
    class="homepage1-body"
<?php $__env->stopSection(); ?>

<?php $__env->startSection('header'); ?>
    <?php echo $__env->make('layouts.partials.header.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->make('layouts.partials.mobile-nav', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <!--===== BREADCRUMB AREA STARTS =======-->
    <section class="vl-breadcrumb" style="background-image: url(/img/breadcrumb/vl-event-bg.png);">
        <div class="shape1"><img src="/img/breadcrumb/breadcrumb-shape-1.1.png" alt=""></div>
        <div class="shape2"><img src="/img/breadcrumb/breadcrumb-shape-1.2.png" alt=""></div>
        <div class="shape2"><img src="/img/breadcrumb/breadcrumb-shape-1.3.png" alt=""></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="vl-breadcrumb-title">
                        <h2 class="heading">Events</h2>
                        <div class="vl-breadcrumb-list">
                            <span><a href=<?php echo e(route('any', 'index')); ?>>Home</a></span>
                            <span class="dvir"><i class="fa-solid fa-angle-right"></i></span>
                            <span><a class="active" href="#">Events</a></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--===== BREADCRUMB AREA ENDS =======-->

    <section class="vl-singlevent-iner sp1">
        <div class="container">
            <div class="row">
                <!-- single event item -->
                <div class="col-lg-12 mb-50">
                    <div class="event-bg-flex active">
                        <div class="event-date">
                            <h3 class="title">01</h3>
                            <p class="year">JAN <br> 2025</p>
                        </div>
                        <div class="event-content">
                            <div class="event-meta">
                                <p class="para">April 3, 2025 @ 8:00 am - January 9, 2025 @ 5:00 pm</p>
                            </div>
                            <a href=<?php echo e(route('second', ['events', 'single'])); ?> class="title">Unity Giving Community Charity Event</a>
                            <p class="para">Vineyard Venues 5396 North Reese Avenue, Fresno <br> CA 93722, Fresno CA, CA, United States</p>
                            <a href=<?php echo e(route('second', ['events', 'single'])); ?> class="details">Event Details <span><i class="fa-solid fa-arrow-right"></i></span></a>
                        </div>
                        <div class="event-thumb">
                            <img class="w-100" src="/img/event/vl-event-thumb-1.1.png" alt="">
                        </div>
                    </div>
                </div>
                <!-- single event item -->
                <div class="col-lg-12 mb-50">
                    <div class="event-bg-flex">
                        <div class="event-date">
                            <h3 class="title">08</h3>
                            <p class="year">JAN <br> 2025</p>
                        </div>
                        <div class="event-content">
                            <div class="event-meta">
                                <p class="para">April 3, 2025 @ 8:00 am - January 9, 2025 @ 5:00 pm</p>
                            </div>
                            <a href=<?php echo e(route('second', ['events', 'single'])); ?> class="title">Harmony of Hearts Charity Concert content</a>
                            <p class="para">Vineyard Venues 5396 North Reese Avenue, Fresno <br> CA 93722, Fresno CA, CA, United States</p>
                            <a href=<?php echo e(route('second', ['events', 'single'])); ?> class="details">Event Details <span><i class="fa-solid fa-arrow-right"></i></span></a>
                        </div>
                        <div class="event-thumb">
                            <img class="w-100" src="/img/event/vl-event-thumb-1.2.png" alt="">
                        </div>
                    </div>
                </div>

                <!-- single event item -->
                <div class="col-lg-12 mb-50">
                    <div class="event-bg-flex">
                        <div class="event-date">
                            <h3 class="title">11</h3>
                            <p class="year">JAN <br> 2025</p>
                        </div>
                        <div class="event-content">
                            <div class="event-meta">
                                <p class="para">April 3, 2025 @ 8:00 am - January 9, 2025 @ 5:00 pm</p>
                            </div>
                            <a href=<?php echo e(route('second', ['events', 'single'])); ?> class="title">Empowerment through Giving Charity Ball</a>
                            <p class="para">Vineyard Venues 5396 North Reese Avenue, Fresno <br> CA 93722, Fresno CA, CA, United States</p>
                            <a href=<?php echo e(route('second', ['events', 'single'])); ?> class="details">Event Details <span><i class="fa-solid fa-arrow-right"></i></span></a>
                        </div>
                        <div class="event-thumb">
                            <img class="w-100" src="/img/event/vl-event-thumb-1.3.png" alt="">
                        </div>
                    </div>
                </div>

                <!-- single event item -->
                <div class="col-lg-12 mb-50">
                    <div class="event-bg-flex">
                        <div class="event-date">
                            <h3 class="title">13</h3>
                            <p class="year">JAN <br> 2025</p>
                        </div>
                        <div class="event-content">
                            <div class="event-meta">
                                <p class="para">April 3, 2025 @ 8:00 am - January 9, 2025 @ 5:00 pm</p>
                            </div>
                            <a href=<?php echo e(route('second', ['events', 'single'])); ?> class="title">Spread the Love Charity Art Exhibition</a>
                            <p class="para">Vineyard Venues 5396 North Reese Avenue, Fresno <br> CA 93722, Fresno CA, CA, United States</p>
                            <a href=<?php echo e(route('second', ['events', 'single'])); ?> class="details">Event Details <span><i class="fa-solid fa-arrow-right"></i></span></a>
                        </div>
                        <div class="event-thumb">
                            <img class="w-100" src="/img/event/vl-event-thumb-1.4.png" alt="">
                        </div>
                    </div>
                </div>

                <!-- single event item -->
                <div class="col-lg-12 mb-50">
                    <div class="event-bg-flex">
                        <div class="event-date">
                            <h3 class="title">24</h3>
                            <p class="year">JAN <br> 2025</p>
                        </div>
                        <div class="event-content">
                            <div class="event-meta">
                                <p class="para">April 3, 2025 @ 8:00 am - January 9, 2025 @ 5:00 pm</p>
                            </div>
                            <a href=<?php echo e(route('second', ['events', 'single'])); ?> class="title">Lives Golf Charity Networking Event</a>
                            <p class="para">Vineyard Venues 5396 North Reese Avenue, Fresno <br> CA 93722, Fresno CA, CA, United States</p>
                            <a href=<?php echo e(route('second', ['events', 'single'])); ?> class="details">Event Details <span><i class="fa-solid fa-arrow-right"></i></span></a>
                        </div>
                        <div class="event-thumb">
                            <img class="w-100" src="/img/event/vl-event-thumb-1.5.png" alt="">
                        </div>
                    </div>
                </div>

                <!-- single event item -->
                <div class="col-lg-12 mb-50">
                    <div class="event-bg-flex">
                        <div class="event-date">
                            <h3 class="title">29</h3>
                            <p class="year">JAN <br> 2025</p>
                        </div>
                        <div class="event-content">
                            <div class="event-meta">
                                <p class="para">April 3, 2025 @ 8:00 am - January 9, 2025 @ 5:00 pm</p>
                            </div>
                            <a href=<?php echo e(route('second', ['events', 'single'])); ?> class="title">Shine for a Cause Charity Dinner & Auction</a>
                            <p class="para">Vineyard Venues 5396 North Reese Avenue, Fresno <br> CA 93722, Fresno CA, CA, United States</p>
                            <a href=<?php echo e(route('second', ['events', 'right'])); ?> class="details">Event Details <span><i class="fa-solid fa-arrow-right"></i></span></a>
                        </div>
                        <div class="event-thumb">
                            <img class="w-100" src="/img/event/vl-event-thumb-1.6.png" alt="">
                        </div>
                    </div>
                </div>
            </div>

            <!-- pagination -->
            <div class="row">
                <div class="col-12 m-auto">
                    <div class="theme-pagination thme-pagination-mt text-center mt-18">
                        <ul>
                            <li><a href="#"><i class="fa-solid fa-angle-left"></i></a></li>
                            <li><a class="active" href="#">01</a></li>
                            <li><a href="#">02</a></li>
                            <li>...</li>
                            <li><a href="#">12</a></li>
                            <li><a href="#"><i class="fa-solid fa-angle-right"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php echo $__env->make('layouts.partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.base', ['title' => 'Event'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH I:\Helpy\resources\views\events\event.blade.php ENDPATH**/ ?>