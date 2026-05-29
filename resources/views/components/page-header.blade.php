@props([
    'menu' => null,
    'titleOnly' => false,
    'textColor' => 'text-gray-900 dark:text-gray-100' // default color
])

@if($menu)
    <div class="mb-6">
        <h2 class="text-xl font-semibold {{ $textColor }}">
            ✨{{ $menu->MainPaneLabel }}
        </h2>

        @unless($titleOnly)
            @if(!empty($menu->TileText))
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400 whitespace-pre-line">
                    {{ $menu->TileText }}
                </p>
            @endif
        @endunless
    </div>
@endif
