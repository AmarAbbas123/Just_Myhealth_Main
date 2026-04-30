<x-app1>

    <div x-data="onboarding({{ $nextQuestion }})" class="max-w-3xl mx-auto py-10 px-4">

        <div class="bg-white shadow-md rounded-xl p-8 border border-gray-200" x-show="!finished" x-transition>

            <!-- Header -->
            <div class="flex justify-between mb-4">
                <x-page-header />
            </div>

            <!-- Question Number -->
            <div class="text-lg font-bold text-gray-900 mb-2">
                <template x-if="questionNumber <= 39">
                    <span>Question <span x-text="questionNumber"></span> of 39</span>
                </template>
                <template x-if="questionNumber === 40">
                    <span>Step 40 of 40</span>
                </template>
            </div>

            <!-- QUESTION HEADING -->
            <h3 class="text-xl font-semibold text-gray-800 mb-2" x-text="question.QuestionHeading">
            </h3>

            <!-- QUESTION NOTES -->
            <p class="text-sm text-gray-500 mb-6 leading-relaxed" x-text="question.QuestionNotes">
            </p>

            <!-- OPTIONS (Questions 1-39) -->
            <div class="space-y-3" x-show="!isTextQuestion()">
                <template x-for="(opt, index) in options()" :key="index">
                    <label class="flex items-center gap-3 cursor-pointer bg-gray-50 hover:bg-gray-100 px-4 py-3 rounded-lg border border-gray-200">
                        <input type="radio" class="w-4 h-4 text-blue-600 focus:ring-blue-500" name="option"
                               :value="index + 1" x-model="selected">
                        <span class="text-gray-800" x-text="opt"></span>
                    </label>
                </template>
            </div>

            <!-- TEXT INPUT (Question 40 - Summary of Issue) -->
            <div x-show="isTextQuestion()" class="mt-2">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Summary of Issue
                </label>
                <textarea
                    x-model="freeText"
                    maxlength="2028"
                    rows="6"
                    class="w-full rounded-lg border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 text-gray-800"
                    placeholder="Please describe the issue you are seeking help for..."></textarea>
                <div class="mt-2 flex items-center justify-between text-xs text-gray-500">
                    <span>This helps your therapist plan your sessions.</span>
                    <span x-text="(freeText?.length || 0) + ' / 2028'"></span>
                </div>
            </div>

            <!-- BUTTON -->
            <button
                @click="submitAnswer"
                x-show="!buttonLocked"
                :disabled="isTextQuestion() ? !(freeText && freeText.trim().length > 0) : !selected"
                class="mt-8 w-full py-3 text-center text-white font-semibold rounded-lg
                       bg-blue-600 hover:bg-blue-700 disabled:bg-gray-400 disabled:cursor-not-allowed
                       transition-all duration-200">
                <span x-text="isTextQuestion() ? 'Finish' : 'Next Question'"></span>
            </button>

            <!-- Completed Message -->
            <div x-show="questionNumber > 39"
                class="p-4 mt-4 mb-4 bg-green-100 border border-green-300 text-green-800 rounded-md text-sm font-semibold">
                You have successfully answered all onboarding questions.
                Please proceed to find your perfect therapist.

                <a href="{{ route('therapists.index') }}"
                    class="inline-block text-lg font-semibold  text-blue-700 bg-clip-text transition-all duration-300 hover:text-blue-500 hover:underline">
                    Find Your Best Therapist
                </a>
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
        function onboarding(questionNumber) {
            return {
                question: @json($question),
                questionNumber: questionNumber,
                selected: null,
                freeText: '',
                finished: false,
                buttonLocked: false,

                isTextQuestion() {
                    const dt = (this.question?.QuestionDisplayType || '').toString().toLowerCase();
                    return this.questionNumber === 40 || dt.includes('text') || dt.includes('textarea') || dt.includes('input');
                },

                options() {
                    let arr = [];
                    for (let i = 1; i <= 12; i++) {
                        let v = this.question["Option" + i];
                        if (v) arr.push(v);
                    }
                    return arr;
                },

                submitAnswer() {
                    if (this.isTextQuestion()) {
                        if (!this.freeText || !this.freeText.trim()) return;
                    } else {
                        if (!this.selected) return;
                    }

                    this.buttonLocked = true;

                    let answerText = this.isTextQuestion()
                        ? this.freeText.trim()
                        : this.options()[this.selected - 1];

                    fetch("{{ route('onboarding.save') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                question_id: this.questionNumber,
                                answer_text: answerText,
                                answer_option_number: this.isTextQuestion() ? 0 : this.selected
                            })
                        })
                        .then(res => res.json())
                        .then(data => {

                            if (data.completed) {
                                this.finished = true;
                                return;
                            }

                            this.question = data.next_question;
                            this.questionNumber = data.next_question_number;
                            this.selected = null;
                            this.freeText = '';
                            this.buttonLocked = false;
                        });
                }
            }
        }
    </script>

</x-app1>
