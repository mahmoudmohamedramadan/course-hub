@extends('layouts.site')

@section('title', $lesson->title.' — '.$course->title)

@section('content')
<div class="mb-6">
    <a href="{{ route('courses.show', $course) }}"
        class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">
        &larr; {{ __('Back to course') }}
    </a>
</div>

<div class="lg:grid lg:grid-cols-12 lg:gap-10">
    <div class="lg:col-span-8">
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-black shadow-lg dark:border-slate-800">
            @php
            $url = $lesson->video_url;

            preg_match('/(youtu\.be\/|v=)([^&]+)/', $url, $matches);
            $youtubeId = $matches[2] ?? null;
            @endphp

            <iframe id="lesson-player-video" class="w-full aspect-video rounded-lg"
                src="https://www.youtube.com/embed/{{ $youtubeId }}"
                title="{{ __('Lesson video: :title', ['title' => $lesson->title]) }}"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen>
            </iframe>
        </div>

        <div
            class="mt-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-8">
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">
                {{ $lesson->title }}
            </h1>
            @if ($lesson->learnings)
            <div class="prose prose-slate mt-6 max-w-none dark:prose-invert">
                {!! nl2br(e($lesson->learnings)) !!}
            </div>
            @endif

            <livewire:lesson-progress-controls :course="$course" :lesson="$lesson" :key="'progress-'.$lesson->id" />

            <div class="mt-8 flex flex-wrap gap-3">
                @if ($prevLesson)
                <a href="{{ route('courses.lessons.show', [$course, $prevLesson]) }}"
                    class="inline-flex flex-1 items-center justify-center rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-800 hover:bg-slate-50 dark:border-slate-600 dark:text-slate-200 dark:hover:bg-slate-800 sm:flex-none">
                    {{ __('Previous lesson') }}
                </a>
                @endif
                @if ($nextLesson)
                <a href="{{ route('courses.lessons.show', [$course, $nextLesson]) }}"
                    class="inline-flex flex-1 items-center justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500 sm:flex-none sm:ms-auto">
                    {{ __('Next lesson') }}
                </a>
                @endif
            </div>
        </div>
    </div>

    <aside class="mt-10 lg:col-span-4 lg:mt-0">
        <div
            class="sticky top-8 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-800 dark:bg-slate-900 sm:p-6">
            <h2 class="text-sm font-bold uppercase tracking-wide text-slate-500 dark:text-slate-400">
                {{ __('Lessons') }}
            </h2>
            <livewire:lesson-sidebar :course="$course" :current-lesson="$lesson" :key="'sidebar-'.$course->id" />
        </div>
    </aside>
</div>
@endsection
