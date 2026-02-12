<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['title' => 'Stat', 'value' => 0, 'icon' => 'fa-chart-line', 'color' => 'blue']));

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

foreach (array_filter((['title' => 'Stat', 'value' => 0, 'icon' => 'fa-chart-line', 'color' => 'blue']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php
    $colors = [
        'blue' => ['bg' => 'bg-blue-50','text' => 'text-blue-600'],
        'red' => ['bg' => 'bg-red-50','text' => 'text-red-600'],
        'orange' => ['bg' => 'bg-orange-50','text' => 'text-orange-600'],
        'green' => ['bg' => 'bg-emerald-50','text' => 'text-emerald-600'],
        'indigo' => ['bg' => 'bg-indigo-50','text' => 'text-indigo-600'],
    ];
    $c = $colors[$color] ?? $colors['blue'];
?>

<div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm transition-colors hover:shadow-md h-full">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-sm font-medium text-slate-500 uppercase tracking-wider"><?php echo e($title); ?></p>
            <p class="text-2xl font-bold text-slate-900"><?php echo e($value); ?></p>
        </div>
        <div class="p-3 <?php echo e($c['bg']); ?> rounded-lg">
            <i class="fa-solid <?php echo e($icon); ?> <?php echo e($c['text']); ?> text-xl"></i>
        </div>
    </div>
</div>
<?php /**PATH D:\laragon\www\gudang\resources\views/components/stat-card.blade.php ENDPATH**/ ?>