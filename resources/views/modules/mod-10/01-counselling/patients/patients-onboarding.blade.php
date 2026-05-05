<x-app1>

    @php
        $onboardingConfig = [
            'mode' => $mode,
            'totalQuestions' => $totalQuestions,
            'question' => $question ?? null,
            'nextQuestion' => $nextQuestion ?? null,
            'questions' => $questions ?? [],
            'answers' => $answers ?? null,
        ];
    @endphp

    <div x-data='onboarding(@json($onboardingConfig))' class="max-w-4xl mx-auto py-10 px-4">

        <!-- WIZARD MODE -->
        <div x-show="mode === 'wizard'" x-transition>
            <div class="bg-white shadow-md rounded-xl p-8 border border-gray-200" x-show="!finished" x-transition>

                <div class="flex justify-between mb-4">
                    <x-page-header />
                </div>

                <div class="text-lg font-bold text-gray-900 mb-2">
                    <template x-if="questionNumber <= 39">
                        <span>Question <span x-text="questionNumber"></span> of <span x-text="totalQuestions"></span></span>
                    </template>
                    <template x-if="questionNumber === 40">
                        <span>Step 40 of 40</span>
                    </template>
                </div>

                <h3 class="text-xl font-semibold text-gray-800 mb-2" x-text="question.QuestionHeading">
                </h3>

                <p class="text-sm text-gray-500 mb-6 leading-relaxed" x-text="question.QuestionNotes">
                </p>

                <div class="space-y-3" x-show="!isTextQuestion(question, questionNumber)">
                    <template x-for="(opt, index) in options(question)" :key="index">
                        <label class="flex items-center gap-3 cursor-pointer bg-gray-50 hover:bg-gray-100 px-4 py-3 rounded-lg border border-gray-200">
                            <input type="radio" class="w-4 h-4 text-blue-600 focus:ring-blue-500" name="option"
                                :value="index + 1" x-model="selected">
                            <span class="text-gray-800" x-text="opt"></span>
                        </label>
                    </template>
                </div>

                <div x-show="isTextQuestion(question, questionNumber)" class="mt-2">
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        Summary of Issue
                    </label>
                    <textarea x-model="freeText" maxlength="2028" rows="6"
                        class="w-full rounded-lg border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 text-gray-800"
                        placeholder="Please describe the issue you are seeking help for..."></textarea>
                    <div class="mt-2 flex items-center justify-between text-xs text-gray-500">
                        <span>This helps your therapist plan your sessions.</span>
                        <span x-text="(freeText?.length || 0) + ' / 2028'"></span>
                    </div>
                </div>

                <button @click="submitAnswer" x-show="!buttonLocked"
                    :disabled="isTextQuestion(question, questionNumber) ? !(freeText && freeText.trim().length > 0) : !selected"
                    class="mt-8 w-full py-3 text-center text-white font-semibold rounded-lg
                       bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed
                       transition-all duration-200">
                    <span x-text="isTextQuestion(question, questionNumber) ? 'Finish' : 'Next Question'"></span>
                </button>

                <div x-show="questionNumber > 39"
                    class="p-4 mt-4 mb-4 bg-green-100 border border-green-300 text-green-800 rounded-md text-sm font-semibold">
                    You have successfully answered all onboarding questions.
                    Please proceed to find your perfect therapist.

                    <a href="{{ route('therapists.index') }}"
                        class="inline-block text-lg font-semibold text-blue-700 bg-clip-text transition-all duration-300 hover:text-blue-500 hover:underline">
                        Find Your Best Therapist
                    </a>
                </div>
            </div>
        </div>

        <!-- SUMMARY MODE -->
        <div x-show="mode === 'summary'" x-transition>
            <div class="bg-white shadow-md rounded-xl border border-gray-200 mx-3 p-8">
                <div class="flex justify-between mb-4">
                    <x-page-header />
                </div>

                <h2 class="text-xl font-semibold text-gray-800 mb-4">
                    How I Feel Questions
                </h2>

                <p class="text-sm text-gray-600 mb-4">
                    These answers help JustMy.Health understand what you need and match you with the most suitable therapist.
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
                                        <span x-text="currentAnswerText(q.ID) || 'Not answered yet'"
                                            :class="currentAnswerText(q.ID) ? 'text-gray-800' : 'text-gray-400 italic'"></span>
                                    </td>
                                    <td class="px-3 py-2 align-top">
                                        <button type="button"
                                            class="px-4 py-1.5 text-xs font-semibold bg-emerald-600 text-white rounded-full shadow-sm hover:bg-emerald-700 transition-all"
                                            @click="openEditModal(q)">
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

                <div class="space-y-3" x-show="!isTextQuestion(editQuestion, editQuestionNumber)">
                    <template x-for="(opt, index) in editOptions()" :key="index">
                        <label class="flex items-center gap-3 cursor-pointer bg-gray-50 hover:bg-gray-100 px-4 py-3 rounded-lg border border-gray-200">
                            <input type="radio" class="w-4 h-4 text-blue-600 focus:ring-blue-500"
                                name="edit_option" :value="index + 1" x-model="editSelected">

                            <span class="text-gray-800" x-text="opt"></span>
                        </label>
                    </template>
                </div>

                <div x-show="isTextQuestion(editQuestion, editQuestionNumber)">
                    <textarea x-model="editFreeText" maxlength="2028" rows="6"
                        class="w-full rounded-lg border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 text-gray-800"></textarea>
                    <div class="mt-2 text-right text-xs text-gray-500" x-text="(editFreeText?.length || 0) + ' / 2028'"></div>
                </div>

                <div class="flex justify-end gap-2 pt-4">
                    <button type="button" @click="closeEditModal"
                        class="px-4 py-2 bg-gray-200 rounded-lg text-sm hover:bg-gray-300">
                        Cancel
                    </button>
                    <button type="button" @click="submitEdit"
                        class="px-4 py-2 bg-teal-600 text-white rounded-lg text-sm hover:bg-teal-700"
                        :disabled="isTextQuestion(editQuestion, editQuestionNumber) ? !(editFreeText && editFreeText.trim().length > 0) : !editSelected">
                        Save
                    </button>
                </div>
            </div>
        </div>

        <!-- COMPLETION SCREEN -->
        <div x-show="finished" x-transition
            class="bg-white shadow-md rounded-xl p-10 border border-gray-200 text-center">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">
                All Questions Completed!
            </h2>

            <p class="text-gray-700 text-lg leading-relaxed mb-8">
                You have successfully answered all onboarding questions.
                You may now proceed to find your perfect therapist.
            </p>

            <a href="{{ route('therapists.index') }}"
                class="inline-block px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-all">
                Find Your Best Therapist
            </a>
        </div>

    </div>

    <script>
        function onboarding(config) {
            config = config || {};
            return {
                mode: config.mode || 'wizard',
                totalQuestions: config.totalQuestions || 40,
                question: config.question || {},
                questionNumber: config.nextQuestion || 1,
                selected: null,
                freeText: '',
                finished: false,
                buttonLocked: false,

                summaryQuestions: config.questions || [],
                answersRow: config.answers || null,

                isEditOpen: false,
                editQuestion: {},
                editQuestionNumber: null,
                editSelected: null,
                editFreeText: '',

                isTextQuestion(question, questionNumber) {
                    const dt = (question?.QuestionDisplayType || '').toString().toLowerCase();
                    return Number(questionNumber) === 40 || dt.includes('text') || dt.includes('textarea') || dt.includes('input');
                },

                options(question) {
                    let arr = [];
                    if (!question) return arr;
                    for (let i = 1; i <= 12; i++) {
                        let v = question["Option" + i];
                        if (v) arr.push(v);
                    }
                    return arr;
                },

                submitAnswer() {
                    if (this.isTextQuestion(this.question, this.questionNumber)) {
                        if (!this.freeText || !this.freeText.trim()) return;
                    } else {
                        if (!this.selected) return;
                    }

                    this.buttonLocked = true;

                    let answerText = this.isTextQuestion(this.question, this.questionNumber)
                        ? this.freeText.trim()
                        : this.options(this.question)[this.selected - 1];

                    fetch("{{ route('onboarding.save') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                question_id: this.questionNumber,
                                answer_text: answerText,
                                answer_option_number: this.isTextQuestion(this.question, this.questionNumber) ? 0 : this.selected
                            })
                        })
                        .then(res => res.json())
                        .then(data => {

                            if (data.completed) {
                                this.finished = true;
                                window.location.reload();
                                return;
                            }

                            this.question = data.next_question;
                            this.questionNumber = data.next_question_number;
                            this.selected = null;
                            this.freeText = '';
                            this.buttonLocked = false;
                        })
                        .catch(() => {
                            this.buttonLocked = false;
                        });
                },

                currentAnswerText(id) {
                    if (!this.answersRow) return '';
                    return this.answersRow[`Id${id}_Answer_text`] || '';
                },

                currentAnswerOptionNumber(id) {
                    if (!this.answersRow) return null;
                    const value = this.answersRow[`Id${id}_AnswerOptionNumber`];
                    return value === null || value === undefined ? null : String(value);
                },

                openEditModal(question) {
                    this.editQuestion = question;
                    this.editQuestionNumber = question.ID;
                    this.editFreeText = this.currentAnswerText(question.ID);
                    this.editSelected = this.currentAnswerOptionNumber(question.ID);
                    this.isEditOpen = true;
                },

                closeEditModal() {
                    this.isEditOpen = false;
                    this.editQuestionNumber = null;
                    this.editSelected = null;
                    this.editFreeText = '';
                },

                editOptions() {
                    return this.options(this.editQuestion);
                },

                submitEdit() {
                    if (!this.editQuestion) return;

                    const isText = this.isTextQuestion(this.editQuestion, this.editQuestionNumber);
                    if (isText && (!this.editFreeText || !this.editFreeText.trim())) return;
                    if (!isText && !this.editSelected) return;

                    const answerText = isText
                        ? this.editFreeText.trim()
                        : this.editOptions()[this.editSelected - 1];
                    const answerOptionNumber = isText ? 0 : Number(this.editSelected);

                    fetch("{{ route('onboarding.update') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                question_id: this.editQuestionNumber,
                                answer_text: answerText,
                                answer_option_number: answerOptionNumber
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data && data.success) {
                                if (this.answersRow) {
                                    this.answersRow[`Id${this.editQuestionNumber}_Answer_text`] = answerText;
                                    this.answersRow[`Id${this.editQuestionNumber}_AnswerOptionNumber`] = answerOptionNumber;
                                }
                                this.closeEditModal();
                            }
                        });
                }
            }
        }
    </script>

</x-app1>
