<!DOCTYPE html>
<html lang="en" <?php echo $__env->yieldContent('html-attributes'); ?>>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(isset($title) ? $title : 'Helpmore'); ?>-Charity and Fundraising Template</title>

    <!--=====FAB ICON=======-->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($logo2)): ?>
        <link rel="shortcut icon" href="/img/logo/fav-logo2.png" type="image/x-icon">
    <?php elseif(isset($logo3)): ?>
        <link rel="shortcut icon" href="/img/logo/fav-logo3.png" type="image/x-icon">
    <?php elseif(isset($logo4)): ?>
        <link rel="shortcut icon" href="/img/logo/fav-logo4.png" type="image/x-icon">
    <?php elseif(isset($logo5)): ?>
        <link rel="shortcut icon" href="/img/logo/fav-logo5.png" type="image/x-icon">
    <?php else: ?>
        <link rel="shortcut icon" href="/img/logo/fav-logo1.png" type="image/x-icon">
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!--===== CSS LINK =======-->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/scss/main.scss']); ?>

    <?php echo $__env->yieldContent('css'); ?>

</head>

<body <?php echo $__env->yieldContent('body-attributes'); ?>>

    <?php echo $__env->make('layouts.partials.preloader', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php echo $__env->yieldContent('header'); ?>

    <?php echo $__env->yieldContent('content'); ?>

    <!--===== Scroll Top =======-->
    <div class="paginacontainer">
        <div class="progress-wrap">
            <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
                <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
            </svg>
        </div>
    </div>

    <?php echo $__env->yieldContent('scripts'); ?>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/main.js']); ?>
</body>

</html>
<?php /**PATH I:\Helpy\resources\views\layouts\base.blade.php ENDPATH**/ ?>