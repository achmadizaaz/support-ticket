<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\CommentAttachment;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    protected $model, $attachment, $ticket;

    public function __construct(Comment $model, CommentAttachment $attachment, Ticket $ticket)
    {
        $this->model = $model;
        $this->attachment = $attachment;
        $this->ticket = $ticket;
    }

    public function store(Request $request, $no_ticket)
    {
        $ticket = $this->ticket->where('no', $no_ticket)->first();

        // Update status
        if(Auth::user()->id == $ticket->user_id){
            $ticket->update(['status' => 'customer-reply']);
        }else{
            $ticket->update(['status' => 'answered']);
        }

        $comment = $this->model->create([
                    'ticket_id' => $ticket->id,
                    'user_id' => Auth::user()->id,
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

        return to_route('ticket.show', $no_ticket)->with('success', 'Reply ticket berhasil ditambahkan!');
    }
}
