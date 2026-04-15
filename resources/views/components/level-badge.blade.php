@props(['level'])

@php
$key = \Illuminate\Support\Str::lower($level->slug);
$classes = match ($key) {
'beginner' => 'bg-emerald-100 text-emerald-900 dark:bg-emerald-900/40 dark:text-emerald-200',
'intermediate' => 'bg-amber-100 text-amber-900 dark:bg-amber-900/40 dark:text-amber-200',
'advanced' => 'bg-orange-100 text-orange-900 dark:bg-orange-900/40 dark:text-orange-200',
'expert' => 'bg-red-100 text-red-900 dark:bg-red-900/40 dark:text-red-200',
default => 'bg-slate-100 text-slate-800 dark:bg-slate-800 dark:text-slate-200',
};
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold
    '.$classes]) }}>
    {{ $level->name }}
</span>
