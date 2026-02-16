{{-- resources/views/profile/show.blade.php -------------------------------- --}}
<x-app1> {{-- app1 component --}}
    {{-- Back link ----------- --}}
    <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm text-blue-600 hover:underline">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Back to Dashboard
    </a>


    {{-- HEADER & AVATAR ----------------------------------------------------- --}}
    <section class="relative isolate mt-4">

        {{-- Cover photo --}}
        <div class="h-56 sm:h-64 lg:h-72 w-full bg-center bg-cover rounded-lg shadow"
            style="background-image:url('{{ Auth::user()->HeaderPhotoPath ? asset('storage/' . Auth::user()->HeaderPhotoPath) : asset('default-cover.jpg') }}')">
            <div class="absolute inset-0 bg-black/30 rounded-lg"></div>

            {{-- Change cover btn --}}
            <form action="{{ route('profile.header.upload') }}" method="POST" enctype="multipart/form-data"
                x-data="{ preview: null }" class="absolute bottom-3 right-3 flex">
                @csrf
                <input type="file" name="header" accept="image/*" class="hidden" x-ref="headerInput"
                    @change="preview = URL.createObjectURL($event.target.files[0]); $el.form.submit()">

                <button type="button"
                    class="inline-flex items-center px-4 py-2 bg-[#55B4B8] text-white rounded-md shadow hover:bg-[#4aa0a4] transition"
                    x-on:click.prevent="$refs.headerInput.click()">
                    Change cover
                </button>
            </form>
        </div>

        {{-- Avatar --}}
        <div class="absolute -bottom-16 sm:-bottom-20 left-1/2 sm:left-8 transform -translate-x-1/2 sm:translate-x-0">
            <div class="relative group" x-data="{ preview: null }">

                {{-- Show preview OR DB image --}}
                <img :src="preview ? preview :
                    '{{ Auth::user()->ProfilePhotoPath ? asset('storage/' . Auth::user()->ProfilePhotoPath) : asset('default-avatar.png') }}'"
                    class="w-24 h-24 rounded-full object-cover border sm:w-40 sm:h-40 ring-4 ring-white shadow-lg">

                {{-- Change photo overlay --}}
                <form action="{{ route('profile.avatar.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="avatar" accept="image/*" class="hidden" x-ref="avatarInput"
                        @change="preview = URL.createObjectURL($event.target.files[0]); $el.form.submit()">

                    <button type="button"
                        class="absolute inset-0 rounded-full bg-black/50 text-white
                                   opacity-0 group-hover:opacity-100 flex items-center
                                   justify-center transition"
                        x-on:click.prevent="$refs.avatarInput.click()">
                        Change photo
                    </button>
                </form>
            </div>
        </div>

    </section>


    {{-- MAIN CARD ----------------------------------------------------------- --}}
    <div class="pt-20 sm:pt-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow sm:rounded-lg p-6 grid gap-10 lg:grid-cols-3">

            {{-- Profile basics (name, email) --}}
            <aside class="text-center lg:text-left">
                <h1 class="text-2xl font-semibold text-gray-800">
                    {{ Auth::user()->UserName }}

                </h1>
                <p class="text-sm text-gray-500">{{ Auth::user()->Email }}</p>
            </aside>

            {{-- Forms --}}
            <section class="lg:col-span-2 space-y-10">
                @include('modules.mod-00.profile.partials.update-profile-information-form')
                @include('modules.mod-00.profile.partials.update-password-form')
                @include('modules.mod-00.profile.partials.delete-user-form')
            </section>
        </div>
    </div>
</x-app1>
