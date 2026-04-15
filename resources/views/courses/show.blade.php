@extends('layouts.site')

@section('title', $course->title.' — '.config('app.name'))

@section('content')
@php
$enrolled = auth()->check() && auth()->user()->isEnrolledIn($course);
@endphp

@if (session('status'))
<output
    class="mb-6 block rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900 dark:border-emerald-900 dark:bg-emerald-950/50 dark:text-emerald-200">
    {{ session('status') }}
</output>
@endif

@if (session('enrollment_required'))
<div class="mb-6 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900 dark:border-amber-900 dark:bg-amber-950/50 dark:text-amber-200"
    role="alert">
    {{ __('Enroll in this course to watch lessons.') }}
</div>
@endif

<div
    class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm dark:border-slate-800 dark:bg-slate-900">
    @if ($course->cover_image_url)
    <div class="aspect-[21/9] max-h-80 w-full overflow-hidden">
        <img src="{{ $course->cover_image_url }}" alt="" class="h-full w-full object-cover" />
    </div>
    @else
    <div
        class="flex aspect-[21/9] max-h-80 w-full items-center justify-center bg-gradient-to-r from-indigo-600 to-violet-700">
        <h1 class="px-6 text-center text-2xl font-bold text-white sm:text-3xl">
            {{ $course->title }}
        </h1>
    </div>
    @endif

    <div class="p-6 sm:p-10">
        @if ($course->cover_image_url)
        <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-3xl">
            {{ $course->title }}
        </h1>
        @endif

        <div class="mt-4 flex flex-wrap items-center gap-3">
            <span class="text-lg text-amber-600 dark:text-amber-400" aria-hidden="true">⭐</span>
            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">
                {{ number_format((float) $course->rating, 1) }}/5
            </span>
            <x-level-badge :level="$course->level" />
            <span
                class="inline-flex rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-800 dark:bg-slate-800 dark:text-slate-200">
                {{ $course->category->name }}
            </span>
        </div>

        <div class="mt-6 flex flex-wrap items-center gap-4 border-b border-slate-100 pb-6 dark:border-slate-800">
            @if ($course->instructor->avatar_url)
            <img src="{{ $course->instructor->avatar_url }}" alt="{{ $course->instructor->name }}"
                class="h-14 w-14 rounded-full object-cover ring-2 ring-slate-100 dark:ring-slate-800" />
            @else
            <div
                class="flex h-14 w-14 items-center justify-center rounded-full bg-indigo-100 text-lg font-semibold text-indigo-800 dark:bg-indigo-900/50 dark:text-indigo-200">
                {{ str()->substr($course->instructor->name, 0, 1) }}
            </div>
            @endif
            <div>
                <p class="font-semibold text-slate-900 dark:text-white">{{ $course->instructor->name }}</p>
                @if ($course->instructor->title)
                <p class="text-sm text-slate-600 dark:text-slate-400">{{ $course->instructor->title }}</p>
                @endif
            </div>
        </div>

        @if ($course->target_audience)
        <p class="mt-6 text-sm text-slate-600 dark:text-slate-400">
            <span class="font-semibold text-slate-800 dark:text-slate-200">{{ __('Target audience') }}:</span>
            {{ $course->target_audience }}
        </p>
        @endif

        @if ($course->description)
        <div class="prose prose-slate mt-6 max-w-none dark:prose-invert">
            {!! nl2br(e($course->description)) !!}
        </div>
        @endif

        <div class="mt-8 flex flex-wrap gap-6 text-sm text-slate-600 dark:text-slate-400">
            <div>
                <span class="font-semibold text-slate-800 dark:text-slate-200">
                    {{ __('Lessons') }}
                </span>
                {{ $course->lessons->count() }}
            </div>
            <div>
                <span class="font-semibold text-slate-800 dark:text-slate-200">
                    {{ __('Total duration') }}
                </span>
                {{ $course->formattedTotalDuration() }}
            </div>
        </div>

        <div id="enroll" class="mt-10 border-t border-slate-100 pt-8 dark:border-slate-800">
            @guest
            <p class="mb-4 text-sm text-slate-600 dark:text-slate-400">
                {{ __('Log in or create an account to enroll and track your progress.') }}
            </p>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('login') }}"
                    class="inline-flex rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
                    {{ __('Log in') }}
                </a>
                @if (Route::has('register'))
                <a href="{{ route('register') }}"
                    class="inline-flex rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-800 hover:bg-slate-50 dark:border-slate-600 dark:text-slate-200 dark:hover:bg-slate-800">
                    {{ __('Register') }}
                </a>
                @endif
            </div>
            @else
            @if ($enrolled)
            <span
                class="inline-flex items-center rounded-full bg-emerald-100 px-4 py-1.5 text-sm font-semibold text-emerald-900 dark:bg-emerald-900/40 dark:text-emerald-200">{{
                __('Enrolled') }}</span>
            @else
            <form action="{{ route('courses.enroll', $course) }}" method="post" class="inline">
                @csrf
                <button type="submit"
                    class="inline-flex rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                    {{ __('Enroll now') }}
                </button>
            </form>
            @endif
            @endguest
        </div>
    </div>
