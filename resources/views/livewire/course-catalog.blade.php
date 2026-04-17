<div>
    <div class="mb-8 flex flex-col gap-4 lg:flex-row lg:flex-wrap lg:items-end lg:justify-between">
        <div class="w-full max-w-md flex-1">
            <label for="course-search" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">
                {{ __('Search') }}
            </label>
            <input id="course-search" type="search" wire:model.live.debounce.300ms="search"
                placeholder="{{ __('Search courses…') }}"
                class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-900 shadow-sm placeholder:text-slate-400 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 dark:border-slate-600 dark:bg-slate-900 dark:text-white" />
        </div>
        <div class="flex flex-wrap gap-4">
            <div>
                <label for="filter-category" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">
                    {{ __('Category') }}
                </label>
                <select id="filter-category" wire:model.live="categoryId"
                    class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 dark:border-slate-600 dark:bg-slate-900 dark:text-white">
                    <option value="">{{ __('All categories') }}</option>
                    @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="filter-level" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">
                    {{ __('Level') }}
                </label>
                <select id="filter-level" wire:model.live="levelId"
                    class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 dark:border-slate-600 dark:bg-slate-900 dark:text-white">
                    <option value="">{{ __('All levels') }}</option>
                    @foreach ($levels as $level)
                    <option value="{{ $level->id }}">{{ $level->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="filter-sort" class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">
                    {{ __('Sort') }}
                </label>
                <select id="filter-sort" wire:model.live="sort"
                    class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 dark:border-slate-600 dark:bg-slate-900 dark:text-white">
                    <option value="newest">{{ __('Newest') }}</option>
                    <option value="rating">{{ __('Highest rated') }}</option>
                </select>
            </div>
        </div>
    </div>

    <div wire:loading.delay class="mb-6 flex items-center gap-3 text-base text-slate-600 dark:text-slate-300">
        <svg class="h-5 w-5 animate-spin text-slate-400 dark:text-slate-500" xmlns="http://www.w3.org/2000/svg"
            fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
        </svg>
        <span>{{ __('Updating results...') }}</span>
    </div>

    @if ($courses->isEmpty())
    <p
        class="rounded-xl border border-dashed border-slate-300 bg-white p-12 text-center text-slate-600 dark:border-slate-600 dark:bg-slate-900 dark:text-slate-400">
        {{ __('No courses match your filters.') }}
    </p>
    @else
    <ul class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-3">
        @foreach ($courses as $course)
        <li
            class="flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:shadow-md dark:border-slate-800 dark:bg-slate-900">
            <a href="{{ route('courses.show', $course->slug) }}" class="block shrink-0">
                @if ($course->thumbnail_url)
                <img src="{{ $course->thumbnail_url }}" alt="" class="aspect-video w-full object-cover"
                    loading="lazy" />
                @else
                <div
                    class="flex aspect-video w-full items-center justify-center bg-gradient-to-br from-indigo-500 to-violet-600">
                    <span class="text-4xl font-bold text-white/90">
                        {{ str()->substr($course->title, 0, 1) }}
                    </span>
                </div>
                @endif
            </a>
            <div class="flex flex-1 flex-col p-5">
                <div class="mb-3 flex flex-wrap gap-2">
                    <span
                        class="inline-flex rounded-full bg-slate-100 px-2.5 py-0.5 text-xs font-medium text-slate-800 dark:bg-slate-800 dark:text-slate-200">
                        {{ $course->category->name }}
                    </span>
                    <x-level-badge :level="$course->level" />
                </div>
                <h2 class="text-lg font-semibold leading-snug text-slate-900 dark:text-white">
                    <a href="{{ route('courses.show', $course->slug) }}"
                        class="hover:text-indigo-600 dark:hover:text-indigo-400">
                        {{ $course->title }}
                    </a>
                </h2>
                <p class="mt-2 line-clamp-3 flex-1 text-sm text-slate-600 dark:text-slate-400">
                    {{ $course->short_description }}
                </p>
                <div class="mt-4 flex items-center gap-3 border-t border-slate-100 pt-4 dark:border-slate-800">
                    @if ($course->instructor->avatar_url)
                    <img src="{{ $course->instructor->avatar_url }}" alt=""
                        class="h-10 w-10 shrink-0 rounded-full object-cover ring-2 ring-white dark:ring-slate-900" />
                    @else
                    <div
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-indigo-100 text-sm font-semibold text-indigo-800 dark:bg-indigo-900/50 dark:text-indigo-200">
                        {{ str()->substr($course->instructor->name, 0, 1) }}
                    </div>
                    @endif
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-medium text-slate-900 dark:text-white">
                            {{ $course->instructor->name }}
                        </p>
                        <p class="text-xs text-amber-600 dark:text-amber-400">
                            ⭐ {{ number_format((float) $course->rating, 1) }}/5
                        </p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="{{ route('courses.show', $course->slug) }}"
                        class="inline-flex w-full items-center justify-center rounded-lg bg-green-700 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-green-600">
                        {{ __('View course') }}
                    </a>
                </div>
            </div>
        </li>
        @endforeach
    </ul>

    <div class="mt-8">
        {{ $courses->links() }}
    </div>
    @endif
</div>
