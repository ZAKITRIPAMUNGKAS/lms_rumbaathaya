@extends('layouts.admin')

@section('title', isset($post) ? 'Edit Artikel' : 'Buat Artikel Baru')

@section('content')
    <div class="space-y-6 p-4 sm:p-8">
        <!-- Hero Header -->
        <div
            class="relative overflow-hidden rounded-[2rem] bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 p-6 sm:p-8 text-white shadow-xl">
            <div class="absolute right-0 bottom-0 w-48 h-48 bg-white/10 rounded-full blur-3xl -mr-12 -mb-12"></div>
            <div class="absolute top-0 left-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -ml-8 -mt-8"></div>

            <div class="relative z-10">
                <div class="flex items-center gap-2 text-indigo-100 text-xs mb-2">
                    <i class="ph ph-newspaper"></i>
                    Sahabat RA
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold mb-1">
                    {{ isset($post) ? '✏️ Edit Artikel' : '✨ Buat Artikel Baru' }}
                </h1>
                <p class="text-indigo-100 text-sm">
                    {{ isset($post) ? 'Perbarui konten artikel Anda' : 'Tulis dan bagikan cerita menarik' }}
                </p>
            </div>
        </div>

        <!-- Form Card -->
        <form action="{{ isset($post) ? route('admin.posts.update', $post->id) : route('admin.posts.store') }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($post))
                @method('PUT')
            @endif

            <div class="bg-white/80 backdrop-blur-xl rounded-[2rem] border border-white/60 shadow-xl p-6 sm:p-8 space-y-6">

                <!-- Title -->
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-700">
                        Judul Artikel <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title', $post->title ?? '') }}"
                        class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all text-slate-900 font-semibold placeholder-slate-400"
                        placeholder="Masukkan judul artikel yang menarik..." required>
                    @error('title')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Slug -->
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-700">
                        Slug <span class="text-xs text-slate-500">(URL-friendly)</span>
                    </label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $post->slug ?? '') }}"
                        class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all text-slate-700 font-mono text-sm"
                        placeholder="otomatis-dari-judul" required>
                    @error('slug')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category & Status Row -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Category -->
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-700">
                            Kategori
                        </label>
                        <select name="category"
                            class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all text-slate-900 font-semibold">
                            <option value="">Pilih Kategori</option>
                            <option value="Berita" {{ old('category', $post->category ?? '') == 'Berita' ? 'selected' : '' }}>
                                📰 Berita</option>
                            <option value="Pengumuman" {{ old('category', $post->category ?? '') == 'Pengumuman' ? 'selected' : '' }}>📢 Pengumuman</option>
                            <option value="Tips Belajar" {{ old('category', $post->category ?? '') == 'Tips Belajar' ? 'selected' : '' }}>💡 Tips Belajar</option>
                            <option value="Prestasi" {{ old('category', $post->category ?? '') == 'Prestasi' ? 'selected' : '' }}>🏆 Prestasi</option>
                            <option value="Kegiatan" {{ old('category', $post->category ?? '') == 'Kegiatan' ? 'selected' : '' }}>🎉 Kegiatan</option>
                        </select>
                        @error('category')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-700">
                            Status Publikasi
                        </label>
                        <select name="is_published"
                            class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all text-slate-900 font-semibold">
                            <option value="0" {{ old('is_published', $post->is_published ?? 0) == 0 ? 'selected' : '' }}>📝
                                Draft</option>
                            <option value="1" {{ old('is_published', $post->is_published ?? 0) == 1 ? 'selected' : '' }}>✅
                                Publish</option>
                        </select>
                    </div>
                </div>

                <!-- Cover Image -->
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-700">
                        Cover Image
                    </label>
                    <div class="flex items-center gap-4">
                        <label class="flex-1 cursor-pointer">
                            <div
                                class="flex items-center gap-3 px-4 py-3 bg-gradient-to-r from-indigo-50 to-purple-50 border-2 border-dashed border-indigo-300 rounded-xl hover:border-indigo-500 transition-all">
                                <i class="ph-bold ph-upload text-2xl text-indigo-600"></i>
                                <div>
                                    <p class="text-sm font-bold text-indigo-700">Upload Gambar</p>
                                    <p class="text-xs text-slate-500">PNG, JPG, max 2MB</p>
                                </div>
                            </div>
                            <input type="file" name="cover_image" id="cover_image" accept="image/*" class="hidden"
                                onchange="previewImage(this)">
                        </label>
                    </div>
                    @if(isset($post) && $post->cover_image)
                        <div class="mt-3">
                            <p class="text-xs text-slate-500 mb-2">Current Image:</p>
                            <img src="{{ $post->cover_image }}" alt="Current cover"
                                class="w-48 h-32 object-cover rounded-xl border-2 border-slate-200">
                        </div>
                    @endif
                    <div id="imagePreview" class="hidden mt-3">
                        <p class="text-xs text-slate-500 mb-2">Preview:</p>
                        <img id="preview" src="" alt="Preview"
                            class="w-48 h-32 object-cover rounded-xl border-2 border-indigo-200">
                    </div>
                    @error('cover_image')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Excerpt -->
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-700">
                        Ringkasan <span class="text-xs text-slate-500">(Opsional)</span>
                    </label>
                    <textarea name="excerpt" rows="3"
                        class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 transition-all text-slate-700"
                        placeholder="Tulis ringkasan singkat artikel...">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
                    @error('excerpt')
                        <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Content Editor -->
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-700">
                        Konten Artikel <span class="text-red-500">*</span>
                    </label>
                    <div class="summernote-wrapper">
                        <textarea name="content" id="summernote">{{ old('content', $post->content ?? '') }}</textarea>
                    </div>
                    @error('content')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap gap-4 pt-6 border-t border-slate-200">
                    <button type="submit"
                        class="flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                        <i class="ph-bold ph-floppy-disk"></i>
                        {{ isset($post) ? 'Update Artikel' : 'Simpan Artikel' }}
                    </button>
                    <a href="{{ route('admin.posts.index') }}"
                        class="flex items-center gap-2 px-8 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition-colors">
                        <i class="ph-bold ph-x"></i>
                        Batal
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

    <!-- Custom Summernote Styling -->
    <style>
        .summernote-wrapper .note-editor {
            border: 2px solid #e2e8f0;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .summernote-wrapper .note-editor:focus-within {
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        .summernote-wrapper .note-toolbar {
            background: linear-gradient(to right, #eef2ff, #f5f3ff);
            border-bottom: 2px solid #e2e8f0;
            padding: 0.75rem;
        }

        .summernote-wrapper .note-btn {
            border-radius: 0.5rem;
            margin: 0 0.125rem;
        }

        .summernote-wrapper .note-btn:hover {
            background-color: #6366f1;
            color: white;
        }

        .summernote-wrapper .note-editable {
            min-height: 400px;
            padding: 1.5rem;
            font-size: 1rem;
            line-height: 1.75;
            color: #334155;
        }

        .summernote-wrapper .note-editable:focus {
            background-color: #fefefe;
        }
    </style>
@endsection

@push('scripts')
    <!-- jQuery (required for Summernote) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <script>
        $(document).ready(function () {
            // Initialize Summernote
            $('#summernote').summernote({
                height: 400,
                placeholder: 'Tulis konten artikel Anda di sini...',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Helvetica', 'Impact', 'Tahoma', 'Times New Roman', 'Verdana'],
                fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '20', '24', '28', '32', '36', '48'],
                callbacks: {
                    onInit: function () {
                        console.log('Summernote initialized');
                    }
                }
            });

            // Auto-generate slug from title
            $('#title').on('input', function () {
                let title = $(this).val();
                let slug = title
                    .toLowerCase()
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-')
                    .trim();
                $('#slug').val(slug);
            });
        });

        // Image preview function
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    $('#imagePreview').removeClass('hidden');
                    $('#preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush