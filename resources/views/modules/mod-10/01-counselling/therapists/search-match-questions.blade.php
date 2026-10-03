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

    <div x-data='therapistMatchQuestions(@json($matchConfig))' class="max-w-6xl mx-auto space-y-6">

        <!-- Page Header -->
        <x-page-header />

        <!-- ========================================== -->
        <!-- WIZARD MODE (Step-by-Step Questionnaire)   -->
        <!-- ========================================== -->
        <div x-show="mode === 'wizard'" 
             x-transition:enter="transition ease-out duration-300" 
             x-transition:enter-start="opacity-0 translate-y-2" 
             x-transition:enter-end="opacity-100 translate-y-0"
             class="max-w-2xl mx-auto">

            <div class="relative bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl shadow-[0_4px_25px_-5px_rgba(0,0,0,0.06)] dark:shadow-none border border-gray-100 dark:border-gray-700/80 p-5 sm:p-8 md:p-9 overflow-hidden" 
                 x-show="!finished" 
                 x-transition>

                <!-- Top Brand Color Strip -->
                <div class="absolute top-0 left-0 right-0 h-1" style="background: linear-gradient(90deg, #1C9BA0, #127F94);"></div>

                <!-- Step Counter & Progress -->
                <div class="mb-6 pt-1">
                    <div class="flex items-center justify-between text-xs sm:text-sm font-semibold mb-2">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#1C9BA0]/10 text-[#1C9BA0] dark:text-[#38b2ac]">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                            <template x-if="questionNumber < totalQuestions">
                                <span>Question <span x-text="questionNumber"></span> of <span x-text="totalQuestions"></span></span>
                            </template>
                            <template x-if="questionNumber >= totalQuestions">
                                <span>Final Question (<span x-text="totalQuestions"></span> of <span x-text="totalQuestions"></span>)</span>
                            </template>
                        </span>

                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400" 
                              x-text="totalQuestions > 0 ? Math.round(((questionNumber) / totalQuestions) * 100) + '% completed' : '0%'">
                        </span>
                    </div>

                    <!-- Progress Bar Track -->
                    <div class="w-full h-1.5 bg-gray-100 dark:bg-gray-700/80 rounded-full overflow-hidden">
                        <div class="h-full rounded-full transition-all duration-500 ease-out"
                             style="background: linear-gradient(90deg, #1C9BA0, #127F94);"
                             :style="'width: ' + (totalQuestions > 0 ? (((questionNumber) / totalQuestions) * 100) : 0) + '%'"></div>
                    </div>
                </div>

                <!-- Question Heading & Subtitle -->
                <div class="mb-6">
                    <h3 class="text-lg sm:text-2xl font-bold text-gray-900 dark:text-gray-100 tracking-tight leading-snug" 
                        x-text="currentQuestion.QuestionHeading">
                    </h3>

                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-2 leading-relaxed" 
                       x-show="currentQuestion.QuestionNotes"
                       x-text="currentQuestion.QuestionNotes">
                    </p>
                </div>

                <!-- Multiple Choice Options (Checkboxes for Multi-Select) -->
                <div class="space-y-2.5">
                    <template x-for="(opt, index) in options()" :key="index">
                        <label class="group flex items-center justify-between p-3.5 sm:p-4 rounded-xl sm:rounded-2xl border transition-all duration-200 cursor-pointer select-none"
                               :class="selected.includes(index + 1) 
                                   ? 'border-[#1C9BA0] bg-[#1C9BA0]/5 dark:bg-[#1C9BA0]/15 ring-2 ring-[#1C9BA0]/25 shadow-xs' 
                                   : 'border-gray-200 dark:border-gray-700/80 bg-gray-50/50 dark:bg-gray-800/80 hover:bg-gray-100/70 dark:hover:bg-gray-700/50 hover:border-gray-300 dark:hover:border-gray-600'">
                            <div class="flex items-center gap-3.5 min-w-0 pr-2">
                                <div class="w-5 h-5 rounded-lg border flex items-center justify-center shrink-0 transition-colors"
                                     :class="selected.includes(index + 1) ? 'border-[#1C9BA0] bg-[#1C9BA0]' : 'border-gray-300 dark:border-gray-600 group-hover:border-[#1C9BA0]'">
                                    <svg class="w-3.5 h-3.5 text-white transition-transform"
                                         :class="selected.includes(index + 1) ? 'scale-100' : 'scale-0'"
                                         fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <span class="text-xs sm:text-sm font-medium transition-colors"
                                      :class="selected.includes(index + 1) ? 'text-[#1C9BA0] dark:text-[#38b2ac] font-semibold' : 'text-gray-800 dark:text-gray-200'"
                                      x-text="opt"></span>
                            </div>
                            <input type="checkbox" class="sr-only" :value="index + 1" x-model="selected">
                        </label>
                    </template>
                </div>

                <!-- Submit / Next Button -->
                <div class="mt-6 pt-4 border-t border-gray-100 dark:border-gray-700/60">
                    <button @click="submitAnswer" x-show="!buttonLocked"
                        :disabled="selected.length === 0"
                        type="button"
                        class="w-full py-3 px-6 text-center text-white font-semibold text-xs sm:text-sm tracking-wide rounded-full shadow-xs hover:shadow-md transition-all duration-200 active:scale-[0.99] cursor-pointer disabled:opacity-40 disabled:cursor-not-allowed disabled:shadow-none hover:opacity-95"
                        style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                        <span class="inline-flex items-center justify-center gap-1.5">
                            <span x-text="questionNumber >= totalQuestions ? 'Finish & Save Answers' : 'Next Question'"></span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </span>
                    </button>
                </div>

            </div>

            <!-- Finished Banner -->
            <div x-show="finished" x-cloak
                class="p-6 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 text-emerald-800 dark:text-emerald-200 rounded-3xl text-sm font-semibold shadow-xs text-center space-y-2">
                <div class="w-12 h-12 rounded-2xl bg-emerald-100 dark:bg-emerald-900/60 flex items-center justify-center mx-auto text-emerald-600 dark:text-emerald-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h4 class="text-base font-bold">All Questions Completed!</h4>
                <p class="text-xs text-emerald-700 dark:text-emerald-300 font-normal">
                    You have successfully answered all therapist onboarding questions. You can review and update your responses at any time.
                </p>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- SUMMARY MODE (Card Grid Layout)            -->
        <!-- ========================================== -->
        <div x-show="mode === 'summary'" 
             x-transition:enter="transition ease-out duration-300" 
             x-transition:enter-start="opacity-0 translate-y-2" 
             x-transition:enter-end="opacity-100 translate-y-0"
             class="space-y-5">
            
            <!-- Controls Bar: Search & Status -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 bg-white dark:bg-gray-800 p-3.5 sm:p-4 rounded-2xl border border-gray-100 dark:border-gray-700/80 shadow-2xs">
                
                <!-- Live Search -->
                <div class="relative flex-1 max-w-md">
                    <input type="text"
                           x-model="search"
                           placeholder="Search questions or your responses..."
                           class="w-full pl-9 pr-4 py-2 text-xs sm:text-sm bg-gray-50/80 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-full text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:border-[#1C9BA0] focus:ring-1 focus:ring-[#1C9BA0]" />
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <button x-show="search.length > 0" 
                            @click="search = ''"
                            class="absolute right-3 top-2.5 text-xs text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 cursor-pointer">
                        ✕
                    </button>
                </div>

                <!-- Completion Status Pill -->
                <div class="flex items-center gap-2 self-start sm:self-auto shrink-0">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300 border border-emerald-200/60 dark:border-emerald-800/40">
                        <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span><span x-text="totalQuestions"></span> of <span x-text="totalQuestions"></span> Answered</span>
                    </span>
                </div>
            </div>

            <!-- Responsive Card Grid (2 columns on md+, 1 on mobile) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <template x-for="(q, idx) in filteredQuestions()" :key="q.ID">
                    <div class="relative overflow-hidden bg-white dark:bg-gray-800 rounded-2xl p-4 sm:p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-[0_12px_24px_-4px_rgba(0,0,0,0.08)] dark:shadow-none transition-all duration-200 hover:-translate-y-0.5 group flex flex-col justify-between">
                        
                        <!-- Left Accent Line on card hover -->
                        <div class="absolute left-0 top-0 bottom-0 w-1 rounded-l-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                             style="background: linear-gradient(180deg, #1C9BA0, #127F94);"></div>

                        <div>
                            <!-- Card Header: Question Number Badge + Update Button -->
                            <div class="flex items-center justify-between gap-2 mb-2">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-bold bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400">
                                    Q<span x-text="idx + 1"></span>
                                </span>

                                <button type="button"
                                    @click="openEditModal(q, idx + 1)"
                                    class="inline-flex items-center gap-1 px-3 py-1 rounded-full border border-gray-200 dark:border-gray-700 hover:border-[#1C9BA0] text-gray-600 dark:text-gray-300 hover:text-[#1C9BA0] text-xs font-semibold transition-all cursor-pointer">
                                    <svg class="w-3 h-3 text-[#1C9BA0]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                    </svg>
                                    <span>Update</span>
                                </button>
                            </div>

                            <!-- Question Heading -->
                            <h4 class="font-bold text-sm sm:text-base text-gray-900 dark:text-gray-100 leading-snug group-hover:text-[#1C9BA0] transition-colors"
                                x-text="q.QuestionHeading"></h4>

                            <p class="text-xs text-gray-400 dark:text-gray-400 mt-1 leading-relaxed line-clamp-2"
                               x-show="q.QuestionNotes"
                               x-text="q.QuestionNotes"></p>
                        </div>

                        <!-- Card Footer: Answer Pills -->
                        <div class="mt-4 pt-3 border-t border-gray-100 dark:border-gray-700/60 space-y-1.5">
                            <span class="text-xs text-gray-400 dark:text-gray-400 block">Response:</span>
                            
                            <div class="flex items-center gap-1.5 flex-wrap">
                                <template x-for="(ans, aIdx) in currentAnswerArray(idx + 1)" :key="aIdx">
                                    <span class="inline-flex items-center gap-1 text-xs font-semibold px-2.5 py-1 rounded-lg bg-[#1C9BA0]/10 text-[#1C9BA0] dark:text-[#38b2ac]">
                                        <svg class="w-3 h-3 text-[#1C9BA0] shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        <span x-text="ans"></span>
                                    </span>
                                </template>

                                <template x-if="currentAnswerArray(idx + 1).length === 0">
                                    <span class="text-xs text-gray-400 italic">Not answered yet</span>
                                </template>
                            </div>
                        </div>

                    </div>
                </template>

                <!-- Empty Search Results -->
                <div x-show="filteredQuestions().length === 0" class="col-span-full py-16 text-center bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700/80">
                    <p class="text-sm text-gray-400 dark:text-gray-400">No questions or responses match your search query.</p>
                </div>
            </div>

        </div>

        <!-- ========================================== -->
        <!-- EDIT MODAL (Centered / Backdrop Blur)      -->
        <!-- ========================================== -->
        <div x-show="isEditOpen" 
             x-cloak
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center z-50 p-2.5 sm:p-4"
             @click.self="closeEditModal"
             @keydown.escape.window="closeEditModal"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             style="display: none;">

            <div class="relative w-full max-w-xl bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl shadow-2xl border border-gray-100 dark:border-gray-700/80 overflow-hidden flex flex-col max-h-[92vh] sm:max-h-[90vh] my-auto" 
                 @click.stop
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95">

                <!-- Modal Header -->
                <div class="px-5 py-4 sm:px-6 sm:py-5 border-b border-gray-100 dark:border-gray-700/80 flex items-center justify-between shrink-0">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                             style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <div>
                            <span class="text-[11px] font-bold uppercase tracking-wider text-[#1C9BA0]">Question <span x-text="editQuestionNumber"></span></span>
                            <h3 class="text-base sm:text-lg font-bold text-gray-900 dark:text-gray-100 leading-snug">Update Answer</h3>
                        </div>
                    </div>

                    <button @click="closeEditModal" 
                            type="button" 
                            class="p-2 rounded-xl text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-5 sm:p-6 overflow-y-auto flex-1 space-y-4">
                    <div>
                        <h4 class="font-bold text-sm sm:text-base text-gray-900 dark:text-gray-100" x-text="editQuestion.QuestionHeading"></h4>
                        <p class="text-xs text-gray-400 mt-1 leading-relaxed" x-show="editQuestion.QuestionNotes" x-text="editQuestion.QuestionNotes"></p>
                    </div>

                    <!-- Options list -->
                    <div class="space-y-2 pt-2">
                        <template x-for="(opt, index) in editOptions()" :key="index">
                            <label class="group flex items-center justify-between p-3 sm:p-3.5 rounded-xl border transition-all duration-200 cursor-pointer select-none"
                                   :class="editSelected.includes(String(index + 1)) 
                                       ? 'border-[#1C9BA0] bg-[#1C9BA0]/5 dark:bg-[#1C9BA0]/15 ring-2 ring-[#1C9BA0]/25 shadow-xs' 
                                       : 'border-gray-200 dark:border-gray-700/80 bg-gray-50/50 dark:bg-gray-800/80 hover:bg-gray-100/70 dark:hover:bg-gray-700/50 hover:border-gray-300 dark:hover:border-gray-600'">
                                <div class="flex items-center gap-3 min-w-0 pr-2">
                                    <div class="w-5 h-5 rounded-lg border flex items-center justify-center shrink-0 transition-colors"
                                         :class="editSelected.includes(String(index + 1)) ? 'border-[#1C9BA0] bg-[#1C9BA0]' : 'border-gray-300 dark:border-gray-600 group-hover:border-[#1C9BA0]'">
                                        <svg class="w-3.5 h-3.5 text-white transition-transform"
                                             :class="editSelected.includes(String(index + 1)) ? 'scale-100' : 'scale-0'"
                                             fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    <span class="text-xs sm:text-sm font-medium transition-colors"
                                          :class="editSelected.includes(String(index + 1)) ? 'text-[#1C9BA0] dark:text-[#38b2ac] font-semibold' : 'text-gray-800 dark:text-gray-200'"
                                          x-text="opt"></span>
                                </div>
                                <input type="checkbox" class="sr-only" :value="String(index + 1)" x-model="editSelected">
                            </label>
                        </template>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="px-5 py-4 sm:px-6 sm:py-4 border-t border-gray-100 dark:border-gray-700/80 flex items-center justify-end gap-2.5 bg-gray-50/50 dark:bg-gray-900/30 shrink-0">
                    <button type="button" @click="closeEditModal"
                        class="px-4 py-2 rounded-full border border-gray-200 dark:border-gray-700 text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all cursor-pointer">
                        Cancel
                    </button>
                    <button type="button" @click="submitEdit"
                        :disabled="editSelected.length === 0"
                        class="inline-flex items-center gap-1.5 px-5 py-2 rounded-full text-white text-xs sm:text-sm font-semibold shadow-xs hover:shadow transition-all cursor-pointer hover:opacity-95 disabled:opacity-40 disabled:cursor-not-allowed"
                        style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                        <span>Save Changes</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
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
                search: '',

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

                filteredQuestions() {
                    if (!this.search || !this.search.trim()) {
                        return this.summaryQuestions;
                    }
                    const q = this.search.toLowerCase().trim();
                    return this.summaryQuestions.filter((item, idx) => {
                        const heading = (item.QuestionHeading || '').toLowerCase();
                        const notes = (item.QuestionNotes || '').toLowerCase();
                        const answers = this.currentAnswerText(idx + 1).toLowerCase();
                        return heading.includes(q) || notes.includes(q) || answers.includes(q);
                    });
                },

                submitAnswer() {
                    if (!this.currentQuestion || this.selected.length === 0) return;

                    this.buttonLocked = true;

                    let opts = this.options();
                    let selectedTexts = this.selected.map(i => opts[i - 1]);
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
                        const val = this.answersRow[col];
                        if (!val) return [];
                        const parsed = JSON.parse(val);
                        return Array.isArray(parsed) ? parsed : (parsed ? [String(parsed)] : []);
                    } catch (e) {
                        return this.answersRow[col] ? [this.answersRow[col]] : [];
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
                    const selectedTexts = this.editSelected.map(i => opts[Number(i) - 1]);
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