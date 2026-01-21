<div>
    <?php $__env->startSection('title', 'Create Menu Item'); ?>
    
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-900">Create Menu Item</h2>
        <p class="mt-1 text-sm text-gray-600">Add a new navigation menu item to your site</p>
    </div>

    <form wire:submit="save">
        <?php if (isset($component)) { $__componentOriginal4658ca741dca2689097dd49737f7416c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4658ca741dca2689097dd49737f7416c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin-card','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

            <div class="space-y-6">
                <!-- Label -->
                <div>
                    <?php if (isset($component)) { $__componentOriginal331272c83d3eb364d8d2da5f5c946e62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal331272c83d3eb364d8d2da5f5c946e62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin-input','data' => ['label' => 'Label','wire:model' => 'label','placeholder' => 'e.g., Home, About, Contact','required' => true,'error' => ''.e($errors->first('label')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Label','wire:model' => 'label','placeholder' => 'e.g., Home, About, Contact','required' => true,'error' => ''.e($errors->first('label')).'']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal331272c83d3eb364d8d2da5f5c946e62)): ?>
<?php $attributes = $__attributesOriginal331272c83d3eb364d8d2da5f5c946e62; ?>
<?php unset($__attributesOriginal331272c83d3eb364d8d2da5f5c946e62); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal331272c83d3eb364d8d2da5f5c946e62)): ?>
<?php $component = $__componentOriginal331272c83d3eb364d8d2da5f5c946e62; ?>
<?php unset($__componentOriginal331272c83d3eb364d8d2da5f5c946e62); ?>
<?php endif; ?>
                    <p class="mt-1 text-sm text-gray-500">The text that will be displayed in the menu</p>
                </div>

                <!-- Route -->
                <div>
                    <?php if (isset($component)) { $__componentOriginal331272c83d3eb364d8d2da5f5c946e62 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal331272c83d3eb364d8d2da5f5c946e62 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin-input','data' => ['label' => 'Route / URL','wire:model' => 'route','placeholder' => 'e.g., /home, /about, https://example.com','required' => true,'error' => ''.e($errors->first('route')).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['label' => 'Route / URL','wire:model' => 'route','placeholder' => 'e.g., /home, /about, https://example.com','required' => true,'error' => ''.e($errors->first('route')).'']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal331272c83d3eb364d8d2da5f5c946e62)): ?>
<?php $attributes = $__attributesOriginal331272c83d3eb364d8d2da5f5c946e62; ?>
<?php unset($__attributesOriginal331272c83d3eb364d8d2da5f5c946e62); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal331272c83d3eb364d8d2da5f5c946e62)): ?>
<?php $component = $__componentOriginal331272c83d3eb364d8d2da5f5c946e62; ?>
<?php unset($__componentOriginal331272c83d3eb364d8d2da5f5c946e62); ?>
<?php endif; ?>
                    <p class="mt-1 text-sm text-gray-500">Can be a relative path (/about) or full URL (https://...)</p>
                </div>

                <!-- Parent Menu Item -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Parent Menu Item
                    </label>
                    <select 
                        wire:model="parent_id"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $parentOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoop($loop->index); ?><?php endif; ?>
                            <option value="<?php echo e($option['id']); ?>"><?php echo e($option['label']); ?></option>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    </select>
                    <p class="mt-1 text-sm text-gray-500">Select a parent to create a nested menu item</p>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['parent_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <!-- Status Toggles -->
                <div class="space-y-4">
                    <div class="flex items-center">
                        <input 
                            type="checkbox" 
                            wire:model="is_active"
                            id="is_active"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                        <label for="is_active" class="ml-2 text-sm text-gray-700">
                            Active (visible on site)
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input 
                            type="checkbox" 
                            wire:model="opens_in_new_tab"
                            id="opens_in_new_tab"
                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        >
                        <label for="opens_in_new_tab" class="ml-2 text-sm text-gray-700">
                            Open in new tab
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <a href="<?php echo e(route('admin.site-settings.navbar.index')); ?>" wire:navigate>
                    <?php if (isset($component)) { $__componentOriginal4ff297b286d2dba35e6c7d18cf241e0a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4ff297b286d2dba35e6c7d18cf241e0a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin-button','data' => ['variant' => 'secondary']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'secondary']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                        Cancel
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
                </a>
                <?php if (isset($component)) { $__componentOriginal4ff297b286d2dba35e6c7d18cf241e0a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4ff297b286d2dba35e6c7d18cf241e0a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin-button','data' => ['type' => 'submit']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                    Create Menu Item
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
    </form>
</div>
<?php /**PATH I:\Helpy\resources\views\livewire\admin\site-settings\navbar\create.blade.php ENDPATH**/ ?>