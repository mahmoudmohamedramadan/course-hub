<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">
                        {{ __('Your enrolled courses') }}
                    </h3>

                    @if ($courses->isEmpty())
                    <p class="mt-3 text-sm text-gray-600 dark:text-gray-300">
                        {{ __("You haven't enrolled in any courses yet.") }}
                    </p>
                    @else
                    <ul class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($courses as $course)
                        <li
                            class="flex flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition hover:shadow-md dark:border-gray-700 dark:bg-gray-900">
                            <a href="{{ route('courses.show', $course) }}" class="block shrink-0">
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
                                        class="inline-flex rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800 dark:bg-gray-800 dark:text-gray-200">
                                        {{ $course->category?->name }}
                                    </span>
                                    @if ($course->level)
                                    <x-level-badge :level="$course->level" />
                                    @endif
                                </div>

                                <h4 class="text-lg font-semibold leading-snug text-gray-900 dark:text-white">
                                    <a href="{{ route('courses.show', $course) }}"
                                        class="hover:text-indigo-600 dark:hover:text-indigo-400">
                                        {{ $course->title }}
                                    </a>
                                </h4>

                                @if ($course->short_description)
                                <p class="mt-2 line-clamp-3 flex-1 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $course->short_description }}
                                </p>
                                @endif

                                @if (!is_null($course->rating))
                                <p class="mt-4 text-xs font-medium text-amber-600 dark:text-amber-400">
                                    ⭐ {{ number_format((float) $course->rating, 1) }}/5
                                </p>
                                @endif

                                <div class="mt-4">
                                    <a href="{{ route('courses.show', $course) }}"
                                        class="inline-flex w-full items-center justify-center rounded-lg bg-green-700 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-green-600">
                                        {{ __('View course') }}
                                    </a>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
