<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['variant' => 'default']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['variant' => 'default']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
$variants = [
    'default' => 'bg-primary text-primary-foreground hover:bg-primary/80',
    'secondary' => 'bg-secondary text-secondary-foreground hover:bg-secondary/80',
    'destructive' => 'bg-destructive text-destructive-foreground hover:bg-destructive/80',
    'outline' => 'text-foreground border border-input hover:bg-accent',
    'success' => 'bg-green-500 text-white hover:bg-green-600',
    'warning' => 'bg-yellow-500 text-white hover:bg-yellow-600',
];

$classes = 'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold transition-colors focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 ' . ($variants[$variant] ?? $variants['default']);
?>

<span <?php echo e($attributes->merge(['class' => $classes])); ?>>
    <?php echo e($slot); ?>

</span>
<?php /**PATH I:\Helpy\resources\views\components\ui\badge.blade.php ENDPATH**/ ?>