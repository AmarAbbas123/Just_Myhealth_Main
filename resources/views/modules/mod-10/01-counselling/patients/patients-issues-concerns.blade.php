<x-app1>

    <div class="max-w-7xl mx-auto">
        <div class="bg-white shadow rounded-lg p-4">
            <!-- Header -->
            <div class="flex justify-between mb-4">
                <x-page-header />
            </div>

            @if (session('success'))
                <div class="mb-4 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('usr-raise-issue') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="primary_group_ref" class="block text-sm font-medium text-gray-700">
                        Choose general Concern Area
                    </label>
                    <select
                        id="primary_group_ref"
                        name="primary_group_ref"
                        required
                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Select a concern area</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->ID }}" @selected(old('primary_group_ref') == $category->ID)>
                                {{ $category->DisplayName }}
                            </option>
                        @endforeach
                    </select>
                    @error('primary_group_ref')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="secondary_group_ref" class="block text-sm font-medium text-gray-700">
                        Choose Specific Sub-Catagory
                    </label>
                    <select
                        id="secondary_group_ref"
                        name="secondary_group_ref"
                        required
                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">Select a sub-category</option>
                    </select>
                    @error('secondary_group_ref')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="issue_details" class="block text-sm font-medium text-gray-700">
                        Provide details of the issue or Concern
                    </label>
                    <textarea
                        id="issue_details"
                        name="issue_details"
                        rows="8"
                        maxlength="2048"
                        required
                        class="mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        placeholder="Please add the details that will help the team investigate or resolve this.">{{ old('issue_details') }}</textarea>
                    @error('issue_details')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button
                        type="submit"
                        class="rounded-md bg-indigo-600 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Submit issue
                    </button>
                </div>
            </form>


        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const subCategories = @json($subCategories);
            const primarySelect = document.getElementById('primary_group_ref');
            const secondarySelect = document.getElementById('secondary_group_ref');
            const selectedSecondary = @json(old('secondary_group_ref'));

            function renderSubCategories() {
                const parentId = primarySelect.value;
                const options = subCategories[parentId] || [];

                secondarySelect.innerHTML = '<option value="">Select a sub-category</option>';

                options.forEach((option) => {
                    const element = document.createElement('option');
                    element.value = option.ID;
                    element.textContent = option.DisplayName;

                    if (String(option.ID) === String(selectedSecondary)) {
                        element.selected = true;
                    }

                    secondarySelect.appendChild(element);
                });

                secondarySelect.disabled = options.length === 0;
            }

            primarySelect.addEventListener('change', renderSubCategories);
            renderSubCategories();
        });
    </script>

</x-app1>
