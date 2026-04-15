<ol class="mt-4 max-h-[min(70vh,32rem)] space-y-1 overflow-y-auto pe-1">
    @foreach ($course->lessons as $item)
    @php
    $isCurrent = $item->is($currentLesson);
    $locked = ! $item->is_published;
    $done = $completedIds->contains($item->id);
    @endphp
    <li>
        @if ($item->is_published)
        <a href="{{ route('courses.lessons.show', [$course, $item]) }}"
            class="flex items-start gap-3 rounded-lg px-3 py-2 text-sm transition {{ $isCurrent ? 'bg-indigo-50 font-semibold text-indigo-900 dark:bg-indigo-950/50 dark:text-indigo-100' : 'text-slate-700 hover:bg-slate-50 dark:text-slate-300 dark:hover:bg-slate-800' }}">
            <span class="mt-0.5 shrink-0 text-slate-400" aria-hidden="true">
                @if ($done)
                <svg class="h-5 w-5 text-emerald-600 dark:text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                        clip-rule="evenodd" />
                </svg>
                @else
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
                </svg>
                @endif
            </span>
            <span class="min-w-0 flex-1">
                <span class="line-clamp-2">
                    {{ $item->title }}
                </span>
                <span class="mt-0.5 block text-xs font-normal text-slate-500 dark:text-slate-400">
                    {{ $item->formattedDuration() }}
                </span>
            </span>
        </a>
        @else
        <div class="flex items-start gap-3 rounded-lg px-3 py-2 text-sm text-slate-400 dark:text-slate-500">
            <svg class="mt-0.5 h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
            </svg>
            <span class="min-w-0 flex-1">
                <span class="line-clamp-2">
                    {{ $item->title }}
                </span>
                <span class="mt-0.5 block text-xs">
                    {{ $item->formattedDuration() }}
                </span>
            </span>
        </div>
        @endif
    </li>
    @endforeach
</ol>
