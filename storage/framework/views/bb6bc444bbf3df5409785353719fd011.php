<div class="language-switcher">
    <div class="dropdown">
        <button class="btn btn-sm btn-outline-light dropdown-toggle" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <?php if(current_locale() == 'bn'): ?>
                <i class="fa-solid fa-language"></i> বাংলা
            <?php else: ?>
                <i class="fa-solid fa-language"></i> English
            <?php endif; ?>
        </button>
        <ul class="dropdown-menu" aria-labelledby="languageDropdown">
            <li>
                <a class="dropdown-item <?php echo e(current_locale() == 'en' ? 'active' : ''); ?>" href="<?php echo e(route('language.switch', 'en')); ?>">
                    <i class="fa-solid fa-check <?php echo e(current_locale() == 'en' ? '' : 'invisible'); ?>"></i> English
                </a>
            </li>
            <li>
                <a class="dropdown-item <?php echo e(current_locale() == 'bn' ? 'active' : ''); ?>" href="<?php echo e(route('language.switch', 'bn')); ?>">
                    <i class="fa-solid fa-check <?php echo e(current_locale() == 'bn' ? '' : 'invisible'); ?>"></i> বাংলা
                </a>
            </li>
        </ul>
    </div>
</div>

<style>
.language-switcher {
    display: inline-block;
}

.language-switcher .dropdown-item {
    cursor: pointer;
}

.language-switcher .dropdown-item.active {
    background-color: #f8f9fa;
    font-weight: bold;
}

.language-switcher .dropdown-item i.fa-check {
    width: 16px;
    margin-right: 5px;
}

.language-switcher .dropdown-item i.fa-check.invisible {
    visibility: hidden;
}
</style>
<?php /**PATH I:\Helpy\resources\views/layouts/partials/language-switcher.blade.php ENDPATH**/ ?>