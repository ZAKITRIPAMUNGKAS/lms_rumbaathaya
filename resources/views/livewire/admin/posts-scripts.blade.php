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

        /* Summernote Modal Styling */
        .note-modal-content {
            border: none !important;
            border-radius: 1.5rem !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25) !important;
            background-color: white !important;
            overflow: hidden !important;
            padding: 1.5rem !important;
        }

        .note-modal-header {
            border-bottom: 1px solid #f1f5f9 !important;
            padding: 0.5rem 0 1rem 0 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
        }

        .note-modal-title {
            font-size: 1.25rem !important;
            font-weight: 800 !important;
            color: #1e293b !important;
            letter-spacing: -0.025em !important;
        }

        .note-modal-header .close {
            background: none !important;
            border: none !important;
            font-size: 1.5rem !important;
            color: #94a3b8 !important;
            cursor: pointer !important;
            transition: color 0.2s !important;
        }

        .note-modal-header .close:hover {
            color: #ef4444 !important;
        }

        .note-modal-body {
            padding: 1.5rem 0 !important;
        }

        .note-form-group {
            margin-bottom: 1.25rem !important;
        }

        .note-form-label {
            font-size: 0.75rem !important;
            font-weight: 700 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.05em !important;
            color: #475569 !important;
            margin-bottom: 0.5rem !important;
            display: block !important;
        }

        .note-input {
            width: 100% !important;
            padding: 0.75rem 1.25rem !important;
            background-color: #f8fafc !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 0.75rem !important;
            font-size: 0.875rem !important;
            font-weight: 600 !important;
            color: #1e293b !important;
            transition: all 0.2s !important;
        }

        .note-input:focus {
            background-color: white !important;
            border-color: #38bdf8 !important;
            outline: none !important;
            box-shadow: 0 0 0 4px rgba(56, 189, 248, 0.1) !important;
        }

        .note-modal-footer {
            border-top: 1px solid #f1f5f9 !important;
            padding: 1rem 0 0 0 !important;
            display: flex !important;
            justify-content: flex-end !important;
            gap: 0.75rem !important;
        }

        /* Summernote Modal Buttons */
        .note-modal-footer .note-btn {
            padding: 0.75rem 1.5rem !important;
            font-weight: 700 !important;
            font-size: 0.875rem !important;
            border-radius: 0.75rem !important;
            transition: all 0.2s !important;
            border: none !important;
            cursor: pointer !important;
        }

        /* Primary button (e.g. Insert Image) */
        .note-modal-footer .note-btn-primary {
            background: linear-gradient(to right, #0284c7, #2563eb) !important;
            color: white !important;
            box-shadow: 0 10px 15px -3px rgba(3, 105, 161, 0.3) !important;
        }

        .note-modal-footer .note-btn-primary:hover {
            box-shadow: 0 20px 25px -5px rgba(3, 105, 161, 0.4) !important;
            transform: translateY(-1px) !important;
        }

        .note-modal-footer .note-btn-primary:disabled {
            opacity: 0.6 !important;
            cursor: not-allowed !important;
            transform: none !important;
        }

        /* Cancel button */
        .note-modal-footer .note-btn:not(.note-btn-primary) {
            background-color: #f1f5f9 !important;
            color: #475569 !important;
        }

        .note-modal-footer .note-btn:not(.note-btn-primary):hover {
            background-color: #e2e8f0 !important;
            color: #1e293b !important;
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
                            onPaste: function (e) {
                                var clipboardData = e.originalEvent.clipboardData;
                                if (clipboardData && clipboardData.items && clipboardData.items.length) {
                                    var item = clipboardData.items[0];
                                    if (item.kind === 'file' && item.type.indexOf('image/') !== -1) {
                                        e.preventDefault();
                                        var file = item.getAsFile();
                                        uploadEditorImage(file);
                                    }
                                }
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