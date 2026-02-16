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
                        <th class="px-3 py-2 whitespace-nowrap">Actions</th>
                        @foreach ([
                            'ID' => 'No.',
                            'UserName' => 'UserName',
                            'FirstName' => 'First Name',
                            'LastName' => 'Last Name',
                            'Email' => 'Email',
                            'DOB' => 'DOB',
                            'Gender' => 'Gender',
                            'BaseCountry' => 'Country',
                            'BaseState' => 'State',
                            'BaseCity' => 'City',
                            'AccountStatus' => 'Status',
                            'UserCreatedDateTime' => 'Created',
                            'AccountSetupComplete' => 'Setup',
                        ] as $col => $label)
                            @php
                                $sortable = in_array($col, [                                    
                                    'UserName',
                                    'Email',
                                    'AccountStatus',
                                    'UserCreatedDateTime',
                                    'AccountSetupComplete',
                                ]);
                            @endphp
                            <th class="px-3 py-2 whitespace-nowrap">
                                @if ($sortable)
                                    <a
                                        href="{{ request()->fullUrlWithQuery([
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
                    </tr>
                </thead>

                <tbody>
                    @forelse ($items as $item)
                        @php
                            $attr = $item->userAttributes;
                            $type30 = $item->type30;
                            $displayName = trim(($attr->FirstName ?? '') . ' ' . ($attr->LastName ?? ''));
                            $displayName = $displayName !== '' ? $displayName : ($item->UserName ?? '');
                            $createdDate = $item->UserCreatedDateTime ?? $item->CreatedAt ?? $item->created_at;
                        @endphp
                        <tr class="border-t">
                            <td class="px-3 py-2">
                                <div class="flex gap-2">
                                    <button
                                        class="px-3 py-1 text-xs border border-green-500 text-green-700 rounded-full hover:bg-green-50"
                                        @click='openBioModal(@json($attr), @json($type30))'>
                                        BIO
                                    </button>
                                    <button
                                        class="px-3 py-1 text-xs border border-blue-500 text-blue-700 rounded-full hover:bg-blue-50"
                                        @click='openMessageModal({ id: {{ $item->ID }}, name: @json($displayName), userType: 30 })'>
                                        Message
                                    </button>
                                </div>
                            </td>
                            <td class="px-3 py-2"> {{ ($items->currentPage() - 1) * $items->perPage() + $loop->iteration }} </td>
                            <td class="px-3 py-2">{{ $item->UserName }}</td>
                            <td class="px-3 py-2">{{ $attr->FirstName ?? '' }}</td>
                            <td class="px-3 py-2">{{ $attr->LastName ?? '' }}</td>
                            <td class="px-3 py-2 text-blue-600">{{ $item->Email }}</td>
                            <td class="px-3 py-2">{{ $attr->DOB ?? '' }}</td>
                            <td class="px-3 py-2">{{ $attr->Gender ?? '' }}</td>
                            <td class="px-3 py-2">{{ $attr->BaseCountry ?? '' }}</td>
                            <td class="px-3 py-2">{{ $attr->BaseState ?? '' }}</td>
                            <td class="px-3 py-2">{{ $attr->BaseCity ?? '' }}</td>
                            <td class="px-3 py-2">{{ $item->AccountStatus ?? '' }}</td>
                            <td class="px-3 py-2">
                                {{ $createdDate ? \Illuminate\Support\Carbon::parse($createdDate)->format('Y-m-d') : '' }}
                            </td>
                            <td class="px-3 py-2">{{ $item->AccountSetupComplete ?? '' }}</td>
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
        <div x-show="isBioOpen" x-cloak
            class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4"
            @click.self="closeBioModal">

            <div class="bg-white rounded-xl w-full max-w-2xl p-6 shadow-xl overflow-y-auto max-h-[90vh]"
                @click.stop>

                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">
                        <span x-text="therapist.user.FirstName || ''"></span>
                        <span x-text="therapist.user.LastName || ''"></span>
                    </h2>

                    <button @click="closeBioModal" class="text-gray-500 text-xl">x</button>
                </div>

                <div class="space-y-3 text-sm text-gray-700">
                    <div>
                        <strong>Location:</strong>
                        <p class="text-sm text-gray-500 mb-4">
                            <span x-text="therapist.user.BaseCity || ''"></span>,
                            <span x-text="therapist.user.BaseState || ''"></span>,
                            <span x-text="therapist.user.BaseCountry || ''"></span>
                        </p>

                        <p><strong>Preferred Salutation:</strong>
                            <span x-text="therapist.type30.PreferredSalutation || ''"></span>
                        </p>

                        <p><strong>Primary Language:</strong>
                            <span x-text="therapist.type30.LanguagePrimary || ''"></span>
                        </p>

                        <p><strong>Secondary Language:</strong>
                            <span x-text="therapist.type30.LanguageSecondary || ''"></span>
                        </p>
                    </div>

                    <h3 class="text-lg font-semibold mb-3">Therapy Services</h3>
                    <div class="space-y-3">
                        <template x-for="i in [1,2,3,4,5]">
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
                    </div>

                    <h3 class="text-lg font-semibold mb-3">Qualifications</h3>
                    <div class="space-y-3">
                        <template x-for="i in [1,2,3,4]">
                            <div x-show="therapist.type30['QualificationTitle'+i]"
                                class="border rounded-lg p-3 bg-gray-50">
                                <p><strong x-text="therapist.type30['QualificationTitle'+i]"></strong></p>
                                <p x-text="therapist.type30['QualificationFrom'+i]"></p>
                                <p x-text="therapist.type30['QualificationLevel'+i]"></p>
                            </div>
                        </template>
                    </div>

                    <h3 class="text-lg font-semibold mb-3">Bio Details</h3>
                    <div class="space-y-3 text-sm text-gray-700">
                        <template x-for="i in [1,2,3,4,5,6]">
                            <p x-show="therapist.type30['BioTextParagraph'+i]"
                                x-text="therapist.type30['BioTextParagraph'+i]"></p>
                        </template>
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
        <div x-show="isMessageOpen" x-cloak
            class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4"
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
                    <textarea x-model="messageText" rows="4"
                        class="w-full border rounded px-3 py-2 text-sm"
                        placeholder="Type your message..."></textarea>

                    <div class="mt-4 flex justify-end gap-2">
                        <button type="button" @click="closeMessageModal"
                            class="px-4 py-2 bg-gray-300 rounded-lg text-sm">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm"
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

                openBioModal(userAttributes, type30) {
                    this.therapist = {
                        user: userAttributes || {},
                        type30: type30 || {}
                    };
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
