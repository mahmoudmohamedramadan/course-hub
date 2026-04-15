<div class="mt-8 border-t border-slate-100 pt-8 dark:border-slate-800">
    <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm font-medium text-slate-700 dark:text-slate-300">
            {{ __(':done of :total lessons completed', ['done' => $completedCount, 'total' => $totalLessons]) }}
        </p>
        @if (! $isCompleted)
        <button type="button" wire:click="markComplete" wire:loading.attr="disabled"
            class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-500 disabled:opacity-50">
            <span wire:loading.remove wire:target="markComplete">
                {{ __('Mark as complete') }}
            </span>
            <span wire:loading wire:target="markComplete">
                {{ __('Saving...') }}
            </span>
        </button>
        @else
        <span
            class="inline-flex items-center gap-2 rounded-lg bg-emerald-100 px-3 py-1.5 text-sm font-semibold text-emerald-900 dark:bg-emerald-900/40 dark:text-emerald-200">
            <svg class="h-5 w-5 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                    clip-rule="evenodd" />
            </svg>
            {{ __('Completed') }}
        </span>
        @endif
    </div>
    @php
    $maxLessons = max($totalLessons, 1);
    $percentage = $totalLessons > 0 ? round($completedCount / $totalLessons * 100) : 0;
    @endphp
    <progress class="lesson-progress-native" value="{{ $completedCount }}" max="{{ $maxLessons }}"
        aria-valuetext="{{ __(':done of :total lessons completed', ['done' => $completedCount, 'total' => $totalLessons]) }}">
        {{ $percentage }}%
    </progress>
</div>
