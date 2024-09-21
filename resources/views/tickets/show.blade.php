@extends('layouts.main')

@section('title', 'View Ticket: #'.$ticket->no)

@section('content')
    
        <!-- start page title -->
        <div class="card p-3">
            <h6 class="mb-2">No Ticket: #{{ $ticket->no }}</h6>
            <div class="text-success fs-4">
                {{ $ticket->subject }}
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

        @if ($ticket->status == 'closed')
            <div class="alert alert-secondary" role="alert">
                Status pada ticket ini sudah ditutup, <i>reply message</i> ticket untuk membuka kembali.
            </div>
        @endif
        
        @if ($ticket->status == 'completed')
            <div class="alert alert-success" role="alert">
                Status ticket sudah diselesaikan, Anda tidak bisa membuka kembali ticket ini.
            </div>
        @endif
        
        <!-- start page main -->
        <div class="row">
            <div class="mb-3 col-12 col-sm-3">
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
                            <h6>{{ $ticket->user->phone ?? '-' }}</h6>
                        </div>
                        <div class="mb-3">
                            <div class="small fst-italic text-secondary">Category</div>
                            <h6>{{ $ticket->category->name ?? 'Tidak ada kategori' }}</h6>
                        </div>
                        <div class="mb-3">
                            <div class="small fst-italic text-secondary">Submitted</div>
                            <h6>{{ $ticket->created_at }}</h6>
                        </div>
                        <div class="mb-3">
                            <div class="small fst-italic text-secondary">Last updated</div>
                            <h6>{{ $ticket->updated_at->diffForHumans() }}</h6>
                        </div>
                        <div class="mb-3">
                            <div class="small fst-italic text-secondary">Homebase</div>
                            <h6>{{ $ticket->user->homebase->name ?? '-' }}</h6>
                        </div>
                    </div>
                </div>

                <div class="card rounded-3">
                    <div class="card-header fw-semibold">
                        <div class="d-flex justify-content-between">
                            <span> <i class="bi bi-bar-chart me-1"></i> Ticket Status</span>
                            @if (Auth::user()->roles->max('is_admin'))
                                <a href="#edit-status"  data-bs-toggle="modal" data-bs-target="#editStatuModal">Edit</a>
                                <!-- Modal -->
                                <div class="modal fade" id="editStatuModal" tabindex="-1" aria-labelledby="editStatuModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form action="{{ route('ticket.update.status', $ticket->slug) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="editStatuModalLabel">Edit Status</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <label for="editStatus" class="form-label">Status</label>
                                                    <select name="status" class="form-select" id="editStatus">
                                                        <option value="opened" @selected($ticket->status == 'open')>Open</option>
                                                        <option value="answered" @selected($ticket->status == 'answered')>Answered</option>
                                                        <option value="customer-reply" @selected($ticket->status == 'customer-reply')>Customer-reply</option>
                                                        <option value="closed" @selected($ticket->status == 'closed')>Closed</option>
                                                        <option value="completed" @selected($ticket->status == 'completed')>Completed</option>
                                                    </select>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            Status: @if ( $ticket->status == 'closed')
                                    <span class="btn btn-sm btn-outline-secondary">{{ $ticket->status  }}</span>
                                @elseif( $ticket->status == 'completed')
                                    <span class="btn btn-sm btn-outline-success">{{ $ticket->status  }}</span>
                                @else
                                    {{ $ticket->status  }}
                            @endif
                        </div>
                        @if ($ticket->status !== 'closed' &&  $ticket->status !== 'completed')
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#closedModal">
                                Closed
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="closedModal" tabindex="-1" aria-labelledby="closedModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('ticket.update.closed', $ticket->slug) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="closedModalLabel">Closed</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div>
                                                    <p>
                                                    Apakah anda yakin ingin mengubah status <span class="fst-italic fw-semibold">ticket</span> menjadi <b class="text-danger">Closed</b>
                                                    </p>
                                                    <small class="fst-italic">
                                                        Anda dapat membalas tiket ini untuk membukanya kembali.
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-danger">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                        
                        @if ($ticket->status !== 'closed' &&  $ticket->status !== 'completed')
                            <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#completedModal">
                                Completed
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="completedModal" tabindex="-1" aria-labelledby="completedModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('ticket.update.completed', $ticket->slug) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="completedModalLabel">Completed</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div>
                                                    Apakah anda yakin ingin mengubah status <span class="fst-italic fw-semibold">ticket</span> menjadi <b class="text-success">Completed</b>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-success">Completed</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>

                @if (Auth::user()->roles->max('is_admin') || $ticket->progress)
                    {{-- Card Progress --}}
                    <div class="card rounded-3">
                        <div class="card-header fw-semibold">
                            <div class="d-flex justify-content-between">
                                <span><i class="bi bi-bar-chart me-1"></i> Progress </span>
                                @if (Auth::user()->roles->max('is_admin'))
                                    <a href="#edit-rogress"  data-bs-toggle="modal" data-bs-target="#editProgressModal">Edit</a>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="progress" role="progressbar" aria-valuenow="{{ $ticket->progress ?? 0 }}" aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar @if ($ticket->progress <=40)
                                    text-bg-warning
                                    @elseif ($ticket->progress <= 75)
                                    text-bg-info
                                    @elseif($ticket->progress <=99)
                                    text-bg-success
                                    @else
                                    bg-primary
                                @endif" style="width: {{ $ticket->progress }}%">{{ $ticket->progress }} %</div>
                            </div>
                        </div>

                        @if (Auth::user()->roles->max('is_admin'))
                            <!-- Modal -->
                            <div class="modal fade" id="editProgressModal" tabindex="-1" aria-labelledby="editProgressModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form action="{{ route('ticket.update.progress', $ticket->slug) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-content">
                                            <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="editProgressModalLabel">Progress Report</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="d-flex align-items-center">
                                                    <input type="range" class="form-range" min="0" max="100" value="{{ $ticket->progress }}"  oninput="updateValueRange(this.value)" name="progress">
                                                    <span id="rangeValue" class="ms-2 fw-semibold">{{ $ticket->progress }}</span><b>%</b> <!-- Tempat untuk menampilkan poin -->
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="Submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </div> {{-- END Kolom Kiri --}}

            <div class="mb-3 col-12 col-sm-9">
                <div class="card mb-3">
                    <div class="card-header fw-bold">
                        <i class="bi bi-chat-left-text me-1"></i> Ticket Message
                    </div>
                    <div class="card-body">
                        {!! $ticket->content !!}
                    </div>
                    @if (count($ticket->attachments))
                        <div class="card-footer">
                            <h6>Attachment Files</h6>
                            <ul class="ps-3">
                                @foreach ($ticket->attachments as $item)
                                    <li>
                                        <a href="{{ asset('storage/'. $item->path) }}" target="__blank">{{ $item->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>


                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="d-inline-flex gap-1">
                        @if ($ticket->status != 'completed')
                            <a class="btn btn-info" data-bs-toggle="collapse" href="#collapseReply" role="button" aria-expanded="false" aria-controls="collapseReply">
                                <i class="bi bi-chat-left-dots me-1"></i> Reply Message
                            </a>
                        @endif
                    </div>
                    <div class="fst-italic fw-semibold">
                        Balasan terbaru
                    </div>
                </div>
                    @if ($ticket->status != 'completed')
                        <div class="collapse" id="collapseReply">
                            <div class="card">
                                <div class="card-header">
                                    <span class="fw-bold">
                                        <i class="bi bi-chat-left-dots me-1"></i> Reply Ticket
                                    </span>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('comment.store', $ticket->slug) }}" method="post" enctype="multipart/form-data">
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
                                                Format file yang diperbolehkan: .jpg, .jpeg, .png, .pdf (Max file size: 5MB)
                                            </div>
                                            <button class="btn btn-sm btn-success" type="button" id="add_more_attachment">
                                                <i class="bi bi-plus-lg me-1"></i> Add more
                                            </button>
                                            <button class="btn btn-sm btn-danger" type="button" id="remove_attachment">
                                                <i class="bi bi-dash me-1"></i> Remove
                                            </button>
                                        </div>
                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-sm btn-primary">
                                                <i class="bi bi-send me-1"></i> Send Reply
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                
                <hr>

                @empty(count($comments))
                <div class="alert alert-warning text-center" role="alert">
                    No reply available.
                </div>
                @endempty

                @foreach ($comments as $comment)
                    <div class="card rounded-3 mb-3">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <div class="img-user">
                                    <img class="rounded-circle header-profile-user" src="@if(isset(Auth::user()->image)) {{ asset('storage/'.Auth::user()->image) }} @else {{ asset('assets/images/no-image.webp')  }} @endif" alt="{{ Auth::user()->name }}">
                                </div>
                                <div class="">
                                    <div>{{ $comment->user->name }}</div>
                                    @if ($ticket->user_id == $comment->user->id)
                                        <div class="badge bg-success">Owner</div>
                                        @else
                                        @if ($comment->user->roles->max('level') == 2)
                                            <div class="badge text-bg-warning">Staff</div>
                                            @else
                                            <div class="badge text-bg-danger">Administrator</div>
                                            
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="small text-secondary">
                                2024-08-24 11:35:30
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="reply-content">
                                {!! $comment->content !!}
                            </div>
                            @if(count($comment->attachments))
                            <hr>
                            <div class="reply-attachment">
                                <span class="fw-semibold">Attactment Files:</span>
                                <ul>
                                    @foreach ($comment->attachments as $attachment)
                                        <li class="small">
                                            <a href="{{ asset('storage/'.$attachment->path) }}" class="link-success" target="__blank">
                                                {{ $attachment->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </div>
                    </div>
                @endforeach

                <!-- Pagination Links -->
                <div class="d-flex align-items-center flex-row-reverse">
                    {{ $comments->onEachSide(0)->links('vendor.paginate') }}
                </div>

                {{-- Card reply message 1 --}}
                
            </div>
        </div>
        <!-- end page main -->
@endsection

@push('scripts')
    <script>
        function updateValueRange(value) {
            document.getElementById('rangeValue').innerText = value;
        }

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