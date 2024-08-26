<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketRequest;
use App\Models\Attachment;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TicketController extends Controller
{
    protected $model, $comment, $category, $attachment;

    public function __construct(Ticket $model, Comment $comment, Category $category, Attachment $attachment)
    {
        $this->model = $model;
        $this->comment = $comment;
        $this->category = $category;
        $this->attachment = $attachment;
    }

    public function index()
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
                'user_id' => Auth::user()->id,
                'category_id' => $request->category,
                'no' => $no,
                'subject'  => $request->subject,
                'content'  => $request->content,
                'created_by' => Auth::user()->username,
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
            
            DB::commit();

            return to_route('ticket');
        }catch(\Exception $exception){
            DB::rollBack();
            // Menyimpan log kegagalan sistem
            Log::error($exception->getMessage());
            return back()->withInput($request->all())->with('failed', 'A system error occurred, please try later');
        }
    }

    public function show($no)
    {
        $ticket = $this->model->where('no', $no)->first();
        $comments = $this->comment->with(['user', 'attachments'])->where('ticket_id', $ticket->id)->latest()->paginate(5);
        return view('tickets.show', compact('ticket', 'comments'));
    }
}
