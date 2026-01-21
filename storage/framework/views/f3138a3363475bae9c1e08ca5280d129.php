<div>
    <?php $__env->startSection('title', 'Hero Section'); ?>
    
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Hero Section Slider</h2>
            <p class="mt-1 text-sm text-gray-600">Manage homepage slider images and content</p>
        </div>
        <?php if (isset($component)) { $__componentOriginal4ff297b286d2dba35e6c7d18cf241e0a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4ff297b286d2dba35e6c7d18cf241e0a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin-button','data' => ['wire:click' => 'openCreateModal']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'openCreateModal']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Add Slide
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4ff297b286d2dba35e6c7d18cf241e0a)): ?>
<?php $attributes = $__attributesOriginal4ff297b286d2dba35e6c7d18cf241e0a; ?>
<?php unset($__attributesOriginal4ff297b286d2dba35e6c7d18cf241e0a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4ff297b286d2dba35e6c7d18cf241e0a)): ?>
<?php $component = $__componentOriginal4ff297b286d2dba35e6c7d18cf241e0a; ?>
<?php unset($__componentOriginal4ff297b286d2dba35e6c7d18cf241e0a); ?>
<?php endif; ?>
    </div>

    <!-- Slides Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal4658ca741dca2689097dd49737f7416c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4658ca741dca2689097dd49737f7416c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin-card','data' => ['class' => 'overflow-hidden']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'overflow-hidden']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                <!-- Slide Image -->
                <div class="relative aspect-[288/155] bg-gray-200">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($slide->image): ?>
                        <img src="<?php echo e($slide->image_url); ?>" alt="<?php echo e($slide->heading); ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                        <div class="absolute inset-0 flex items-center justify-center text-gray-400">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    
                    <!-- Order Badge -->
                    <div class="absolute top-2 left-2 bg-black bg-opacity-70 text-white px-2.5 py-1 rounded-full text-xs font-semibold">
                        #<?php echo e($slide->order + 1); ?>

                    </div>

                    <!-- Status Badge -->
                    <div class="absolute top-2 right-2">
                        <button 
                            wire:click="toggleStatus(<?php echo e($slide->id); ?>)"
                            class="px-2.5 py-1 rounded-full text-xs font-semibold <?php echo e($slide->is_active ? 'bg-green-500 text-white' : 'bg-gray-500 text-white'); ?>"
                        >
                            <?php echo e($slide->is_active ? 'Active' : 'Inactive'); ?>

                        </button>
                    </div>
                </div>

                <!-- Slide Content -->
                <div class="p-4">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($slide->sub_heading): ?>
                        <p class="text-xs text-indigo-600 font-medium mb-1"><?php echo e($slide->sub_heading); ?></p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <h3 class="text-base font-bold text-gray-900 line-clamp-2 mb-1"><?php echo e($slide->heading); ?></h3>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($slide->sub_heading_2): ?>
                        <p class="text-sm text-gray-600 line-clamp-2"><?php echo e($slide->sub_heading_2); ?></p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <!-- Actions -->
                    <div class="mt-4 flex items-center justify-end space-x-2">
                        <button 
                            wire:click="openEditModal(<?php echo e($slide->id); ?>)" 
                            class="px-3 py-1.5 text-xs font-medium text-indigo-600 hover:text-indigo-700 bg-indigo-50 hover:bg-indigo-100 rounded-md transition-colors"
                        >
                            Edit
                        </button>
                        <button 
                            wire:click="delete(<?php echo e($slide->id); ?>)" 
                            wire:confirm="Are you sure you want to delete this slide?"
                            class="px-3 py-1.5 text-xs font-medium text-red-600 hover:text-red-700 bg-red-50 hover:bg-red-100 rounded-md transition-colors"
                        >
                            Delete
                        </button>
                    </div>
                </div>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4658ca741dca2689097dd49737f7416c)): ?>
<?php $attributes = $__attributesOriginal4658ca741dca2689097dd49737f7416c; ?>
<?php unset($__attributesOriginal4658ca741dca2689097dd49737f7416c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4658ca741dca2689097dd49737f7416c)): ?>
<?php $component = $__componentOriginal4658ca741dca2689097dd49737f7416c; ?>
<?php unset($__componentOriginal4658ca741dca2689097dd49737f7416c); ?>
<?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <div class="col-span-full">
                <?php if (isset($component)) { $__componentOriginal4658ca741dca2689097dd49737f7416c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4658ca741dca2689097dd49737f7416c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin-card','data' => ['class' => 'text-center py-12']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'text-center py-12']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                    <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">No hero slides yet</h3>
                    <p class="mt-2 text-sm text-gray-500">Get started by creating your first hero slide.</p>
                    <div class="mt-6">
                        <?php if (isset($component)) { $__componentOriginal4ff297b286d2dba35e6c7d18cf241e0a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4ff297b286d2dba35e6c7d18cf241e0a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin-button','data' => ['wire:click' => 'openCreateModal']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'openCreateModal']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Add Your First Slide
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4ff297b286d2dba35e6c7d18cf241e0a)): ?>
<?php $attributes = $__attributesOriginal4ff297b286d2dba35e6c7d18cf241e0a; ?>
<?php unset($__attributesOriginal4ff297b286d2dba35e6c7d18cf241e0a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4ff297b286d2dba35e6c7d18cf241e0a)): ?>
<?php $component = $__componentOriginal4ff297b286d2dba35e6c7d18cf241e0a; ?>
<?php unset($__componentOriginal4ff297b286d2dba35e6c7d18cf241e0a); ?>
<?php endif; ?>
                    </div>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4658ca741dca2689097dd49737f7416c)): ?>
