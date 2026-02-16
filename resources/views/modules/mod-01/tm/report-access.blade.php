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
                + Add Report Permission
            </button>
        </div>

        <!-- Table container with local horizontal scroll -->
        <div class="border rounded shadow w-full overflow-x-auto">
            <div class="min-w-[1600px]">
                <table class="w-full text-xs border-collapse">
                    <thead class="bg-gray-100 sticky top-0 z-10">
                        <tr>
                            <th class="px-3 py-2 whitespace-nowrap">#</th>

                            @foreach ([
                                'ReportName','ReportCells','ReportStyle',
                                'JMH_Super_Admin_90','JMH_System_Admin_91','JMH_Finance_Admin_92',
                                'JMH_Regional_Admin_93','JMH_National_Admin_94','JMH_Group_Admin_95',
                                'PRO_Group_Admin_40','PRO_Group_Manager_41','PRO_Group_Team_Leader_42',
                                'MED_Group_Admin_20','MED_Group_Manager_21','MED_Group_Team_leader_22'
                            ] as $col)
                                <th class="px-3 py-2 whitespace-nowrap">{{ $col }}</th>
                            @endforeach

                            <th class="px-3 py-2 whitespace-nowrap">Action</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white">
                        @foreach ($items as $index => $item)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-3 py-2 whitespace-nowrap">
                                    {{ ($items->currentPage() - 1) * $items->perPage() + $index + 1 }}
                                </td>

                                @foreach ([
                                    'ReportName','ReportCells','ReportStyle',
                                    'JMH_Super_Admin_90','JMH_System_Admin_91','JMH_Finance_Admin_92',
                                    'JMH_Regional_Admin_93','JMH_National_Admin_94','JMH_Group_Admin_95',
                                    'PRO_Group_Admin_40','PRO_Group_Manager_41','PRO_Group_Team_Leader_42',
                                    'MED_Group_Admin_20','MED_Group_Manager_21','MED_Group_Team_leader_22'
                                ] as $col)
                                    <td class="px-3 py-2 whitespace-nowrap">{{ $item->$col }}</td>
                                @endforeach

                                <td class="px-3 py-2 whitespace-nowrap flex gap-2">
                                    <button @click="openEdit(@js($item))" class="text-blue-600">✏️</button>
                                    <form method="POST"
                                          action="{{ route('report-access.destroy', $item->ID) }}"
                                          onsubmit="return confirm('Delete this report permission?')">
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

        <!-- Modal -->
        <div x-show="open" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <form :action="formAction" method="POST"
                  class="bg-white p-6 rounded w-full max-w-4xl grid grid-cols-1 md:grid-cols-3 gap-4">
                @csrf
                <template x-if="edit">@method('PUT')</template>

                <template x-for="field in fields" :key="field.name">
                    <div>
                        <label class="block text-sm font-medium" x-text="field.label"></label>
                        <!-- Only change: dynamic type -->
                        <input :type="field.type"
                               :name="field.name"
                               x-model="form[field.name]"
                               class="w-full border rounded px-3 py-2"
                               required>
                    </div>
                </template>

                <div class="md:col-span-3 flex justify-end gap-3">
                    <button type="button" @click="close" class="px-4 py-2 bg-gray-400 text-white rounded">
                        Cancel
                    </button>
                    <button class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
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
                    { name: 'ReportName', label: 'ReportName', type: 'text' },
                    { name: 'ReportCells', label: 'ReportCells', type: 'number' },
                    { name: 'ReportStyle', label: 'ReportStyle', type: 'text' },
                    { name: 'JMH_Super_Admin_90', label: 'JMH_Super_Admin_90', type: 'number' },
                    { name: 'JMH_System_Admin_91', label: 'JMH_System_Admin_91', type: 'number' },
                    { name: 'JMH_Finance_Admin_92', label: 'JMH_Finance_Admin_92', type: 'number' },
                    { name: 'JMH_Regional_Admin_93', label: 'JMH_Regional_Admin_93', type: 'number' },
                    { name: 'JMH_National_Admin_94', label: 'JMH_National_Admin_94', type: 'number' },
                    { name: 'JMH_Group_Admin_95', label: 'JMH_Group_Admin_95', type: 'number' },
                    { name: 'PRO_Group_Admin_40', label: 'PRO_Group_Admin_40', type: 'number' },
                    { name: 'PRO_Group_Manager_41', label: 'PRO_Group_Manager_41', type: 'number' },
                    { name: 'PRO_Group_Team_Leader_42', label: 'PRO_Group_Team_Leader_42', type: 'number' },
                    { name: 'MED_Group_Admin_20', label: 'MED_Group_Admin_20', type: 'number' },
                    { name: 'MED_Group_Manager_21', label: 'MED_Group_Manager_21', type: 'number' },
                    { name: 'MED_Group_Team_leader_22', label: 'MED_Group_Team_leader_22', type: 'number' },
                ],

                openCreate() {
                    this.edit = false;
                    this.form = {};
                    this.formAction = "{{ route('report-access.store') }}";
                    this.open = true;
                },

                openEdit(item) {
                    this.edit = true;
                    this.form = item;
                    this.formAction = "/mod-01/tm/report-access/" + item.ID;
                    this.open = true;
                },

                close() {
                    this.open = false;
                }
            }
        }
    </script>

</x-app1scrollxtable>