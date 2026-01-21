<div class="p-6">
    <h2 class="text-2xl font-bold text-gray-900 mb-2">Two-Factor Authentication</h2>
    <p class="text-sm text-gray-600 mb-6">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($useRecoveryCode): ?>
            Enter one of your recovery codes
        <?php else: ?>
            Enter the code from your authenticator app
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </p>

    <form wire:submit="verify">
        <div class="mb-4">
            <label for="code" class="block text-sm font-medium text-gray-700 mb-1">
                <?php echo e($useRecoveryCode ? 'Recovery Code' : 'Authentication Code'); ?>

            </label>
            <input 
                type="text" 
                id="code" 
                wire:model="code" 
                class="w-full px-3 py-2 border rounded-md text-center text-lg tracking-widest focus:outline-none focus:ring-2 focus:ring-blue-500 <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                placeholder="<?php echo e($useRecoveryCode ? 'XXXXXXXXXX' : '000000'); ?>"
                required
                autofocus
            >
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['code'];
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

        <button 
            type="submit" 
            class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors mb-4"
            wire:loading.attr="disabled"
        >
            <span wire:loading.remove>Verify</span>
            <span wire:loading>Verifying...</span>
        </button>

        <button 
            type="button" 
            wire:click="toggleRecoveryCode"
            class="w-full text-sm text-blue-600 hover:text-blue-800"
        >
            <?php echo e($useRecoveryCode ? 'Use authenticator code instead' : 'Use recovery code instead'); ?>

        </button>
    </form>

    <div class="mt-4 text-center">
        <a href="<?php echo e(route('admin.login')); ?>" class="text-sm text-gray-600 hover:text-gray-800">
            Back to login
        </a>
    </div>
</div>
<?php /**PATH I:\Helpy\resources\views\livewire\admin\auth\two-factor-verify.blade.php ENDPATH**/ ?>