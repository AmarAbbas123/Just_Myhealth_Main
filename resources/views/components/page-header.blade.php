@props([
    'menu' => null,
    'titleOnly' => false,
    'textColor' => 'text-gray-900 dark:text-gray-100',
    'title' => null,
    'subtitle' => null,
])

@php
    $displayMenu = $menu ?? ($__env->getShared()['menu'] ?? null);
    $displayTitle = $title ?? $displayMenu?->MainPaneLabel ?? null;
    $displaySubtitle = $subtitle ?? $displayMenu?->TileText ?? null;
@endphp

@if($displayTitle)
    <div {{ $attributes->merge(['class' => 'pb-5 mb-6 border-b border-gray-200/70 dark:border-gray-700/70']) }}>
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            
            {{-- Left: Icon + Title & Subtitle --}}
            <div class="flex items-center gap-3.5 min-w-0">
                <div class="w-11 h-11 rounded-xl shrink-0 flex items-center justify-center text-white shadow-xs"
                     style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                </div>

                <div class="min-w-0">
                    <h1 class="text-xl sm:text-2xl font-bold tracking-tight {{ $textColor }}">
                        {{ $displayTitle }}
                    </h1>

                    @unless($titleOnly)
                        @if(!empty($displaySubtitle))
                            <p class="mt-0.5 text-xs sm:text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                                {{ $displaySubtitle }}
                            </p>
                        @endif
                    @endunless
                </div>
            </div>

            {{-- Optional Right Action Slot --}}
            @if(isset($slot) && !empty(trim($slot)))
                <div class="flex items-center gap-2 shrink-0 self-start sm:self-center">
                    {{ $slot }}
                </div>
            @endif

        </div>
    </div>
@endif
