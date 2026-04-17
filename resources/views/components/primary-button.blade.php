<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center rounded-md border
    border-transparent bg-orange-800 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition
    duration-150 ease-in-out hover:bg-orange-700 focus:bg-orange-700 focus:outline-none focus:ring-2
    focus:ring-orange-500 focus:ring-offset-2 active:bg-orange-900 dark:bg-orange-700 dark:text-white
    dark:hover:bg-orange-600 dark:focus:bg-orange-600 dark:focus:ring-orange-400 dark:focus:ring-offset-gray-900
    dark:active:bg-orange-800']) }}>
    {{ $slot }}
</button>
