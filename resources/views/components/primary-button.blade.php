<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase rounded-lg shadow hover:bg-indigo-700 transition']) }}>
    {{ $slot }}
</button>
