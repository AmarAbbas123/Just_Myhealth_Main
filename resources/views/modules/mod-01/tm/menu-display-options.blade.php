<x-app1scrollxtable>


    @if (session('error'))
        <div class="mb-4 rounded bg-red-100 px-4 py-3 text-red-700">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="mb-4 rounded bg-green-100 px-4 py-3 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="px-6 mx-auto mt-6" x-data="crud()">

        <!-- Header -->
        <div class="flex justify-between mb-4">
            <x-page-header />
            <span>Welcome {{ Auth::user()->UserName ?? '' }}</span>
        </div>

        <div class="flex justify-end mb-4">
            <button @click="openCreate" class="px-4 py-2 bg-green-600 text-white rounded">
                + Add Menu Option
            </button>
        </div>

        <!-- TABLE WRAPPER (LOCAL HORIZONTAL SCROLL) -->
        <div class="border rounded shadow w-full overflow-x-auto">
            <div class="min-w-[1800px]">
                <table class="w-full text-xs border-collapse">

                    <!-- Header -->
                    <thead class="bg-gray-100 sticky top-0 z-10">
                        <tr>
                            <th class="px-3 py-2 whitespace-nowrap">#</th>

                            @foreach ([
                                'ParentID',
                                'DisplayName',
                                'MainPaneID',
                                'MainPaneLabel',
                                'TileText',
                                'Grouping',
                                '1',
                                '10',
                                '30',
                                '31',
                                '32',
                                '90',
                                '91',
                                'MenuURL',
                                'ImagePath',
                            ] as $col)
                                <th class="px-3 py-2 whitespace-nowrap">{{ $col }}</th>
                            @endforeach

                            <th class="px-3 py-2 whitespace-nowrap">Action</th>
                        </tr>
                    </thead>

                    <!-- Body -->
                    <tbody class="bg-white">
                        @foreach ($items as $index => $item)
                            <tr class="border-t hover:bg-gray-50">

                                <td class="px-3 py-2 whitespace-nowrap">
                                    {{ ($items->currentPage() - 1) * $items->perPage() + $index + 1 }}
                                </td>

                                <td class="px-3 py-2 whitespace-nowrap">{{ $item->ParentID }}</td>
                                <td class="px-3 py-2 whitespace-nowrap">{{ $item->DisplayName }}</td>
                                <td class="px-3 py-2 whitespace-nowrap">{{ $item->MainPaneID }}</td>
                                <td class="px-3 py-2 whitespace-nowrap">{{ $item->MainPaneLabel }}</td>
                                <td class="px-3 py-2 whitespace-nowrap">{{ $item->TileText }}</td>
                                <td class="px-3 py-2 whitespace-nowrap">{{ $item->Grouping }}</td>
                                <td class="px-3 py-2 whitespace-nowrap">{{ $item->{'1'} }}</td>
                                <td class="px-3 py-2 whitespace-nowrap">{{ $item->{'10'} }}</td>
                                <td class="px-3 py-2 whitespace-nowrap">{{ $item->{'30'} }}</td>
                                <td class="px-3 py-2 whitespace-nowrap">{{ $item->{'31'} }}</td>
                                <td class="px-3 py-2 whitespace-nowrap">{{ $item->{'32'} }}</td>
                                <td class="px-3 py-2 whitespace-nowrap">{{ $item->{'90'} }}</td>
                                <td class="px-3 py-2 whitespace-nowrap">{{ $item->{'91'} }}</td>
                                <td class="px-3 py-2 whitespace-nowrap">{{ $item->MenuURL }}</td>
                                <td class="px-3 py-2 whitespace-nowrap">{{ $item->ImagePath }}</td>

                                <td class="px-3 py-2 whitespace-nowrap flex gap-2">
                                    <button @click="openEdit(@js($item))" class="text-blue-600">✏️</button>

                                    <form method="POST"
                                          action="{{ route('menu-display-options.destroy', $item->ID) }}"
                                          onsubmit="return confirm('Delete this menu option?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600">🗑️</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>

        <div class="mt-4">
            {{ $items->links('pagination::tailwind') }}
        </div>

        <!-- MODAL -->
        <div x-show="open" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <form :action="formAction" method="POST"
                  class="bg-white p-6 rounded w-full max-w-4xl grid grid-cols-1 md:grid-cols-3 gap-4">
                @csrf
                <template x-if="edit">@method('PUT')</template>

                <template x-for="field in fields" :key="field.name">
                    <div>
                        <label class="block text-sm font-medium" x-text="field.label"></label>
                        <input type="text"
                               :name="field.name"
                               x-model="form[field.name]"
                               class="w-full border rounded px-3 py-2">
                    </div>
                </template>

                <div class="md:col-span-3 flex justify-end gap-3">
                    <button type="button" @click="close"
                            class="px-4 py-2 bg-gray-400 text-white rounded">
                        Cancel
                    </button>
                    <button class="px-4 py-2 bg-blue-600 text-white rounded">
                        Save
                    </button>
                </div>
            </form>
        </div>

    </div>

    <script>
        function crud() {
            return {
                open: false,
                edit: false,
                form: {},
                formAction: '',
                fields: [
                    { name: 'ParentID', label: 'ParentID' },
                    { name: 'DisplayName', label: 'DisplayName' },
                    { name: 'MainPaneID', label: 'MainPaneID' },
                    { name: 'MainPaneLabel', label: 'MainPaneLabel' },
                    { name: 'TileText', label: 'TileText' },
                    { name: 'Grouping', label: 'Grouping' },
                    { name: '1', label: '1' },
                    { name: '10', label: '10' },
                    { name: '30', label: '30' },
                    { name: '31', label: '31' },
                    { name: '32', label: '32' },
                    { name: '90', label: '90' },
                    { name: '91', label: '91' },
                    { name: 'MenuURL', label: 'MenuURL' },
                    { name: 'ImagePath', label: 'ImagePath' },
                ],

                openCreate() {
                    this.edit = false;
                    this.form = {};
                    this.formAction = "{{ route('menu-display-options.store') }}";
                    this.open = true;
                },

                openEdit(item) {
                    this.edit = true;
                    this.form = item;
                    this.formAction = "/mod-01/tm/menu-display-options/" + item.ID;
                    this.open = true;
                },

                close() {
                    this.open = false;
                }
            }
        }
    </script>

</x-app1scrollxtable>