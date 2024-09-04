<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketRequest;
use App\Models\Attachment;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\TicketNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class TicketController extends Controller
{
    protected $model, $comment, $category, $attachment, $user, $currentUser;

    public function __construct(Ticket $model, Comment $comment, Category $category, Attachment $attachment, User $user)
    {
        $this->model = $model;
        $this->comment = $comment;
        $this->category = $category;
        $this->attachment = $attachment;

        $this->user = $user;
        $this->currentUser = Auth::user();
    }

    public function index()
    {
        $tickets = $this->model->with(['user', 'category'])->where('user_id', $this->currentUser->id)->latest()->paginate(10);

        return view('tickets.index', compact('tickets'));
    }
    
    public function all()
    {
        $tickets = $this->model->with(['user', 'category'])->latest()->paginate(10);

        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        $categories = $this->category->all();
        return view('tickets.create', compact('categories'));
    }

    public function store(TicketRequest $request)
    {
        
        try{
            DB::beginTransaction();
            // Mendapatkan tanggal dan waktu saat ini
            $now = Carbon::now();
            // Format tanggal menjadi YYYYMMDD
            $formattedDate = $now->format('Ymd');

            $no = $formattedDate.rand(1000, 9999);            
            // Menambahkan data ke database
            $ticket = $this->model->create([
                'user_id' => $this->currentUser->id,
                'category_id' => $request->category,
                'slug' => md5($no),
                'no' => $no,
                'subject'  => $request->subject,
                'content'  => $request->content,
                'created_by' => $this->currentUser->username,
            ]);

            // Jika terdapat upload file attachment            
            if($request->attachment){
                $resultAttachment = [];
                $i = 0;
                foreach($request->attachment as $attachment){
                    // dd($attachment->getClientOriginalName());
                    $filenameWithExt = $attachment->getClientOriginalName();
                    $fileNameToStore = time().'-'.$filenameWithExt;
                    $path = $attachment->storeAs('ticket/files', $fileNameToStore, 'public');
                    $resultAttachment[$i]['path'] = $path;
                    $resultAttachment[$i]['name'] = $filenameWithExt;
                    $resultAttachment[$i]['ticket_id'] = $ticket->id;
                    $i++;
                }
                $this->attachment->insert($resultAttachment);
            }

            // Send notifikasi to admin
            // Mendapatkan user admin
            $users = $this->user->whereHas('roles', function ($query) {
                $query->where('is_admin', 1);
            })->get();
            Notification::send($users, new TicketNotification($ticket->no, $ticket->subject));

            DB::commit();

            return to_route('ticket')->with('success', 'Ticket berhasil dibuat!');
        }catch(\Exception $exception){
            DB::rollBack();
            // Menyimpan log kegagalan sistem
            Log::error($exception->getMessage());
            return back()->withInput($request->all())->with('failed', 'A system error occurred, please try later');
        }
    }

    public function show($slug)
    {
        $ticket = $this->model->where('slug', $slug)->first();
        $comments = $this->comment->with(['user', 'attachments'])->where('ticket_id', $ticket->id)->latest()->paginate(5);
        return view('tickets.show', compact('ticket', 'comments'));
    }

    public function update(TicketRequest $request, $no)
    {
        $ticket = $this->model->where('no', $no)->first();
        $ticket->update([
            'progress' => $request->progress,
            'status' => $request->status,
        ]);
        return back()->with('success', 'Ticket berhasil diperbarui!');
    }

    public function destroy($slug)
    {
        $ticket = $this->model->where('slug', $slug)->first();
        $ticket->delete();

        return back()->with('success', 'Ticket berhasil dihapus!');
    }

    public function status(Request $request, $slug)
    {
        $ticket = $this->model->where('slug', $slug)->first();
        $ticket->update([
            'status' => $request->status,
        ]);
        
        return back()->with('success', 'Ticket berhasil diperbarui!');
    }
    
    public function completed(Request $request, $slug)
    {
        $ticket = $this->model->where('slug', $slug)->first();
        $ticket->update([
            'status' => 'completed',
        ]);
        return back()->with('success', 'Ticket berhasil diperbarui!');
    }
    
    public function closed(Request $request, $slug)
    {
        $ticket = $this->model->where('slug', $slug)->first();
        $ticket->update([
            'status' => 'closed',
        ]);
        return back()->with('success', 'Ticket berhasil diperbarui!');
    }
    public function progress(Request $request, $slug)
    {
        $ticket = $this->model->where('slug', $slug)->first();
        $ticket->update([
            'progress' => $request->progress,
        ]);
        return back()->with('success', 'Ticket berhasil diperbarui!');
    }

    public function notif($title, $message, $status)
    {
        $notif = [
            'title' => $title,
            'message' => $message,
            'status' => $status
        ];

        return $notif;
    }
}
