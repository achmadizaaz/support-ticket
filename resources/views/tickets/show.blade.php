@extends('layouts.main')

@section('title', 'View Ticket: #'.$ticket->no)

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="card p-3">
            <div class="d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Ticket: #{{ $ticket->no }} - <span class="text-success">{{ $ticket->subject }}</span></h4>
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
        <div class="row">
            <div class="col-3">
                <div class="card rounded-3 mb-3">
                    <div class="card-header fw-semibold">
                        <i class="bi bi-ticket-detailed-fill me-1"></i> Ticket Information
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="small fst-italic text-secondary">Requestor</div>
                            <h6>{{ $ticket->user->name }} <span class="badge bg-success">Owner</span></h6>
                        </div>
                        <div class="mb-3">
                            <div class="small fst-italic text-secondary">Email</div>
                            <h6>{{ $ticket->user->email }}</h6>
                        </div>
                        <div class="mb-3">
                            <div class="small fst-italic text-secondary">Phone</div>
                            <h6>0821-2345-6789</h6>
                        </div>
                        <div class="mb-3">
                            <div class="small fst-italic text-secondary">Category</div>
                            <h6>{{ $ticket->category->name }}</h6>
                        </div>
                        <div class="mb-3">
                            <div class="small fst-italic text-secondary">Submitted</div>
                            <h6>{{ $ticket->created_at }}</h6>
                        </div>
                        <div class="mb-3">
                            <div class="small fst-italic text-secondary">Last updated</div>
                            <h6>{{ $ticket->updated_at->diffForHumans() }}</h6>
                        </div>
                    </div>
                </div>

                <div class="card rounded-3">
                    <div class="card-header fw-semibold">
                        <i class="bi bi-paperclip me-1"></i> Attachments
                    </div>
                    <div class="card-body">
                       
                        <ul class="ps-3">
                            @foreach ($ticket->attachments as $item)
                            <li>
                                <a href="{{ asset('storage/'. $item->path) }}" target="__blank">{{ $item->name }}</a>
                            </li>
                        @endforeach
                        </ul>
                       
                    </div>
                </div>
            </div>
            <div class="col-9">
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="bi bi-chat-left-text me-1"></i> Ticket Message
                    </div>
                    <div class="card-body">
                        {!! $ticket->content !!}
                    </div>
                </div>


                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="d-inline-flex gap-1">
                        <a class="btn btn-info" data-bs-toggle="collapse" href="#collapseReply" role="button" aria-expanded="false" aria-controls="collapseReply">
                            <i class="bi bi-chat-left-dots me-1"></i> Reply Message
                        </a>
                    </div>
                    <div class="fst-italic fw-semibold">
                        Latest reply
                    </div>
                </div>

                <div class="collapse" id="collapseReply">
                    <div class="card">
                        <div class="card-header">
                            <span class="fw-bold">
                                <i class="bi bi-chat-left-dots me-1"></i> Reply Ticket
                            </span>
                        </div>
                        <div class="card-body">
                            <form action="#">
                                @csrf
                                <div class="mb-3">
                                    <textarea name="content" id="content" style="display:none;">{{ old('content', $model->content ?? '') }}</textarea>
                                    <div id="editor" style="min-height: 100px"> {!! old('content') !!}</div>
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
                                    <button type="button" class="btn btn-sm btn-primary">
                                        <i class="bi bi-send me-1"></i> Send Reply
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <hr>

                <div class="alert alert-warning text-center" role="alert">
                    No reply available.
                </div>
                {{-- Card reply message 1 --}}
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2">
                            <div class="img-user">
                                <img class="rounded-circle header-profile-user" src="@if(isset(Auth::user()->image)) {{ asset('storage/'.Auth::user()->image) }} @else {{ asset('assets/images/no-image.webp')  }} @endif" alt="{{ Auth::user()->name }}">
                            </div>
                            <div class="">
                                <div>{{ $ticket->user->name }}</div>
                                <div class="badge bg-success">Owner</div>
                            </div>
                        </div>
                        <div class="small text-secondary">
                            2024-08-24 11:35:30
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="reply-content">
                            {!! $ticket->message !!}
                        </div>
                        <hr>
                        <div class="reply-attachment">
                            <span class="fw-semibold">Attactment Files:</span>
                            <ul>
                                <li><a href="#">File attachment reply 1</a></li>
                                <li><a href="#">File attachment reply 2</a></li>
                                <li><a href="#">File attachment reply 3</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                {{-- Card reply message 2 --}}
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2">
                            <div class="img-user">
                                <img class="rounded-circle header-profile-user" src="@if(isset(Auth::user()->image)) {{ asset('storage/'.Auth::user()->image) }} @else {{ asset('assets/images/no-image.webp')  }} @endif" alt="{{ Auth::user()->name }}">
                            </div>
                            <div class="">
                                <div>Achmad Izaaz</div>
                                <div class="badge bg-info">Staff</div>
                            </div>
                        </div>
                        <div class="small text-secondary">
                            2024-08-24 11:35:30
                        </div>
                    </div>
                    <div class="card-body">
                        Satuan milimeter (atau kadang-kadang sentimeter) juga dipakai di kalangan meteorologi sebagai ukuran curah hujan (presipitasi cair). Satuan ini muncul dari hasil penyederhanaan untuk liter per meter persegi. Satu liter adalah 106 milimeter kubik sedangkan satu meter persegi adalah 106 milimeter persegi. Dengan demikian, milimeter dengan liter per meter persegi adalah identik.
                    </div>
                </div>

                
            </div>
        </div>
        <!-- end page main -->
    </div>
@endsection

@push('scripts')
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