</div>

<section class="mt-12" aria-labelledby="lessons-heading">
    <h2 id="lessons-heading" class="text-xl font-bold text-slate-900 dark:text-white">
        {{ __('Course content') }}
    </h2>
    <ol
        class="mt-4 divide-y divide-slate-200 overflow-hidden rounded-xl border border-slate-200 bg-white dark:divide-slate-800 dark:border-slate-800 dark:bg-slate-900">
        @foreach ($course->lessons as $lesson)
        @php
        $locked = ! $lesson->is_published;
        $canWatch = $lesson->is_published && $enrolled;
        $completed = $enrolled && in_array($lesson->id, $completedLessonIds, true);
        @endphp
        <li class="flex items-start gap-4 px-4 py-4 sm:px-6">
            <div class="mt-0.5 shrink-0 text-slate-500 dark:text-slate-400" aria-hidden="true">
                @if ($locked)
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                </svg>
                @else
                <svg class="h-6 w-6 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13.5 10.5V6.75a4.5 4.5 0 119 0v3.75M3.75 21.75h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H3.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                </svg>
                @endif
            </div>
            <div class="min-w-0 flex-1">
                @if ($canWatch)
                <a href="{{ route('courses.lessons.show', [$course, $lesson]) }}"
                    class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                    {{ $lesson->title }}
                </a>
                @else
                <span class="font-medium text-slate-900 dark:text-white">{{ $lesson->title }}</span>
                @endif
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                    {{ $lesson->formattedDuration() }}
                </p>
            </div>
            @if ($completed)
            <span class="shrink-0 text-emerald-600 dark:text-emerald-400" title="{{ __('Completed') }}">
                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                        clip-rule="evenodd" />
                </svg>
            </span>
            @endif
        </li>
        @endforeach
    </ol>
</section>

<section
    class="mt-12 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-8">
    <h2 class="text-lg font-bold text-slate-900 dark:text-white">
        {{ __('About the instructor') }}
    </h2>
    <div class="mt-6 flex flex-col gap-6 sm:flex-row">
        @if ($course->instructor->avatar_url)
        <img src="{{ $course->instructor->avatar_url }}" alt="" class="h-24 w-24 shrink-0 rounded-2xl object-cover" />
        @else
        <div
            class="flex h-24 w-24 shrink-0 items-center justify-center rounded-2xl bg-indigo-100 text-2xl font-bold text-indigo-800 dark:bg-indigo-900/50 dark:text-indigo-200">
            {{ str()->substr($course->instructor->name, 0, 1) }}
        </div>
        @endif
        <div class="min-w-0 flex-1">
            <p class="text-xl font-semibold text-slate-900 dark:text-white">
                {{ $course->instructor->name }}
            </p>
            @if ($course->instructor->title)
            <p class="mt-1 text-sm font-medium text-indigo-600 dark:text-indigo-400">
                {{ $course->instructor->title }}
            </p>
            @endif
            @if ($course->instructor->bio)
            <p class="mt-4 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                {{ $course->instructor->bio }}
            </p>
            @endif
            @if ($course->instructor->linkedin_url)
            <a href="{{ $course->instructor->linkedin_url }}"
                class="mt-4 inline-flex text-sm font-semibold text-indigo-600 hover:text-indigo-500 dark:text-indigo-400"
                target="_blank" rel="noopener noreferrer">
                {{ __('LinkedIn profile') }}
            </a>
            @endif
        </div>
    </div>
</section>
@endsection
