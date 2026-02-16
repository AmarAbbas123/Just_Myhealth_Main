<x-app1>

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
            <span>Welcome {{ Auth::user()->UserName ?? null }}</span>
        </div>

        <div class="flex justify-end mb-4">
            <button @click="openCreate" class="px-4 py-2 bg-green-600 text-white rounded">
                + Add Module
            </button>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        @foreach ([
                                     '#' => '#',
                                     'ModuleRef' => 'Module Ref',
                                     'ModuleSubRef' => 'Sub Ref',
                                     'ModuleFull' => 'Module Full',
                                     'ModuleDesc' => 'Module Desc',
                                     'ModuleStatus' => 'Module Status',
                                   ] as $col => $label)
                            <th class="px-3 py-2">
                                <a
                                    href="{{ request()->fullUrlWithQuery([
                                        'sort_by' => $col,
                                        'sort_dir' => $sortBy == $col && $sortDir == 'asc' ? 'desc' : 'asc',
                                    ]) }}">
                                    {{ $label }}

                                    @if ($sortBy == $col)
                                        {{ $sortDir == 'asc' ? '↑' : '↓' }}
                                    @endif
                                </a>
                            </th>
                        @endforeach
                        <th class="px-3 py-2">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($items as $index => $item)
                        <tr class="border-t">
                            <!-- Serial Number -->
                            <td class="px-3 py-2"> {{ ($items->currentPage() - 1) * $items->perPage() + $index + 1 }} </td>
                            <td class="px-3 py-2">{{ $item->ModuleRef }}</td>
                            <td class="px-3 py-2">{{ $item->ModuleSubRef }}</td>
                            <td class="px-3 py-2">{{ $item->ModuleFull }}</td>
                            <td class="px-3 py-2">{{ $item->ModuleDesc }}</td>
                            <td class="px-3 py-2">{{ $item->ModuleStatus }}</td>
                            <td class="px-3 py-2 flex gap-2">
                                <button @click="openEdit(@js($item))"
                                    class="text-blue-600">✏️</button>

                                <form method="POST" action="{{ route('module-list.destroy', $item->ID) }}"
                                    onsubmit="return confirm('Delete?')">
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

        <div class="mt-4">{{ $items->links('pagination::tailwind') }}</div>

        <!-- Modal -->
        <div x-show="open" class="fixed inset-0 bg-black/50 flex items-center justify-center">

            <form :action="formAction" method="POST"
                class="bg-white p-6 rounded w-full max-w-2xl grid grid-cols-1 md:grid-cols-2 gap-4">
                @csrf
                <template x-if="edit">@method('PUT')</template>

                <template x-for="field in fields">
                    <div :class="field.full ? 'md:col-span-2' : ''">
                        <label class="block text-sm font-medium" x-text="field.label"></label>
                        <template x-if="!field.textarea && field.type !== 'select'">
                            <input type="text" :name="field.name" x-model="form[field.name]"
                                class="w-full border rounded px-3 py-2" required>
                        </template>

                        <template x-if="field.type === 'select'">
                            <select :name="field.name" x-model="form[field.name]"
                                class="w-full border rounded px-3 py-2" required>
                                <template x-for="opt in field.options">
                                    <option :value="opt" x-text="opt"></option>
                                </template>
                            </select>
                        </template>

                        <template x-if="field.textarea">
                            <textarea :name="field.name" x-model="form[field.name]" class="w-full border rounded px-3 py-2" rows="3"
                                required></textarea>
                        </template>

                    </div>
                </template>

                <div class="md:col-span-2 flex justify-end gap-3">
                    <button type="button" @click="close" class="px-4 py-2 bg-gray-400 text-white rounded">
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
                fields: [{
                        name: 'ModuleRef',
                        label: 'Module Ref'
                    },
                    {
                        name: 'ModuleSubRef',
                        label: 'Module Sub Ref'
                    },
                    {
                        name: 'ModuleFull',
                        label: 'Module Full'
                    },
                    {
                        name: 'ModuleDesc',
                        label: 'Module Desc'
                    },
                    {
                        name: 'ModuleStatus',
                        label: 'Module Status',
                        type: 'select',
                        options: ['Active', 'Disabled', 'Testing', 'Development', 'New'],
                        full: true
                    },
                ],
                openCreate() {
                    this.edit = false;
                    this.form = {};
                    this.formAction = "{{ route('module-list.store') }}";
                    this.open = true;
                },
                openEdit(item) {
                    this.edit = true;
                    this.form = item;
                    this.formAction = "/mod-01/tm/module-list/" + item.ID;
                    this.open = true;
                },
                close() {
                    this.open = false;
                }
            }
        }
    </script>
</x-app1>
