<x-app1scrollxtable>
    <div class="px-6 mx-auto mt-6" x-data="therapistsStatus()">

        <!-- Header -->
        <div class="flex justify-between mb-4">
            <x-page-header :menu="$menu ?? null" />
            <span>Welcome {{ Auth::user()->UserName ?? null }}</span>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="w-full text-sm">
                <thead class="bg-gray-100 text-xs uppercase text-gray-600">
                    <tr>
                        @foreach ([
                                    'ID' => 'No.',
                                    'UserName' => 'UserName',
                                    'FirstName' => 'First Name',
                                    'LastName' => 'Last Name',
                                    'DOB' => 'DOB',
                                    'AccountStatus' => 'Status',
                                ] as $col => $label)
                            @php
                                $sortable = in_array($col, ['UserName', 'AccountStatus']);
                            @endphp
                            <th class="px-3 py-2 whitespace-nowrap">
                                @if ($sortable)
                                    <a href="{{ request()->fullUrlWithQuery([
                                        'sort_by' => $col,
                                        'sort_dir' => $sortBy == $col && $sortDir == 'asc' ? 'desc' : 'asc',
                                    ]) }}"
                                        class="hover:underline">
                                        {{ $label }}
                                        @if ($sortBy == $col)
                                            {{ $sortDir == 'asc' ? '^' : 'v' }}
                                        @endif
                                    </a>
                                @else
                                    {{ $label }}
                                @endif
                            </th>
                        @endforeach

                        <th class="px-3 py-2 whitespace-nowrap">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($items as $item)
                        @php
                            $attr = $item->userAttributes;
                            $type30 = $item->type30;
                            $displayName = trim(($attr->FirstName ?? '') . ' ' . ($attr->LastName ?? ''));
                            $displayName = $displayName !== '' ? $displayName : $item->UserName ?? '';
                            $createdDate = $item->UserCreatedDateTime ?? ($item->CreatedAt ?? $item->created_at);
                        @endphp
                        <tr class="border-t">
                            <td class="px-3 py-2">
                                {{ ($items->currentPage() - 1) * $items->perPage() + $loop->iteration }} </td>
                            <td class="px-3 py-2">{{ $item->UserName }}</td>
                            <td class="px-3 py-2">{{ $attr->FirstName ?? '' }}</td>
                            <td class="px-3 py-2">{{ $attr->LastName ?? '' }}</td>
                            <td class="px-3 py-2">{{ $attr->DOB ?? '' }}</td>
                            <td class="px-3 py-2">{{ $item->AccountStatus ?? '' }}</td>
                            <td class="px-3 py-2">

                                <div class="flex gap-2 flex-nowrap overflow-x-auto items-start">

                                    <!-- FIRST 4 → CAPSULE + TWO LINES -->
                                    <button
                                        class="px-5 py-1 text-[11px] leading-tight font-medium 
                                               bg-emerald-600 text-white 
                                               rounded-full 
                                               shadow-sm hover:bg-emerald-700 
                                               transition-all
                                               min-w-[110px]
                                               text-center break-words"  @click='openBioModal("personal", @json($attr), @json($type30))'>
                                        Review<br>Personal Data
                                    </button>

                                    <button
                                        class="px-5 py-1 text-[11px] leading-tight font-medium 
                                               bg-emerald-600 text-white 
                                               rounded-full 
                                               shadow-sm hover:bg-emerald-700 
                                               transition-all
                                               min-w-[110px]
                                               text-center break-words"  @click='openBioModal("identity", @json($attr), @json($type30))'>
                                        Review<br>Identity
                                    </button>

                                    <button
                                        class="px-5 py-1 text-[11px] leading-tight font-medium 
                                               bg-emerald-600 text-white 
                                               rounded-full 
                                               shadow-sm hover:bg-emerald-700 
                                               transition-all
                                               min-w-[110px]
                                               text-center break-words"  @click='openBioModal("qualification", @json($attr), @json($type30))'>
                                        Review<br>Qualification
                                    </button>

                                    <button
                                        class="px-5 py-1 text-[11px] leading-tight font-medium 
                                               bg-emerald-600 text-white 
                                               rounded-full 
                                               shadow-sm hover:bg-emerald-700 
                                               transition-all
                                               min-w-[110px]
                                               text-center break-words"  @click='openBioModal("experience", @json($attr), @json($type30))'>
                                        Review<br>Experience
                                    </button>

                                    <!-- LAST 3 → RECTANGLE + SINGLE LINE -->
                                    <button
                                        class="px-5 py-1 text-[11px] font-semibold 
                                               bg-emerald-600 text-white 
                                               rounded-md 
                                               shadow-sm hover:bg-emerald-700 
                                               transition-all
                                               whitespace-nowrap
                                               min-w-[100px]">
                                        APPROVE
                                    </button>

                                    <button
                                        class="px-5 py-1 text-[11px] font-medium 
                                               bg-amber-500 text-white 
                                               rounded-md 
                                               shadow-sm hover:bg-amber-600 
                                               transition-all
                                               whitespace-nowrap
                                               min-w-[120px]" @click='openMessageModal({ id: {{ $item->ID }}, name: @json($displayName), userType: 30 })'>
                                        Further Review
                                    </button>

                                    <button
                                        class="px-5 py-1 text-[11px] font-semibold 
                                               bg-red-600 text-white 
                                               rounded-md 
                                               shadow-sm hover:bg-red-700 
                                               transition-all
                                               whitespace-nowrap
                                               min-w-[100px]" @click='openMessageModal({ id: {{ $item->ID }}, name: @json($displayName), userType: 30 })'>
                                        REJECT
                                    </button>

                                </div>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-3 py-6 text-center text-gray-500" colspan="14">
                                No therapists found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $items->links('pagination::tailwind') }}</div>

        <!-- BIO MODAL -->
        <div x-show="isBioOpen" x-cloak class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4"
            @click.self="closeBioModal">

            <div class="bg-white rounded-xl w-full max-w-2xl p-6 shadow-xl overflow-y-auto max-h-[90vh]" @click.stop>

                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">
                        <span x-text="therapist.user.FirstName || ''"></span>
                        <span x-text="therapist.user.LastName || ''"></span>
                        <span class="text-gray-500 text-base font-medium ml-2" x-text="sectionTitles[reviewSection] || ''"></span>
                    </h2>

                    <button @click="closeBioModal" class="text-gray-500 text-xl">x</button>
                </div>

                <div class="space-y-3 text-sm text-gray-700">
                    <div x-show="reviewSection === 'personal'" class="space-y-2">
                        <template x-for="field in personalFields" :key="field.key">
                            <p x-show="therapist.user[field.key]">
                                <strong x-text="field.label + ':'"></strong>
                                <span x-text="therapist.user[field.key]"></span>
                            </p>
                        </template>
                        <p x-show="!hasAnyPersonalData()" class="text-gray-500">No personal data found.</p>
                    </div>

                    <div x-show="reviewSection === 'identity'" class="space-y-2">
                        <template x-for="doc in identityDocs" :key="doc.key">
                            <div x-show="therapist.type30[doc.key]" class="flex items-center justify-between border rounded-lg p-3 bg-gray-50">
                                <span class="font-medium" x-text="doc.label"></span>
                                <a class="text-blue-600 underline text-sm" target="_blank"
                                    :href="storageUrl(therapist.type30[doc.key], 'documents')">View</a>
                            </div>
                        </template>
                        <p x-show="!hasAnyIdentityDocs()" class="text-gray-500">No identity documents found.</p>
                    </div>

                    <div x-show="reviewSection === 'qualification'" class="space-y-3">
                        <template x-for="i in [1,2,3,4]" :key="i">
                            <div x-show="therapist.type30['QualificationTitle'+i]" class="border rounded-lg p-3 bg-gray-50">
                                <p><strong x-text="therapist.type30['QualificationTitle'+i]"></strong></p>
                                <p x-text="therapist.type30['QualificationFrom'+i]"></p>
                                <p x-text="therapist.type30['QualificationLevel'+i]"></p>
                                <p x-show="therapist.type30['QualificationGrade'+i]" x-text="therapist.type30['QualificationGrade'+i]"></p>
                                <p x-show="therapist.type30['QualificationDateComplete'+i]" x-text="therapist.type30['QualificationDateComplete'+i]"></p>
                                <p x-show="therapist.type30['QualificationImagePath'+i]">
                                    <a class="text-blue-600 underline text-sm" target="_blank"
                                        :href="storageUrl(therapist.type30['QualificationImagePath'+i], 'qualification-files')">View Certificate</a>
                                </p>
                            </div>
                        </template>
                        <p x-show="!hasAnyQualification()" class="text-gray-500">No qualifications found.</p>
                    </div>

                    <div x-show="reviewSection === 'experience'" class="space-y-3">
                        <template x-for="i in [1,2,3,4,5]" :key="i">
                            <div x-show="therapist.type30['TherapyType'+i]" class="border rounded-lg p-3 bg-gray-50">
                                <p>
                                    <strong>Type:</strong>
                                    <span x-text="therapist.type30['TherapyType'+i]"></span>
                                </p>
                                <p>
                                    <strong>Experience:</strong>
                                    <span x-text="therapist.type30['TherapyYearsExperience'+i]"></span> years
                                </p>
                            </div>
                        </template>
                        <p x-show="!hasAnyExperience()" class="text-gray-500">No experience data found.</p>
                    </div>
                </div>

                <div class="mt-6 text-right">
                    <button @click="closeBioModal" class="px-4 py-2 bg-gray-300 rounded-lg text-sm">
                        Close
                    </button>
                </div>

            </div>
        </div>

        <!-- MESSAGE MODAL -->
        <div x-show="isMessageOpen" x-cloak class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4"
            @click.self="closeMessageModal">

            <div class="bg-white rounded-xl w-full max-w-lg p-6 shadow-xl" @click.stop>
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold text-gray-800">
                        Send Message
                    </h2>
                    <button @click="closeMessageModal" class="text-gray-500 text-xl">x</button>
                </div>

                <p class="text-sm text-gray-600 mb-3">
                    To: <span class="font-medium" x-text="messageTarget.name || 'Therapist'"></span>
                </p>

                <form @submit.prevent="sendMessage">
                    <textarea x-model="messageText" rows="4" class="w-full border rounded px-3 py-2 text-sm"
                        placeholder="Type your message..."></textarea>

                    <div class="mt-4 flex justify-end gap-2">
                        <button type="button" @click="closeMessageModal"
                            class="px-4 py-2 bg-gray-300 rounded-lg text-sm">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm"
                            :disabled="sending">
                            <span x-show="!sending">Send</span>
                            <span x-show="sending">Sending...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script>
        function therapistsStatus() {
            return {
                isBioOpen: false,
                isMessageOpen: false,
                sending: false,
                messageText: '',
                reviewSection: 'personal',
                sectionTitles: {
                    personal: 'Review Personal Data',
                    identity: 'Review Identity',
                    qualification: 'Review Qualification',
                    experience: 'Review Experience'
                },
                personalFields: [
                    { label: 'First Name', key: 'FirstName' },
                    { label: 'Last Name', key: 'LastName' },
                    { label: 'DOB', key: 'DOB' },
                    { label: 'Year of Birth', key: 'YearBirth' },
                    { label: 'Gender', key: 'Gender' },
                    { label: 'Base City', key: 'BaseCity' },
                    { label: 'Base State', key: 'BaseState' },
                    { label: 'Base Country', key: 'BaseCountry' },
                    { label: 'Business Name', key: 'BusinessName' },
                    { label: 'Business Contact First Name', key: 'BusinessContactFirstName' },
                    { label: 'Business Contact Last Name', key: 'BusinessContactLastName' },
                    { label: 'Business Primary Industry', key: 'BusinessPrimaryIndustry' },
                    { label: 'Business Sub Industry', key: 'BusinessSubIndustry' },
                    { label: 'Business Type', key: 'BusinessType' },
                    { label: 'Address 1', key: 'Address1' },
                    { label: 'Address 2', key: 'Address2' },
                    { label: 'Base Zip', key: 'BaseZip' }
                ],
                identityDocs: [
                    { label: 'Passport', key: 'VerificationPassportImagePath' },
                    { label: 'BACP Card', key: 'VerificationBACPCardImagePath' },
                    { label: 'Liability Insurance', key: 'VerificationLiabilityInsuranceImagePath' },
                    { label: 'DBS', key: 'VerificationDBSImagePath' }
                ],
                messageTarget: {
                    id: null,
                    name: '',
                    userType: 30
                },
                therapist: {
                    user: {},
                    type30: {}
                },
                zim: null,
                isZimLoggedIn: false,

                hasAnyPersonalData() {
                    return this.personalFields.some((field) => this.therapist.user[field.key]);
                },
                hasAnyIdentityDocs() {
                    return this.identityDocs.some((doc) => this.therapist.type30[doc.key]);
                },
                hasAnyQualification() {
                    return [1, 2, 3, 4].some((i) => this.therapist.type30['QualificationTitle' + i]);
                },
                hasAnyExperience() {
                    return [1, 2, 3, 4, 5].some((i) => this.therapist.type30['TherapyType' + i]);
                },
                storageUrl(path, folder) {
                    if (!path) return '';
                    const raw = String(path).trim();
                    if (!raw) return '';

                    if (raw.startsWith('http://') || raw.startsWith('https://')) return raw;
                    if (raw.startsWith('/storage/')) return raw;
                    if (raw.startsWith('storage/')) return '/' + raw;
                    if (raw.startsWith('/')) return raw;

                    if (folder && raw.startsWith(folder + '/')) return '/storage/' + raw;
                    return '/storage/' + (folder ? folder + '/' : '') + raw;
                },
                openBioModal(section, userAttributes, type30) {
                    this.therapist = {
                        user: userAttributes || {},
                        type30: type30 || {}
                    };
                    this.reviewSection = section || 'personal';
                    this.isBioOpen = true;
                },
                closeBioModal() {
                    this.isBioOpen = false;
                },
                async openMessageModal(target) {
                    this.messageTarget = Object.assign({
                        userType: 30
                    }, target || {});
                    this.messageText = '';
                    this.isMessageOpen = true;
                    if (!this.isZimLoggedIn) {
                        await this.initZego();
                    }
                },
                closeMessageModal() {
                    this.isMessageOpen = false;
                },
                async initZego() {
                    try {
                        const res = await fetch('/zego/chat-token', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });
                        const data = await res.json();

                        if (!ZIM.getInstance()) {
                            ZIM.create({
                                appID: data.appID
                            });
                        }
                        this.zim = ZIM.getInstance();
                        this.zim.on('error', (zim, err) => console.error('ZIM error', err));

                        await this.zim.login(data.userID, {
                            userName: data.userName,
                            token: data.token
                        });

                        this.isZimLoggedIn = true;
                    } catch (err) {
                        console.error('Zego init failed', err);
                    }
                },
                async sendMessage() {
                    if (this.sending || !this.messageText.trim() || !this.messageTarget.id) return;
                    this.sending = true;

                    const text = this.messageText.trim();

                    try {
                        await fetch('/chat/store-message', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                to_user_id: this.messageTarget.id,
                                to_user_type: this.messageTarget.userType || 30,
                                message: text
                            })
                        });

                        if (this.isZimLoggedIn && this.zim) {
                            await this.zim.sendMessage({
                                type: 1,
                                message: ''
                            }, String(this.messageTarget.id), 0, {
                                priority: 1
                            });
                        }

                        this.messageText = '';
                        this.isMessageOpen = false;
                    } catch (err) {
                        console.error('Send message failed', err);
                    } finally {
                        this.sending = false;
                    }
                }
            }
        }
    </script>
</x-app1scrollxtable>
