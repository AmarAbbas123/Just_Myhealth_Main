{{-- This is Dynamic blade file and the data is purely coming from the DB, no specific blade files  --}}
<!--  (/mod-10/01/usr-therapy-types) "Available Therapy Types" For Patients {May we increase and update this in future}-->
<x-app1> {{-- app1 component --}}
        
    <div class="space-y-6">        
        <h1 class="text-2xl font-semibold mb-6"> {{ $menu->MainPaneLabel }}</h1>
        </span>

        <section class="py-12 bg-white w-full">
            <div class=" w-full">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                    @if ($children->isNotEmpty())
                        @foreach ($children as $child)
                            <!-- Card 1 -->
                            <div x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false"
                                class="bg-white rounded-2xl shadow-md p-6 text-center relative transform transition duration-300"
                                :class="{ 'scale-105 shadow-xl': hover }">
                                <!-- Icon circle -->
                                <div class="flex justify-center -mt-12 mb-4">
                                    <div class="bg-white rounded-full transition">
                                        <img src="{{ asset($child->ImagePath) }}" alt="{{ $child->ImagePath }}"
                                            class="w-48 h-48">
                                    </div>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900">{{ $child->MainPaneLabel }}</h3>
                                <p class="mt-3 text-gray-600 text-sm whitespace-pre-line" >
                                    {{ $child->TileText }}
                                </p>
                                {{-- <a href="{{ url(trim($child->MenuURL, '/')) }}"
                                    class="inline-block mt-5 bg-yellow-400 text-white px-6 py-2 rounded-full font-medium transform transition duration-300 hover:scale-105 hover:bg-yellow-500">
                                    Read More →
                                </a> --}}
                            </div>
                        @endforeach
                    @else
                        <p class="text-gray-600">No sub menus available.</p>
                    @endif

                </div>
            </div>

            {{-- BOTTOM INFO + CTA SECTION (ONLY FOR THIS PAGE) --}}
            @if (request()->is('mod-10/01/usr-therapy-types'))
            <div class="mt-16 rounded-2xl bg-green-200 shadow-md border border-red-200 px-6 max-w-5xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-6 items-center">

                    {{-- LEFT TEXT – 80% --}}
                    <div class="md:col-span-4 p-6">
                        <p class="text-gray-700 leading-relaxed text-base">
                            Whilst we offer many types of counselling, don’t worry about the specifics.
                            When you enroll in our counselling sessions, we will ask several relevant
                            questions which will allow our advanced counselling engine to identify
                            qualified therapists who can help with your specific difficulty.
                        </p>
                    </div>

                    {{-- RIGHT BUTTON – 20% --}}
                    <div class="md:col-span-1 flex justify-center">
                        {{-- <a href="request()->is('mod-10/01/usr-finances')" --}}
                        <a href="{{ route('pay.sessions.options') }}"
                            class="inline-block bg-green-600 text-white rounded-full font-semibold 
                            text-center w-full shadow-md hover:bg-green-700 transition px-3 py-2">
                            Purchase a block of therapy sessions so we can start to help
                        </a>
                    </div>
                </div>
            </div>
            @endif


        </section>

    </div>
</x-app1>
