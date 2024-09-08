<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Jobs\CustomerReplyTicketNoticationJob;
use App\Jobs\TicketNoticationJob;
use App\Models\Comment;
use App\Models\CommentAttachment;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\CustomerReplyTicketNotication;
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

    public function store(CommentRequest $request, $slug_ticket)
    {
        $ticket = $this->ticket->where('slug', $slug_ticket)->first();

        // Update status
        if($this->currentUser->id == $ticket->user_id){
            $ticket->update(['status' => 'customer-reply']);
            // Send notifikasi to admin by category
            // Mendapatkan user admin by category
            $users = $this->user->whereHas('notif', function ($query) use ($ticket) {
                $query->where('category_id', $ticket->category_id);
            })->get();
            if(count($users)){
                $detail = [
                    'user' => $ticket->user->name,
                    'no_ticket' => $ticket->no,
                    'subject' => $ticket->subject,
                    'message' => $request->content,
                ];
                foreach($users as $user){
                    dispatch(new CustomerReplyTicketNoticationJob($user, $detail));
                }
                    
                // Notification::send($users, new TicketNotification($ticket->no, Str::of($request->content)->words(10, '...'), route('ticket.show',$ticket->slug)));
            }

        }else{
            // Jika admin melakukan reply ticket
            // Send notifikasi ke customer
            $ticket->update(['status' => 'answered']);
            dispatch(new TicketNoticationJob($ticket->user, $ticket, Str::of($request->content)->words(10, '...') ));
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