<?php $attributes = $__attributesOriginal4658ca741dca2689097dd49737f7416c; ?>
<?php unset($__attributesOriginal4658ca741dca2689097dd49737f7416c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4658ca741dca2689097dd49737f7416c)): ?>
<?php $component = $__componentOriginal4658ca741dca2689097dd49737f7416c; ?>
<?php unset($__componentOriginal4658ca741dca2689097dd49737f7416c); ?>
<?php endif; ?>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <!-- Create/Edit Modal -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showModal): ?>
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <!-- Background overlay -->
            <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm transition-opacity"></div>

            <!-- Modal container -->
            <div class="flex min-h-full items-center justify-center p-4">
                <!-- Modal panel -->
                <div class="relative w-full max-w-2xl transform overflow-hidden rounded-2xl bg-white shadow-xl transition-all">
                    <form wire:submit="save">
                        <!-- Modal header -->
                        <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold text-white">
                                    <?php echo e($editMode ? 'Edit Hero Slide' : 'Create New Hero Slide'); ?>

                                </h3>
                                <button 
                                    type="button" 
                                    wire:click="closeModal" 
                                    class="rounded-full p-1 text-indigo-200 hover:text-white hover:bg-indigo-800 transition-colors"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Modal body -->
                        <div class="bg-white px-6 py-6 space-y-5 max-h-[calc(100vh-250px)] overflow-y-auto">
                            <!-- Image Upload -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Slide Image <span class="text-red-500">*</span>
                                </label>
                                
                                <!-- Image Preview -->
                                <div class="mb-3">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($image): ?>
                                        <div class="relative aspect-[288/155] bg-gray-100 rounded-lg overflow-hidden">
                                            <img src="<?php echo e($image->temporaryUrl()); ?>" class="w-full h-full object-cover">
                                            <button 
                                                type="button"
                                                wire:click="$set('image', null)"
                                                class="absolute top-2 right-2 bg-red-500 text-white p-1.5 rounded-full hover:bg-red-600 transition-colors"
                                            >
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </div>
                                    <?php elseif($existing_image): ?>
                                        <div class="relative aspect-[288/155] bg-gray-100 rounded-lg overflow-hidden">
                                            <img src="<?php echo e(Storage::url($existing_image)); ?>" class="w-full h-full object-cover">
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                <!-- File Input -->
                                <input 
                                    type="file"
                                    wire:model="image"
                                    accept="image/jpeg,image/jpg,image/png,image/webp"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer"
                                >
                                <p class="mt-2 text-xs text-gray-500">
                                    <span class="font-medium">Target:</span> 1440 × 775px | <span class="font-medium">Format:</span> WEBP | <span class="font-medium">Max:</span> 500KB after compression
                                </p>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1.5 text-xs text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        <?php echo e($message); ?>

                                    </p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <div wire:loading wire:target="image" class="mt-2">
                                    <p class="text-xs text-indigo-600 flex items-center">
                                        <svg class="animate-spin h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Uploading...
                                    </p>
                                </div>
                            </div>

                            <!-- Sub Heading -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Sub Heading (Top)
                                </label>
                                <input 
                                    type="text"
                                    wire:model="sub_heading"
                                    placeholder="Optional sub heading..."
                                    class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                >
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['sub_heading'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1.5 text-xs text-red-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <!-- Heading -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Main Heading <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text"
                                    wire:model="heading"
                                    placeholder="Enter main heading..."
                                    class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    required
                                >
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['heading'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1.5 text-xs text-red-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <!-- Sub Heading 2 -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Sub Heading (Bottom)
                                </label>
                                <input 
                                    type="text"
                                    wire:model="sub_heading_2"
                                    placeholder="Optional bottom sub heading..."
                                    class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                >
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['sub_heading_2'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1.5 text-xs text-red-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>

                            <!-- Active Toggle -->
                            <div class="bg-gray-50 rounded-lg p-4">
                                <label class="flex items-center cursor-pointer group">
                                    <div class="relative">
                                        <input 
                                            type="checkbox" 
                                            wire:model="is_active"
                                            class="sr-only peer"
                                        >
                                        <div class="w-11 h-6 bg-gray-300 rounded-full peer peer-checked:bg-indigo-600 peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                                    </div>
                                    <div class="ml-3">
                                        <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900">Active</span>
                                        <p class="text-xs text-gray-500">Show this slide in the hero section</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="bg-gray-50 px-6 py-4 flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
                            <button
                                type="button"
                                wire:click="closeModal"
                                class="inline-flex justify-center items-center px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors"
                            >
                                Cancel
                            </button>
                            <button
                                type="submit"
                                class="inline-flex justify-center items-center px-5 py-2.5 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-lg hover:bg-indigo-700 transition-colors shadow-sm"
                            >
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <?php echo e($editMode ? 'Update Slide' : 'Create Slide'); ?>

                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH I:\Helpy\resources\views\livewire\admin\homepage\hero-section.blade.php ENDPATH**/ ?>