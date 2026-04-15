@extends('layouts.site')

@section('title', __('Courses').' — '.config('app.name'))

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-4xl">
        {{ __('Browse courses') }}
    </h1>
    <p class="mt-2 max-w-2xl text-slate-600 dark:text-slate-400">{{ __('Learn at your own pace. Filter by topic and
        level, or search the catalog.') }}</p>
</div>

<livewire:course-catalog />
@endsection
