<div>
    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hero && $hero->is_active): ?>
        <section class="breadcrumb-area" style="background-image: url('<?php echo e($hero->background_image_url); ?>'); background-size: cover; background-position: center; position: relative;">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hero->overlay_enabled): ?>
                <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,<?php echo e($hero->overlay_opacity / 100); ?>);"></div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <div class="container" style="position: relative; z-index: 1;">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="breadcrumb-content text-center">
                            <h2 class="breadcrumb-title text-white"><?php echo e($hero->page_title); ?></h2>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb justify-content-center">
                                    <li class="breadcrumb-item"><a href="/" class="text-white"><?php echo e($hero->breadcrumb_home_label ?? 'Home'); ?></a></li>
                                    <li class="breadcrumb-item active text-white" aria-current="page"><?php echo e($hero->breadcrumb_current_label ?? 'Our Volunteers'); ?></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <section class="volunteers-section py-5">
        <div class="container">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($volunteers->isNotEmpty()): ?>
                <div class="row g-4">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $volunteers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $volunteer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="volunteer-card text-center h-100 bg-white rounded shadow-sm p-4 position-relative">
                                
                                <div class="volunteer-photo mb-3 mx-auto" style="width: 150px; height: 150px;">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($volunteer->profile_photo): ?>
                                        <img src="<?php echo e($volunteer->profile_photo_url); ?>" alt="<?php echo e($volunteer->name); ?>" 
                                             class="img-fluid rounded-circle" 
                                             style="width: 100%; height: 100%; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" 
                                             style="width: 100%; height: 100%;">
                                            <i class="bi bi-person text-white" style="font-size: 64px;"></i>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                
                                <h5 class="volunteer-name mb-1"><?php echo e($volunteer->name); ?></h5>

                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($volunteer->designation): ?>
                                    <p class="volunteer-designation text-muted mb-3"><?php echo e($volunteer->designation); ?></p>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($volunteer->has_social_links): ?>
                                    <div class="volunteer-social mt-3 d-flex justify-content-center gap-2">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($volunteer->sanitized_facebook_url): ?>
                                            <a href="<?php echo e($volunteer->sanitized_facebook_url); ?>" target="_blank" 
                                               class="btn btn-sm btn-outline-primary rounded-circle" 
                                               style="width: 36px; height: 36px; padding: 0; display: flex; align-items: center; justify-content: center;"
                                               rel="noopener noreferrer">
                                                <i class="bi bi-facebook"></i>
                                            </a>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($volunteer->sanitized_instagram_url): ?>
                                            <a href="<?php echo e($volunteer->sanitized_instagram_url); ?>" target="_blank" 
                                               class="btn btn-sm btn-outline-danger rounded-circle" 
                                               style="width: 36px; height: 36px; padding: 0; display: flex; align-items: center; justify-content: center;"
                                               rel="noopener noreferrer">
                                                <i class="bi bi-instagram"></i>
                                            </a>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($volunteer->sanitized_twitter_url): ?>
                                            <a href="<?php echo e($volunteer->sanitized_twitter_url); ?>" target="_blank" 
                                               class="btn btn-sm btn-outline-info rounded-circle" 
                                               style="width: 36px; height: 36px; padding: 0; display: flex; align-items: center; justify-content: center;"
                                               rel="noopener noreferrer">
                                                <i class="bi bi-twitter"></i>
                                            </a>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($volunteer->sanitized_linkedin_url): ?>
                                            <a href="<?php echo e($volunteer->sanitized_linkedin_url); ?>" target="_blank" 
                                               class="btn btn-sm btn-outline-primary rounded-circle" 
                                               style="width: 36px; height: 36px; padding: 0; display: flex; align-items: center; justify-content: center;"
                                               rel="noopener noreferrer">
                                                <i class="bi bi-linkedin"></i>
                                            </a>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                </div>
            <?php else: ?>
                <div class="row">
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">No volunteers available at the moment.</p>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </section>
</div>

<style>
.volunteer-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.volunteer-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
}

.volunteer-social a {
    transition: all 0.3s ease;
}

.volunteer-social a:hover {
    transform: scale(1.1);
}
</style>
<?php /**PATH I:\Helpy\resources\views\livewire\frontend\volunteers-page.blade.php ENDPATH**/ ?>