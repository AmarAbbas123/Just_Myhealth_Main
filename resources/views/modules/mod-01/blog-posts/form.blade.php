<x-app1>

    <div class="w-full space-y-6 pt-3 pb-12"
         x-data="{
             imagePreview: '{{ $post->FeaturedImagePath ? $post->featuredImageUrl() : '' }}',
             isPublished: {{ old('IsPublished', $post->IsPublished ? 1 : 0) ? 'true' : 'false' }},
             fileChosen(event) {
                 const file = event.target.files[0];
                 if (file) {
                     const reader = new FileReader();
                     reader.onload = (e) => { this.imagePreview = e.target.result; };
                     reader.readAsDataURL(file);
                 }
             }
         }">

        <!-- Top Navigation & Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="min-w-0">
                <x-page-header />
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2.5 shrink-0 self-start sm:self-center">
                @if ($post->exists && $post->IsPublished)
                    <a href="{{ route('blogs.show', $post) }}" target="_blank"
                       class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs sm:text-sm font-semibold text-teal-700 dark:text-teal-300 bg-teal-50 dark:bg-teal-950/40 border border-teal-200 dark:border-teal-800 hover:bg-teal-100 dark:hover:bg-teal-900/40 shadow-xs transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                        <span>View Live</span>
                    </a>
                @endif

                <a href="{{ route('blog-posts.index') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs sm:text-sm font-semibold text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 shadow-xs transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span>Back to Posts</span>
                </a>
            </div>
        </div>

        <!-- Hero Header Card -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_25px_-5px_rgba(0,0,0,0.05)] overflow-hidden">
            <div class="flex items-start gap-4 p-5 sm:p-6">
                <div class="w-12 h-12 rounded-xl shrink-0 flex items-center justify-center text-white shadow-xs"
                     style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <div class="min-w-0 flex-1">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-[#1C9BA0]">Blog Management</span>
                        @if ($post->exists)
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-mono font-bold bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                                ID: #{{ $post->id }}
                            </span>
                            @if ($post->IsPublished)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    Published
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-800">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    Draft
                                </span>
                            @endif
                        @endif
                    </div>
                    <h1 class="text-lg sm:text-2xl font-bold text-gray-900 dark:text-gray-100 mt-1 truncate">
                        {{ $post->exists ? ($post->Title ?: 'Edit Blog Post') : 'Create New Blog Post' }}
                    </h1>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                        {{ $post->exists ? 'Update your article content, media, YouTube video, and publication settings.' : 'Fill in the details below to create and publish a new blog post.' }}
                    </p>
                </div>
            </div>
            <div class="h-1 w-full bg-gradient-to-r from-[#1C9BA0] via-[#127F94] to-teal-400"></div>
        </div>

        <!-- Validation Errors Alert -->
        @if ($errors->any())
            <div class="flex gap-3 rounded-2xl border border-red-200 dark:border-red-900/60 bg-red-50 dark:bg-red-950/30 p-4 text-sm text-red-700 dark:text-red-400 shadow-xs">
                <svg class="h-5 w-5 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M4.93 19h14.14a1 1 0 00.86-1.5L12.86 4.5a1 1 0 00-1.72 0L4.07 17.5a1 1 0 00.86 1.5z" />
                </svg>
                <div class="flex-1">
                    <p class="font-semibold mb-1">Please fix the following errors:</p>
                    <ul class="list-disc list-inside space-y-1 text-xs sm:text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Form -->
        <form method="POST"
              action="{{ $post->exists ? route('blog-posts.update', $post) : route('blog-posts.store') }}"
              enctype="multipart/form-data">
            @csrf
            @if ($post->exists)
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

                <!-- Left Column: Main Content (2 cols) -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Section 1: Article Content -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_25px_-5px_rgba(0,0,0,0.05)] p-5 sm:p-7 space-y-6">
                        <div class="flex items-center gap-2.5 pb-4 border-b border-gray-100 dark:border-gray-700/80">
                            <span class="flex h-7 w-7 items-center justify-center rounded-xl bg-[#1C9BA0]/10 text-xs font-bold text-[#1C9BA0]">1</span>
                            <div>
                                <h2 class="text-sm sm:text-base font-bold text-gray-900 dark:text-gray-100">Article Content</h2>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Main headline, summary teaser, and full blog body</p>
                            </div>
                        </div>

                        <!-- Title -->
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">
                                Post Title <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="Title" value="{{ old('Title', $post->Title) }}" required maxlength="255"
                                   placeholder="e.g. 5 Simple Stretches to Ease Desk-Work Back Pain"
                                   class="mt-2 w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 p-3 text-sm text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:bg-white dark:focus:bg-gray-900 focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition">
                        </div>

                        <!-- Excerpt -->
                        <div>
                            <div class="flex items-center justify-between">
                                <label class="block text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">
                                    Summary / Excerpt <span class="text-red-500">*</span>
                                </label>
                                <span class="text-[11px] text-gray-400">Max 300 characters</span>
                            </div>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5 mb-2">Short teaser shown on the blog cards and search engines to engage readers.</p>
                            <textarea name="Excerpt" rows="3" maxlength="300" required
                                      placeholder="A quick hook that makes someone want to click and read more..."
                                      class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 p-3 text-sm text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:bg-white dark:focus:bg-gray-900 focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition">{{ old('Excerpt', $post->Excerpt) }}</textarea>
                        </div>

                        <!-- Body -->
                        <div>
                            <div class="flex items-center justify-between">
                                <label class="block text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">
                                    Full Post Content <span class="text-red-500">*</span>
                                </label>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                                    HTML Supported
                                </span>
                            </div>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5 mb-2">
                                Standard HTML tags are supported (e.g., <code class="text-teal-600 dark:text-teal-400">&lt;p&gt;</code>, <code class="text-teal-600 dark:text-teal-400">&lt;b&gt;</code>, <code class="text-teal-600 dark:text-teal-400">&lt;ul&gt;</code>, <code class="text-teal-600 dark:text-teal-400">&lt;li&gt;</code>, <code class="text-teal-600 dark:text-teal-400">&lt;a href="..."&gt;</code>).
                            </p>
                            <textarea name="Body" rows="12" required
                                      class="w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 p-3 text-sm text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:bg-white dark:focus:bg-gray-900 focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition font-mono leading-relaxed">{{ old('Body', $post->Body) }}</textarea>
                        </div>
                    </div>

                    <!-- Section 2: YouTube / Video Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_25px_-5px_rgba(0,0,0,0.05)] p-5 sm:p-7 space-y-5">
                        <div class="flex items-center gap-2.5 pb-4 border-b border-gray-100 dark:border-gray-700/80">
                            <span class="flex h-7 w-7 items-center justify-center rounded-xl bg-[#1C9BA0]/10 text-xs font-bold text-[#1C9BA0]">2</span>
                            <div>
                                <h2 class="text-sm sm:text-base font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                    <span>Video Card</span>
                                    <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full bg-red-50 dark:bg-red-950/40 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-900/50">Optional</span>
                                </h2>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Featured video shown alongside or on mobile top of the post</p>
                            </div>
                        </div>

                        <!-- Video Link -->
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">
                                Video URL
                            </label>
                            <div class="relative mt-2">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                                    <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/>
                                    </svg>
                                </div>
                                <input type="url" name="VideoUrl" value="{{ old('VideoUrl', $post->VideoUrl) }}"
                                       placeholder="https://www.youtube.com/watch?v=... or https://youtu.be/..."
                                       class="w-full pl-10 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 p-3 text-sm text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:bg-white dark:focus:bg-gray-900 focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition">
                            </div>
                        </div>

                        <!-- Video Title -->
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">
                                Video Title
                            </label>
                            <input type="text" name="VideoTitle" value="{{ old('VideoTitle', $post->VideoTitle) }}" maxlength="255"
                                   placeholder="e.g. Watch our step-by-step video guide"
                                   class="mt-2 w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 p-3 text-sm text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:bg-white dark:focus:bg-gray-900 focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition">
                        </div>

                        <!-- Video Description -->
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">
                                Video Card Description
                            </label>
                            <textarea name="VideoDescription" rows="3" maxlength="1000"
                                      placeholder="Brief caption displayed underneath the video preview card..."
                                      class="mt-2 w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 p-3 text-sm text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:bg-white dark:focus:bg-gray-900 focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition">{{ old('VideoDescription', $post->VideoDescription) }}</textarea>
                        </div>
                    </div>

                    <!-- Section 3: Source & Attribution -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_25px_-5px_rgba(0,0,0,0.05)] p-5 sm:p-7 space-y-5">
                        <div class="flex items-center gap-2.5 pb-4 border-b border-gray-100 dark:border-gray-700/80">
                            <span class="flex h-7 w-7 items-center justify-center rounded-xl bg-[#1C9BA0]/10 text-xs font-bold text-[#1C9BA0]">3</span>
                            <div>
                                <h2 class="text-sm sm:text-base font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                    <span>Source & Attribution</span>
                                    <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">Optional</span>
                                </h2>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Credit original publications or social media sources</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">
                                    Source Platform
                                </label>
                                <select name="SourcePlatform"
                                        class="mt-2 w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 p-3 text-sm text-gray-800 dark:text-gray-100 focus:bg-white dark:focus:bg-gray-900 focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition">
                                    <option value="">— None (Original Post) —</option>
                                    @foreach (['Instagram', 'Facebook', 'Twitter / X', 'LinkedIn', 'TikTok'] as $platform)
                                        <option value="{{ $platform }}" @selected(old('SourcePlatform', $post->SourcePlatform) === $platform)>
                                            {{ $platform }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">
                                    Original Post URL
                                </label>
                                <input type="url" name="SourceUrl" value="{{ old('SourceUrl', $post->SourceUrl) }}"
                                       placeholder="https://instagram.com/p/..."
                                       class="mt-2 w-full rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 p-3 text-sm text-gray-800 dark:text-gray-100 placeholder-gray-400 focus:bg-white dark:focus:bg-gray-900 focus:border-[#1C9BA0] focus:ring-2 focus:ring-[#1C9BA0]/20 transition">
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right Column: Image, Tips & Publication (1 col) -->
                <div class="lg:col-span-1 space-y-6">

                    <!-- Section 4: Featured Image Card -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_25px_-5px_rgba(0,0,0,0.05)] p-5 sm:p-6 space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700/80">
                            <h2 class="text-sm font-bold text-gray-900 dark:text-gray-100 flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#1C9BA0]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>Featured Image</span>
                            </h2>
                            <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">Max 4MB</span>
                        </div>

                        <!-- Image Preview Box -->
                        <div class="relative w-full aspect-video rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 flex items-center justify-center">
                            <template x-if="imagePreview">
                                <img :src="imagePreview" alt="Featured Image Preview" class="w-full h-full object-cover">
                            </template>
                            <template x-if="!imagePreview">
                                <div class="text-center p-4">
                                    <div class="w-12 h-12 mx-auto rounded-xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-400 mb-2">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <span class="text-xs text-gray-400">No image chosen</span>
                                </div>
                            </template>
                        </div>

                        <!-- Custom File Input -->
                        <div>
                            <input type="file" name="FeaturedImage" id="FeaturedImage" accept="image/*"
                                   @change="fileChosen($event)"
                                   class="block w-full text-xs text-gray-500 dark:text-gray-400 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#1C9BA0]/10 file:text-[#1C9BA0] hover:file:bg-[#1C9BA0]/20 transition cursor-pointer">
                            <p class="text-[11px] text-gray-400 dark:text-gray-500 mt-2">
                                {{ $post->FeaturedImagePath ? 'Upload a new file to replace the current thumbnail.' : 'Supports JPG, PNG, WEBP up to 4MB.' }}
                            </p>
                        </div>
                    </div>

                    <!-- Helpful Formatting Tips Card -->
                    <div class="bg-gradient-to-br from-teal-50/60 to-cyan-50/30 dark:from-gray-800 dark:to-gray-800/80 rounded-2xl sm:rounded-3xl border border-teal-100 dark:border-gray-700/80 p-5 space-y-3">
                        <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-[#1C9BA0]">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Publishing Tips</span>
                        </div>
                        <ul class="text-xs text-gray-600 dark:text-gray-400 space-y-2 leading-relaxed">
                            <li class="flex items-start gap-1.5">
                                <span class="text-[#1C9BA0] font-bold">•</span>
                                <span>The <strong>Featured Image</strong> is also used as the YouTube-style video thumbnail.</span>
                            </li>
                            <li class="flex items-start gap-1.5">
                                <span class="text-[#1C9BA0] font-bold">•</span>
                                <span>On mobile devices, posts with a video card will display the video right at the top.</span>
                            </li>
                            <li class="flex items-start gap-1.5">
                                <span class="text-[#1C9BA0] font-bold">•</span>
                                <span>Keep excerpts punchy to boost click-through rates from the main blog grid.</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Publication & Status Card (At End) -->
                    <div class="bg-white dark:bg-gray-800 rounded-2xl sm:rounded-3xl border border-gray-100 dark:border-gray-700/80 shadow-[0_4px_25px_-5px_rgba(0,0,0,0.05)] p-5 sm:p-6 space-y-5">
                        <div class="flex items-center justify-between pb-3 border-b border-gray-100 dark:border-gray-700/80">
                            <h2 class="text-sm font-bold text-gray-900 dark:text-gray-100">Publication</h2>
                            <template x-if="isPublished">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    Live
                                </span>
                            </template>
                            <template x-if="!isPublished">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-800">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    Draft
                                </span>
                            </template>
                        </div>

                        <!-- Publish Toggle -->
                        <div class="p-3.5 rounded-2xl bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-700/60">
                            <label for="IsPublished" class="flex items-start justify-between gap-3 cursor-pointer select-none">
                                <div class="min-w-0">
                                    <span class="block text-sm font-bold text-gray-800 dark:text-gray-200">Published Status</span>
                                    <span class="block text-xs text-gray-500 dark:text-gray-400 mt-0.5" x-text="isPublished ? 'Visible on public blog' : 'Hidden from public view'"></span>
                                </div>

                                <div class="relative inline-flex shrink-0 mt-0.5">
                                    <input type="hidden" name="IsPublished" value="0">
                                    <input type="checkbox" id="IsPublished" name="IsPublished" value="1"
                                           @checked(old('IsPublished', $post->IsPublished))
                                           @change="isPublished = $event.target.checked"
                                           class="peer sr-only">
                                    <div class="w-11 h-6 bg-gray-300 dark:bg-gray-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#1C9BA0]"></div>
                                </div>
                            </label>
                        </div>

                        @if ($post->exists && $post->PublishedAt)
                            <div class="flex items-center gap-2 text-xs text-gray-500 dark:text-gray-400 pt-1">
                                <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>Published: <strong class="text-gray-700 dark:text-gray-200">{{ $post->PublishedAt->format('M j, Y h:i A') }}</strong></span>
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="space-y-2.5 pt-2">
                            <button type="submit"
                                    class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl text-sm font-bold text-white shadow-md hover:opacity-95 transition-all active:scale-[0.98]"
                                    style="background: linear-gradient(135deg, #1C9BA0, #127F94);">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>{{ $post->exists ? 'Save Changes' : 'Create Post' }}</span>
                            </button>

                            <a href="{{ route('blog-posts.index') }}"
                               class="w-full inline-flex items-center justify-center gap-1.5 px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                <span>Cancel</span>
                            </a>
                        </div>
                    </div>

                </div>

            </div>
        </form>
    </div>

</x-app1>
