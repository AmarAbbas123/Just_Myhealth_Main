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

    <div x-data='onboarding(@json($onboardingConfig))' class="max-w-6xl mx-auto space-y-6">

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
                            <template x-if="questionNumber <= 39">
                                <span>Question <span x-text="questionNumber"></span> of <span x-text="totalQuestions"></span></span>
                            </template>
                            <template x-if="questionNumber >= 40">
                                <span>Final Question (40 of 40)</span>
                            </template>
                        </span>

                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400" 
                              x-text="Math.round(((questionNumber) / totalQuestions) * 100) + '% completed'">
                        </span>
                    </div>

                    <!-- Progress Bar Track -->
                    <div class="w-full h-1.5 bg-gray-100 dark:bg-gray-700/80 rounded-full overflow-hidden">
                        <div class="h-full rounded-full transition-all duration-500 ease-out"
                             style="background: linear-gradient(90deg, #1C9BA0, #127F94);"
                             :style="'width: ' + (((questionNumber) / totalQuestions) * 100) + '%'"></div>
                    </div>
                </div>

                <!-- Question Heading & Subtitle -->
                <div class="mb-6">
                    <h3 class="text-lg sm:text-2xl font-bold text-gray-900 dark:text-gray-100 tracking-tight leading-snug" 
                        x-text="question.QuestionHeading">
                    </h3>

                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-2 leading-relaxed" 
                       x-show="question.QuestionNotes"
                       x-text="question.QuestionNotes">
                    </p>
                </div>

                <!-- Multiple Choice Options -->
                <div class="space-y-2.5" x-show="!isTextQuestion(question, questionNumber)">
                    <template x-for="(opt, index) in options(question)" :key="index">
                        <label class="group flex items-center justify-between p-3.5 sm:p-4 rounded-xl sm:rounded-2xl border transition-all duration-200 cursor-pointer select-none"
                               :class="selected == index + 1 
                                   ? 'border-[#1C9BA0] bg-[#1C9BA0]/5 dark:bg-[#1C9BA0]/15 ring-2 ring-[#1C9BA0]/25 shadow-xs' 
                                   : 'border-gray-200 dark:border-gray-700/80 bg-gray-50/50 dark:bg-gray-800/80 hover:bg-gray-100/70 dark:hover:bg-gray-700/50 hover:border-gray-300 dark:hover:border-gray-600'">
                            <div class="flex items-center gap-3.5 min-w-0 pr-2">
                                <div class="w-4 h-4 rounded-full border flex items-center justify-center shrink-0 transition-colors"
                                     :class="selected == index + 1 ? 'border-[#1C9BA0] bg-[#1C9BA0]' : 'border-gray-300 dark:border-gray-600 group-hover:border-[#1C9BA0]'">
                                    <div class="w-1.5 h-1.5 rounded-full bg-white transition-transform"
                                         :class="selected == index + 1 ? 'scale-100' : 'scale-0'"></div>
                                </div>
                                <span class="text-xs sm:text-sm font-medium transition-colors"
                                      :class="selected == index + 1 ? 'text-[#1C9BA0] dark:text-[#38b2ac] font-semibold' : 'text-gray-800 dark:text-gray-200'"
                                      x-text="opt"></span>
                            </div>
                            <input type="radio" class="sr-only" name="option" :value="index + 1" x-model="selected">
                        </label>
                    </template>
                </div>

                <!-- Free Text Question (Question 40) -->
                <div x-show="isTextQuestion(question, questionNumber)" class="space-y-2">
                    <label class="block text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-300">
                        Summary of Issue
                    </label>
                    <textarea x-model="freeText" maxlength="2028" rows="5"
                        class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/60 p-4 text-xs sm:text-sm text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 shadow-2xs leading-relaxed"
                        placeholder="Please describe what you are experiencing or seeking support for..."></textarea>
                    <div class="flex items-center justify-between text-xs text-gray-400 dark:text-gray-500 pt-1">
                        <span>Helps your therapist prepare for your first session.</span>
                        <span class="font-mono" x-text="(freeText?.length || 0) + ' / 2028'"></span>
                    </div>
                </div>

                <!-- Submit / Next Button -->
                <div class="mt-6 pt-4 border-t border-gray-100 dark:border-gray-700/60">
                    <button @click="submitAnswer" x-show="!buttonLocked"
                        :disabled="isTextQuestion(question, questionNumber) ? !(freeText && freeText.trim().length > 0) : !selected"
                        type="button"
                        class="w-full py-3 px-6 text-center text-white font-semibold text-xs sm:text-sm tracking-wide rounded-full shadow-xs hover:shadow-md transition-all duration-200 active:scale-[0.99] cursor-pointer disabled:opacity-40 disabled:cursor-not-allowed disabled:shadow-none hover:opacity-95"
                        style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                        <span class="inline-flex items-center justify-center gap-1.5">
                            <span x-text="isTextQuestion(question, questionNumber) ? 'Finish & Save Answers' : 'Next Question'"></span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </span>
                    </button>
                </div>

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
                           placeholder="Search questions or your answers..."
                           class="w-full pl-9 pr-4 py-2 text-xs sm:text-sm bg-gray-50/80 dark:bg-gray-750 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-full text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:border-[#1C9BA0] focus:ring-1 focus:ring-[#1C9BA0]" />
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
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-300 border border-emerald-200/60 dark:border-emerald-800/40">
                        <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>40 of 40 Answered</span>
                    </span>

                    <a href="{{ route('therapists.index') }}"
                        class="inline-flex items-center gap-1 px-4 py-1.5 rounded-full text-white text-xs font-semibold shadow-xs hover:shadow transition-all cursor-pointer hover:opacity-95"
                        style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                        <span>Find Therapist</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Responsive Card Grid (2 columns on md+, 1 on mobile) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <template x-for="(q, idx) in filteredQuestions()" :key="q.ID">
                    <div class="relative overflow-hidden bg-white dark:bg-gray-800 rounded-2xl p-4 sm:p-5 border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] hover:shadow-[0_12px_24px_-4px_rgba(0,0,0,0.08)] dark:shadow-none transition-all duration-200 hover:-translate-y-0.5 group flex flex-col justify-between">
                        
                        <!-- Left Accent Line on card hover (brand standard) -->
                        <div class="absolute left-0 top-0 bottom-0 w-1 rounded-l-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                             style="background: linear-gradient(180deg, #1C9BA0, #127F94);"></div>

                        <div>
                            <!-- Card Header: Question Number Badge + Edit Button -->
                            <div class="flex items-center justify-between gap-2 mb-2">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-bold bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400">
                                    Q<span x-text="q.ID"></span>
                                </span>

                                <button type="button"
                                    @click="openEditModal(q)"
                                    class="inline-flex items-center gap-1 px-3 py-1 rounded-full border border-gray-200 dark:border-gray-700 hover:border-[#1C9BA0] text-gray-600 dark:text-gray-300 hover:text-[#1C9BA0] text-xs font-semibold transition-all cursor-pointer">
                                    <svg class="w-3 h-3 text-[#1C9BA0]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                    </svg>
                                    Update
                                </button>
                            </div>

                            <!-- Question Heading -->
                            <h4 class="font-bold text-sm sm:text-base text-gray-900 dark:text-gray-100 leading-snug group-hover:text-[#1C9BA0] transition-colors"
                                x-text="q.QuestionHeading"></h4>

                            <p class="text-xs text-gray-400 dark:text-gray-400 mt-1 leading-relaxed line-clamp-2"
                               x-show="q.QuestionNotes"
                               x-text="q.QuestionNotes"></p>
                        </div>

                        <!-- Card Footer: Answer Pill -->
                        <div class="mt-4 pt-3 border-t border-gray-100 dark:border-gray-700/60 flex items-center justify-between gap-2">
                            <span class="text-xs text-gray-400 dark:text-gray-400">Response:</span>
                            <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-lg"
                                  :class="currentAnswerText(q.ID) 
                                      ? 'bg-[#1C9BA0]/10 text-[#1C9BA0] dark:text-[#38b2ac]' 
                                      : 'bg-gray-100 dark:bg-gray-700 text-gray-400 italic'">
                                <svg x-show="currentAnswerText(q.ID)" class="w-3 h-3 text-[#1C9BA0]" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span class="truncate max-w-[200px] sm:max-w-[240px]" x-text="currentAnswerText(q.ID) || 'Not answered'"></span>
                            </span>
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
        <!-- EDIT MODAL (Slide-over / Centered)         -->
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
             x-transition:leave-end="opacity-0">

            <div class="relative w-full max-w-xl bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl shadow-2xl border border-gray-100 dark:border-gray-700/80 overflow-hidden flex flex-col max-h-[92vh] sm:max-h-[90vh] my-auto" 
                 @click.stop
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95">

                <!-- Top Brand Color Strip -->
                <div class="h-1.5 w-full shrink-0" style="background: linear-gradient(90deg, #1C9BA0, #127F94);"></div>

                <!-- Modal Header -->
                <div class="p-4 sm:p-6 bg-slate-50/80 dark:bg-gray-800/90 border-b border-gray-100 dark:border-gray-700/80 flex items-start justify-between gap-3 sm:gap-4 shrink-0">
                    <div class="flex items-center gap-3 sm:gap-3.5 min-w-0">
                        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl flex items-center justify-center text-white shrink-0 shadow-xs"
                             style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <h3 class="text-base sm:text-xl font-bold text-gray-900 dark:text-gray-100 tracking-tight leading-snug">
                                Update Response
                            </h3>
                            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-0.5 truncate" 
                               x-text="editQuestion.QuestionHeading">
                            </p>
                        </div>
                    </div>

                    <!-- Close Button -->
                    <button @click="closeEditModal"
                        class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-white dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-400 hover:text-gray-700 dark:hover:text-white flex items-center justify-center transition shadow-xs cursor-pointer shrink-0"
                        title="Close">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="overflow-y-auto p-4 sm:p-6 space-y-4" style="scrollbar-width: thin; scrollbar-color: #cbd5e1 transparent;">
                    <div>
                        <h4 class="text-sm sm:text-base font-bold text-gray-900 dark:text-gray-100 leading-snug" 
                            x-text="editQuestion.QuestionHeading"></h4>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1 leading-relaxed" 
                           x-show="editQuestion.QuestionNotes"
                           x-text="editQuestion.QuestionNotes"></p>
                    </div>

                    <!-- Radio Options in Modal -->
                    <div class="space-y-2.5 pt-1" x-show="!isTextQuestion(editQuestion, editQuestionNumber)">
                        <template x-for="(opt, index) in editOptions()" :key="index">
                            <label class="group flex items-center justify-between p-3 sm:p-3.5 rounded-xl sm:rounded-2xl border transition-all duration-200 cursor-pointer select-none"
                                   :class="editSelected == index + 1 
                                       ? 'border-[#1C9BA0] bg-[#1C9BA0]/5 dark:bg-[#1C9BA0]/15 ring-2 ring-[#1C9BA0]/30 shadow-xs' 
                                       : 'border-gray-200 dark:border-gray-700/80 bg-gray-50/50 dark:bg-gray-800/80 hover:bg-gray-100/70 dark:hover:bg-gray-700/50'">
                                <div class="flex items-center gap-3 min-w-0 pr-2">
                                    <div class="w-4 h-4 rounded-full border flex items-center justify-center shrink-0 transition-colors"
                                         :class="editSelected == index + 1 ? 'border-[#1C9BA0] bg-[#1C9BA0]' : 'border-gray-300 dark:border-gray-600'">
                                        <div class="w-1.5 h-1.5 rounded-full bg-white transition-transform"
                                             :class="editSelected == index + 1 ? 'scale-100' : 'scale-0'"></div>
                                    </div>
                                    <span class="text-xs sm:text-sm font-medium transition-colors"
                                          :class="editSelected == index + 1 ? 'text-[#1C9BA0] dark:text-[#38b2ac] font-semibold' : 'text-gray-800 dark:text-gray-200'"
                                          x-text="opt"></span>
                                </div>
                                <input type="radio" class="sr-only" name="edit_option" :value="index + 1" x-model="editSelected">
                            </label>
                        </template>
                    </div>

                    <!-- Textarea in Modal -->
                    <div x-show="isTextQuestion(editQuestion, editQuestionNumber)" class="space-y-1.5 pt-1">
                        <textarea x-model="editFreeText" maxlength="2028" rows="5"
                            class="w-full rounded-2xl border border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/60 p-4 text-xs sm:text-sm text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:outline-none focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 shadow-2xs leading-relaxed"></textarea>
                        <div class="text-right text-xs text-gray-400 font-mono" x-text="(editFreeText?.length || 0) + ' / 2028'"></div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="p-3.5 sm:px-6 sm:py-4 bg-slate-50 dark:bg-gray-800/90 border-t border-gray-100 dark:border-gray-700/80 flex items-center justify-end gap-2.5 sm:gap-3 shrink-0">
                    <button type="button" @click="closeEditModal"
                        class="px-5 py-2.5 bg-white hover:bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 border border-gray-200 dark:border-gray-600 rounded-full text-xs sm:text-sm font-semibold transition cursor-pointer">
                        Cancel
                    </button>
                    <button type="button" @click="submitEdit"
                        class="px-6 py-2.5 text-white font-semibold text-xs sm:text-sm rounded-full shadow-sm hover:shadow-md transition-all active:scale-[0.99] cursor-pointer hover:opacity-95 disabled:opacity-40 disabled:cursor-not-allowed"
                        style="background: linear-gradient(135deg, #1C9BA0, #127F94);"
                        :disabled="isTextQuestion(editQuestion, editQuestionNumber) ? !(editFreeText && editFreeText.trim().length > 0) : !editSelected">
                        Save Changes
                    </button>
                </div>
            </div>
        </div>

        <!-- ========================================== -->
        <!-- COMPLETION SCREEN                          -->
        <!-- ========================================== -->
        <div x-show="finished" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             class="bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl p-8 sm:p-12 shadow-[0_4px_25px_-5px_rgba(0,0,0,0.06)] dark:shadow-none border border-gray-100 dark:border-gray-700/80 text-center max-w-xl mx-auto space-y-5">
            
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center mx-auto shadow-sm"
                 style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </div>

            <div class="space-y-2">
                <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-gray-100 tracking-tight">
                    All Questions Completed!
                </h2>
                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 max-w-md mx-auto leading-relaxed">
                    Thank you for sharing your responses. We now have the insights needed to connect you with your most suitable practitioner.
                </p>
            </div>

            <div class="pt-3">
                <a href="{{ route('therapists.index') }}"
                    class="inline-flex items-center gap-2 px-8 py-3.5 text-white font-semibold text-sm rounded-full shadow-md hover:shadow-lg transition-all duration-200 active:scale-95 hover:opacity-95"
                    style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                    <span>Find Your Best Therapist</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>
            </div>
        </div>

    </div>

    <!-- Alpine JS Component -->
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
                search: '',

                summaryQuestions: config.questions || [],
                answersRow: config.answers || null,

                isEditOpen: false,
                editQuestion: {},
                editQuestionNumber: null,
                editSelected: null,
                editFreeText: '',

                filteredQuestions() {
                    if (!this.search || !this.search.trim()) {
                        return this.summaryQuestions;
                    }
                    const q = this.search.toLowerCase().trim();
                    return this.summaryQuestions.filter(item => {
                        const heading = (item.QuestionHeading || '').toLowerCase();
                        const notes = (item.QuestionNotes || '').toLowerCase();
                        const answer = (this.currentAnswerText(item.ID) || '').toLowerCase();
                        return heading.includes(q) || notes.includes(q) || answer.includes(q);
                    });
                },

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
