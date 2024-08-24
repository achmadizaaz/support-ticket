@extends('layouts.main')

@section('title', 'Open Ticket')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="card p-3">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Open Ticket</h4>
            </div>
        </div>
        <!-- end page title -->

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h4 class="alert-heading">Errors:</h4>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        <!-- start page main -->
        <div class="card p-3">
            <form action="{{ route('ticket.store') }}" method="POST" enctype="multipart/form-data" id="create" onsubmit="return validateQuill()">
                @csrf
                <div class="mb-3 row">
                    <div class="col-6">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" value="{{ Auth::user()->name }}" id="name" disabled>
                    </div>
                    <div class="col-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" value="{{ Auth::user()->email }}" id="email" disabled>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <label for="subject" class="form-label">Subject <span class="fst-italic text-danger">*</span></label>
                        <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject permalahan" autofocus required value="{{ old('subject') }}">
                    </div>
                    <div class="col-6">
                        <label for="category" class="form-label">Category <span class="fst-italic text-danger">*</span></label>
                        <select name="category" id="category" class="form-select" required>
                            <option value="">Choose a one</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected($category->id == old('category'))>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <div id="attachment">
                        <label class="form-label">Attachments</label>
                        <input type="file" class="form-control" name="attachment[]" accept=".jpg,.jpeg,.png,.pdf">
                    </div>
                    <div class="small fst-italic text-danger mb-2">
                        Format file yang diperbolehkan: .jpg, .jpeg, .png, .pdf (Max file size: 2048MB)
                    </div>
                    <button class="btn btn-sm btn-success" type="button" id="add_more_attachment">
                        <i class="bi bi-plus-lg me-1"></i> Add more
                    </button>
                    <button class="btn btn-sm btn-danger" type="button" id="remove_attachment">
                        <i class="bi bi-dash me-1"></i> Remove
                    </button>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Message <span class="fst-italic text-danger">*</span></label>
                    {{-- <input type="hidden" name="content" id="content"> --}}
                    <textarea name="content" id="content" style="display:none;">{{ old('content', $model->content ?? '') }}</textarea>
                    <div id="editor" style="min-height: 100px"> {!! old('content') !!}</div>
                </div>
                <div class="mb-3">
                    <button class="btn btn-primary" type="submit"> 
                        <i class="bi bi-send me-1"></i> Submit
                    </button>
                    <a href="{{ route('ticket') }}" class="btn btn-secondary">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
        <!-- end page main -->
    </div>
@endsection

@push('scripts')
    <!-- Initialize Quill editor -->
    <script>
        let attachment = document.getElementById("attachment");
        let addMoreAttachment = document.getElementById("add_more_attachment");
        let removeAttachment = document.getElementById("remove_attachment");

        addMoreAttachment.onclick = function () {
            let input = document.createElement("input");
            input.setAttribute("type", "file");
            input.setAttribute("name", "attachment[]");
            input.setAttribute("class", "form-control mt-2");
            input.setAttribute("accept", ".jpg,.jpeg,.png,.pdf");
            attachment.appendChild(input);
        };

        removeAttachment.onclick = function () {
            let input_tags = attachment.getElementsByTagName("input");
            if (input_tags.length > 1) {
                attachment.removeChild(input_tags[input_tags.length - 1]);
            }
        };

        // $("#create").on("submit",function() {
        //     let content = document.querySelector('input[name=message]');
        //     let editor = document.querySelector('#editor');
        //     content.value = editor.children[0].innerHTML;
        // })

        const quill = new Quill("#editor", {
        theme: "snow",
        });
        // Update textarea setiap ada perubahan di Quill
        quill.on('text-change', function() {
            document.getElementById('content').value = quill.root.innerHTML;
        });

        // Fungsi validasi untuk memastikan konten tidak kosong
        function validateQuill() {
            var quillContent = quill.getText().trim(); // Mendapatkan teks tanpa tag HTML
            if (quillContent.length === 0) {
                alert('Message tidak boleh kosong');
                return false; // Mencegah form submit jika konten kosong
            }
            return true;
        }
    </script>
@endpush