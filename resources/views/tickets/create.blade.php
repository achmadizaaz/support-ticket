@extends('layouts.main')

@section('title', 'Open Ticket')

@section('content')
   
        <!-- start page title -->
        <div class="card p-3">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Open Ticket</h4>
            </div>
        </div>
        <!-- end page title -->

        <div class="alert alert-info" role="alert">
            Tim <b>support kami</b> akan merespons permintaan Anda dalam waktu maksimal 1x24 jam pada hari kerja. Terima kasih.
        </div>

        @empty(Auth::user()->email)
            <div class="alert alert-danger" role="alert">
                <b>Email</b> akun anda belum ditambahkan, silakan tambahkan terlebih dahulu <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#emailModal">
                    Klik disini
                </button> untuk mendapatkan notifikasi balasan dari tim support ticket.
                <!-- Modal -->
                <div class="modal fade" id="emailModal" tabindex="-1" aria-labelledby="emailModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-content">
                                <div class="modal-header">
                                <h1 class="modal-title fs-5" id="emailModalLabel">Add Email</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <input type="hidden" name="name" class="form-control" value="{{ Auth::user()->name }}">
                                    <input type="email" name="email" class="form-control" placeholder="Masukkan alamat email anda">
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="Submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endempty


        @if ($errors->any())
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
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
                <div class="row">
                    <div class="mb-3 col-12 col-sm-6">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" value="{{ Auth::user()->name }}" id="name" disabled>
                    </div>
                    <div class="mb-3 col-12 col-sm-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" value="{{ Auth::user()->email ?? 'Email belum ditambahkan!' }}" id="email" disabled>
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-12 col-sm-6">
                        <label for="subject" class="form-label">Subject <span class="fst-italic text-danger">*</span></label>
                        <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject permalahan" autofocus required value="{{ old('subject') }}">
                    </div>
                    <div class="mb-3 col-12 col-sm-6">
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