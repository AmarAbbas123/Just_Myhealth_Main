<x-app1>

    @if (session('success'))
        <div class="mt-4 p-3 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <!-- Header -->
    <div x-data="{ open: false }" class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

        <x-page-header />

        <div x-data="{ type: 'private', folder: 'Folder01' }" class="flex items-center gap-3">

            <!-- TYPE DROPDOWN -->
            <div class="relative">
                <select x-model="type"
                    class="appearance-none border border-gray-300 rounded-md px-4 py-2 pr-10 text-sm bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="private">Private</option>
                    <option value="common">Common</option>
                </select>
        
                <!-- Arrow -->
                <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-400 text-xs">                    
                </div>
            </div>
        
            <!-- FOLDER DROPDOWN -->
            <div class="relative">
                <select x-model="folder"
                    class="appearance-none border border-gray-300 rounded-md px-4 py-2 pr-10 text-sm bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
        
                    @foreach($folders as $f)
                        <option value="{{ $f }}">{{ $f }}</option>
                    @endforeach
        
                </select>
        
                <!-- Arrow -->
                <div class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-gray-400 text-xs">                    
                </div>
            </div>
        
            <!-- UPLOAD BUTTON -->
            <button @click="$refs.file.click()"
                class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md text-sm shadow transition">
                + Upload
            </button>
        
            <!-- HIDDEN FORM -->
            <form x-ref="form" method="POST" action="{{ route('collateral.upload') }}" enctype="multipart/form-data"
                class="hidden">
                @csrf
                <input type="hidden" name="type" :value="type">
                <input type="hidden" name="folder" :value="folder">
                <input type="file" name="file" x-ref="file" @change="$refs.form.submit()">
            </form>
        
        </div>
    </div>

    {{-- <h3 class="mt-6 mb-2 font-semibold text-lg">Documents</h3> --}}

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">File Name</th>
                    <th class="px-4 py-3">Type</th>
                    <th class="px-4 py-3">Folder</th>
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3">Size</th>
                    <th class="px-4 py-3 text-center">Action</th>
                </tr>
            </thead>

            <tbody class="divide-y">

                @foreach ($files as $index => $file)
                    @php
                        $meta = Storage::disk('therapy_docs')->lastModified($file['path']);
                        $size = Storage::disk('therapy_docs')->size($file['path']);
                    @endphp

                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3">{{ $index + 1 }}</td>

                        <td class="px-4 py-3 font-medium text-gray-800">
                            {{ $file['name'] }}
                        </td>

                        <td class="px-4 py-3">
                            @if ($file['type'] === 'common')
                                <span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded">Common</span>
                            @else
                                <span class="px-2 py-1 text-xs bg-gray-100 text-gray-700 rounded">Private</span>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-gray-500">{{ $file['folder'] ?? '-' }}</td>

                        <td class="px-4 py-3 text-gray-500">
                            {{ date('d M Y', $meta) }}
                        </td>

                        <td class="px-4 py-3 text-gray-500">
                            {{ round($size / 1024 / 1024, 2) }} Mb
                        </td>

                        <td class="px-4 py-3 flex justify-center gap-2">

                            <!-- Download -->
                            <a href="{{ route('collateral.download', ['type' => $file['type'], 'folder' => $file['name'], 'file' => $file['name']]) }}"
                                class="px-3 py-1 bg-green-100 text-green-700 rounded-md text-xs hover:bg-green-200">
                                Download
                            </a>


                            <form method="POST"
                                action="{{ route('collateral.delete', ['type' => $file['type'], 'folder' => $file['name'], 'file' => $file['name']]) }}">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-1 bg-red-100 text-red-700 rounded-md text-xs hover:bg-red-200">
                                    Delete
                                </button>
                            </form>


                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>



</x-app1>
