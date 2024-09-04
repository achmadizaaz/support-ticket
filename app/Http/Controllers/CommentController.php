<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\CommentAttachment;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\TicketNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class CommentController extends Controller
{
    protected $model, $attachment, $ticket, $currentUser, $user;

    public function __construct(Comment $model, CommentAttachment $attachment, Ticket $ticket, User $user)
    {
        $this->model = $model;
        $this->attachment = $attachment;
        $this->ticket = $ticket;
        $this->user = $user;
        $this->currentUser = Auth::user();
    }

    public function store(Request $request, $slug_ticket)
    {
        $ticket = $this->ticket->where('slug', $slug_ticket)->first();

        // Update status
        if($this->currentUser->id == $ticket->user_id){
            $ticket->update(['status' => 'customer-reply']);
            // Send notifikasi to admin
            // Mendapatkan user admin
            $users = $this->user->whereHas('roles', function ($query) {
                $query->where('is_admin', 1);
            })->get();
            Notification::send($users, new TicketNotification($ticket->no, Str::of($request->content)->words(10, '...')));

        }else{
            $ticket->update(['status' => 'answered']);
            // Send notifikasi to owner ticket
            // Mendapatkan user owner ticket
            Notification::send($ticket->user, new TicketNotification($ticket->no, Str::of($request->content)->words(10, '...')));
        }

        $comment = $this->model->create([
                    'ticket_id' => $ticket->id,
                    'user_id' => $this->currentUser->id,
                    'content' => $request->content,
                ]);

        // Jika terdapat upload file attachment            
        if($request->attachment){
            $resultAttachment = [];
            $i = 0;
            foreach($request->attachment as $attachment){
                // dd($attachment->getClientOriginalName());
                $filenameWithExt = $attachment->getClientOriginalName();
                $fileNameToStore = time().'-'.$filenameWithExt;
                $path = $attachment->storeAs('ticket/files/comments', $fileNameToStore, 'public');
                $resultAttachment[$i]['path'] = $path;
                $resultAttachment[$i]['name'] = $filenameWithExt;
                $resultAttachment[$i]['comment_id'] = $comment->id;
                $i++;
            }
            $this->attachment->insert($resultAttachment);
        }

        return to_route('ticket.show', $slug_ticket)->with('success', 'Reply ticket berhasil ditambahkan!');
    }
}
