<x-app1>

    @php
        $matchConfig = [
            'mode' => $mode,
            'totalQuestions' => $totalQuestions,
            'question' => $question ?? null,
            'nextQuestion' => $nextQuestion ?? null,
            'questions' => $questions ?? [],
            'answers' => $answers ?? null,
        ];
    @endphp

    <div class="max-w-4xl mx-auto py-10 px-4"
        x-data='therapistMatchQuestions(@json($matchConfig))'>

        <!-- WIZARD MODE -->
        <div x-show="mode === 'wizard'" x-transition>
            <div class="bg-white shadow-md rounded-xl p-8 border border-gray-200" x-show="!finished" x-transition>

                <div class="flex justify-between mb-4">
                    <x-page-header />
                </div>

                <div class="text-lg font-bold text-gray-900 mb-2">
                    Question <span x-text="questionNumber"></span> of <span x-text="totalQuestions"></span>
                </div>

                <h3 class="text-xl font-semibold text-gray-800 mb-2" x-text="currentQuestion.QuestionHeading">
                </h3>

                <p class="text-sm text-gray-500 mb-6 leading-relaxed" x-text="currentQuestion.QuestionNotes">
                </p>

                <div class="space-y-3">
                    <template x-for="(opt, index) in options()" :key="index">
                        <label
                            class="flex items-center gap-3 cursor-pointer bg-gray-50 hover:bg-gray-100 px-4 py-3 rounded-lg border border-gray-200">
                            <input type="checkbox" class="w-4 h-4 text-blue-600 focus:ring-blue-500" :value="index + 1" x-model="selected">
                            <span class="text-gray-800" x-text="opt"></span>
                        </label>
                    </template>
                </div>

                <button @click="submitAnswer" x-show="!buttonLocked" :disabled="selected.length === 0"
                    class="mt-8 w-full py-3 text-center text-white font-semibold rounded-lg
                           bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed
                           transition-all duration-200">
                    Next Question
                </button>

                <div x-show="finished"
                    class="p-4 mt-4 bg-green-100 border border-green-300 text-green-800 rounded-md text-sm font-semibold">
                    You have successfully answered all therapist onboarding questions.
                    You can review and edit your responses from this page at any time.
                </div>
            </div>
        </div>

        <!-- SUMMARY MODE -->
        <div x-show="mode === 'summary'" x-transition>
            <div class="bg-white shadow-md rounded-xl border border-gray-200 mx-3 p-8 ">
                <div class="flex justify-between mb-4">
                    <x-page-header />
                </div>

                <h2 class="text-xl font-semibold text-gray-800 mb-4">
                    Search Match Questions
                </h2>

                <p class="text-sm text-gray-600 mb-4">
                    These answers help JustMy.Health match you with the most suitable patients.
                    You can update any answer at any time using the buttons on the right.
                </p>

                <div class="overflow-x-auto px-3 sm:px-0">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-100 text-xs uppercase text-gray-600">
                            <tr>
                                <th class="px-3 py-2 text-left whitespace-nowrap">#</th>
                                <th class="px-3 py-2 text-left whitespace-nowrap">Question</th>
                                <th class="px-3 py-2 text-left whitespace-nowrap">Response</th>
                                <th class="px-3 py-2 text-left whitespace-nowrap">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(q, idx) in summaryQuestions" :key="q.ID">
                                <tr class="border-t">
                                    <td class="px-3 py-2 align-top" x-text="idx + 1"></td>
                                    <td class="px-3 py-2 align-top">
                                        <div class="font-medium text-gray-800" x-text="q.QuestionHeading"></div>
                                        <div class="text-xs text-gray-500 mt-1" x-text="q.QuestionNotes"></div>
                                    </td>
                                    <td class="px-3 py-2 align-top">
                                        <span x-text="currentAnswerText(idx + 1) || 'Not answered yet'"
                                            :class="currentAnswerText(idx + 1) ? 'text-gray-800' : 'text-gray-400 italic'"></span>
                                    </td>
                                    <td class="px-3 py-2 align-top">
                                        <button type="button"
                                            class="px-4 py-1.5 text-xs font-semibold bg-emerald-600 text-white rounded-full shadow-sm hover:bg-emerald-700 transition-all"
                                            @click="openEditModal(q, idx + 1)">
                                            Update
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- EDIT MODAL -->
        <div x-show="isEditOpen" x-cloak
            class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4"
            @click.self="closeEditModal">
            <div class="bg-white rounded-xl w-full max-w-lg p-6 shadow-xl max-h-[90vh] overflow-y-auto" @click.stop>
                <div class="flex justify-between items-center mb-3">
                    <h2 class="text-lg font-semibold text-gray-800">
                        Update Answer
                    </h2>
                    <button @click="closeEditModal" class="text-gray-500 text-xl">x</button>
                </div>

                <p class="text-sm text-gray-700 font-medium mb-2" x-text="editQuestion.QuestionHeading"></p>
                <p class="text-xs text-gray-500 mb-4" x-text="editQuestion.QuestionNotes"></p>

                <div class="space-y-3">
                    <template x-for="(opt, index) in editOptions()" :key="index">
                        <label
                            class="flex items-center gap-3 cursor-pointer bg-gray-50 hover:bg-gray-100 px-4 py-3 rounded-lg border border-gray-200">
                            <input type="checkbox" class="w-4 h-4 text-blue-600 focus:ring-blue-500"
                                :value="index + 1" x-model="editSelected">

                            <span class="text-gray-800" x-text="opt"></span>
                        </label>
                    </template>
                </div>

                <div class="flex justify-end gap-2 pt-4">
                    <button type="button" @click="closeEditModal"
                        class="px-4 py-2 bg-gray-200 rounded-lg text-sm hover:bg-gray-300">
                        Cancel
                    </button>
                    <button type="button" @click="submitEdit"
                        class="px-4 py-2 bg-teal-600 text-white rounded-lg text-sm hover:bg-teal-700"
                        :disabled="editSelected.length === 0">
                        Save
                    </button>
                </div>
            </div>
        </div>

    </div>

    <script>
        function therapistMatchQuestions(config) {
            config = config || {};
            return {
                mode: config.mode || 'wizard',
                totalQuestions: config.totalQuestions || 0,
                finished: false,
                buttonLocked: false,

                // Wizard state
                currentQuestion: config.question || {},
                questionNumber: config.nextQuestion || 1,
                selected: [],

                // Summary state
                summaryQuestions: config.questions || [],
                answersRow: config.answers || null,

                // Edit modal
                isEditOpen: false,
                editQuestion: {},
                editQuestionNumber: null,
                editSelected: [],

                options() {
                    let arr = [];
                    if (!this.currentQuestion) return arr;
                    for (let i = 1; i <= 24; i++) {
                        let v = this.currentQuestion["Option" + i];
                        if (v) arr.push(v);
                    }
                    return arr;
                },

                submitAnswer() {
                    if (!this.currentQuestion || this.selected.length === 0) return;

                    this.buttonLocked = true;

                    let selectedTexts = this.selected.map(i => this.options()[i - 1]);
                    let selectedOptionNumbers = this.selected.map(i => Number(i));

                    fetch("{{ route('therapist.match.questions.save') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                question_id: this.questionNumber,
                                answer_text: selectedTexts,
                                answer_option_number: selectedOptionNumbers
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.completed) {
                                this.finished = true;
                                // after completion reload page into summary mode
                                window.location.reload();
                                return;
                            }

                            this.currentQuestion = data.next_question;
                            this.questionNumber = data.next_question_number;
                            this.totalQuestions = data.total_questions || this.totalQuestions;
                            this.selected = [];
                            this.buttonLocked = false;
                        })
                        .catch(() => {
                            this.buttonLocked = false;
                        });
                },

                currentAnswerText(id) {
                    return this.currentAnswerArray(id).join(', ');
                },

                currentAnswerArray(id) {
                    if (!this.answersRow) return [];
                    const col = `Id${id}_Answer_text`;
                    try {
                        const parsed = JSON.parse(this.answersRow[col] || '[]') || [];
                        return Array.isArray(parsed) ? parsed : (parsed ? [String(parsed)] : []);
                    } catch (e) {
                        return [];
                    }
                },

                openEditModal(question, questionNumber) {
                    this.editQuestion = question;
                    this.editQuestionNumber = questionNumber;
                    const opts = this.editOptions();
                    const selectedTexts = this.currentAnswerArray(questionNumber);
                    this.editSelected = selectedTexts
                        .map(text => {
                            const idx = opts.indexOf(text);
                            return idx >= 0 ? String(idx + 1) : null;
                        })
                        .filter(v => v !== null);
                    this.isEditOpen = true;
                },

                closeEditModal() {
                    this.isEditOpen = false;
                    this.editQuestionNumber = null;
                },

                editOptions() {
                    let arr = [];
                    if (!this.editQuestion) return arr;
                    for (let i = 1; i <= 24; i++) {
                        let v = this.editQuestion["Option" + i];
                        if (v) arr.push(v);
                    }
                    return arr;
                },

                submitEdit() {
                    if (!this.editQuestion || this.editSelected.length === 0) return;

                    const opts = this.editOptions();
                    const selectedTexts = this.editSelected.map(i => opts[i - 1]);
                    const selectedOptionNumbers = this.editSelected.map(i => Number(i));

                    fetch("{{ route('therapist.match.questions.update') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                question_id: this.editQuestionNumber,
                                answer_text: selectedTexts,
                                answer_option_number: selectedOptionNumbers
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data && data.success) {
                                if (this.answersRow) {
                                    const textCol = `Id${this.editQuestionNumber}_Answer_text`;
                                    const optCol = `Id${this.editQuestionNumber}_AnswerOptionNumber`;
                                    this.answersRow[textCol] = JSON.stringify(selectedTexts);
                                    this.answersRow[optCol] = JSON.stringify(selectedOptionNumbers);
                                }
                                this.closeEditModal();
                            }
                        });
                }
            }
        }
    </script>

</x-app1>