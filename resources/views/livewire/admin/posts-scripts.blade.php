@push('scripts')
    <!-- jQuery (required for Summernote) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Summernote CSS -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <!-- Custom Summernote Styling -->
    <style>
        .note-editor {
            border: 2px solid #e2e8f0;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .note-editor:focus-within {
            border-color: #38bdf8;
            box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.1);
        }

        .note-toolbar {
            background: linear-gradient(to right, #f0f9ff, #f5f3ff);
            border-bottom: 2px solid #e2e8f0;
            padding: 0.75rem;
        }

        .note-btn {
            border-radius: 0.5rem;
            margin: 0 0.125rem;
        }

        .note-btn:hover {
            background-color: #38bdf8;
            color: white;
        }

        .note-editable {
            min-height: 300px;
            padding: 1.5rem;
            font-size: 1rem;
            line-height: 1.75;
            color: #334155;
            background-color: white;
        }

        .note-editable:focus {
            background-color: #fefefe;
        }

        .note-modal {
            z-index: 1060 !important;
        }

        .note-modal-backdrop {
            z-index: 1050 !important;
        }
    </style>

    <script>
        $(document).ready(function () {
            let editor;

            // Initialize Summernote
            function initSummernote() {
                // Destroy existing instance if any
                if (editor && $('#summernote-editor').length) {
                    $('#summernote-editor').summernote('destroy');
                    editor = null;
                }

                // Initialize new instance
                if ($('#summernote-editor').length) {
                    editor = $('#summernote-editor').summernote({
                        height: 300,
                        dialogsInBody: true,
                        placeholder: 'Tulis konten artikel di sini...',
                        toolbar: [
                            ['style', ['style']],
                            ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
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
                            onChange: function (contents) {
                                @this.set('content', contents);
                            },
                            onImageUpload: function (files) {
                                uploadEditorImage(files[0]);
                            },
                            onInit: function () {
                                console.log('Summernote initialized');
                            }
                        }
                    });
                }
            }

            function uploadEditorImage(file) {
                let data = new FormData();
                data.append("image", file);
                
                $.ajax({
                    url: '{{ route("admin.posts.upload-image") }}',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: data,
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.url) {
                            $('#summernote-editor').summernote('insertImage', response.url);
                        }
                    },
                    error: function(data) {
                        console.error('Image upload failed:', data);
                        alert('Gagal mengupload gambar. Silakan coba lagi.');
                    }
                });
            }

            // Initialize on page load
            initSummernote();

            // Reinitialize when modal opens
            Livewire.on('modalOpened', () => {
                setTimeout(() => {
                    initSummernote();
                }, 200);
            });

            // Update editor content when editing
            Livewire.on('contentUpdated', (event) => {
                setTimeout(() => {
                    if ($('#summernote-editor').length) {
                        const content = event.content || '';
                        $('#summernote-editor').summernote('code', content);
                        console.log('Content updated:', content.substring(0, 50) + '...');
                    }
                }, 300);
            });

            // Destroy editor when modal closes
            Livewire.on('modalClosed', () => {
                if (editor && $('#summernote-editor').length) {
                    $('#summernote-editor').summernote('destroy');
                    editor = null;
                }
            });
        });
    </script>
@endpush