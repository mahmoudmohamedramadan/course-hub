@extends('layouts.site')

@section('title', config('app.name'))

@section('content')
    <div class="mx-auto max-w-2xl text-center">
        <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-4xl">{{ __('Welcome to :name', ['name' => config('app.name')]) }}</h1>
        <p class="mt-4 text-lg text-slate-600 dark:text-slate-400">{{ __('Explore courses, enroll, and learn at your own pace.') }}</p>
        <div class="mt-8 flex flex-wrap justify-center gap-4">
            <a href="{{ route('courses.index') }}" class="inline-flex rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">{{ __('Browse courses') }}</a>
            @guest
                <a href="{{ route('login') }}" class="inline-flex rounded-lg border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-800 hover:bg-slate-50 dark:border-slate-600 dark:text-slate-200 dark:hover:bg-slate-800">{{ __('Log in') }}</a>
            @endguest
        </div>
    </div>
@endsection
