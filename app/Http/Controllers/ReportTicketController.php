<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReportTicketRequest;
use App\Models\Role;
use App\Models\Ticket;
use Illuminate\Http\Request;

class ReportTicketController extends Controller
{

    protected $ticket, $role;

    public function __construct(Ticket $ticket, Role $role)
    {
        $this->ticket = $ticket;
        $this->role = $role;
    }

    public function index()
    {
        $roles = $this->role->get();
        return view('reports.index', compact('roles'));
    }

    public function show(ReportTicketRequest $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $status = $request->status;
        $role = $request->role;

        $report = $this->ticket->with(['user'])
            ->whereDate('created_at', '>=' , $request->start_date)
            ->whereDate('created_at', '<=' , $request->end_date);
        
        if($status != 'semua'){
            $report->where('status', $request->status);
        }

        if($role  != 'semua'){
            $report->whereHas('user', function($query) use ($role){
                $query->whereHas('roles', function($query) use ($role){
                    $query->where('id', $role);
                });
            });
        }
        $reports = $report->get();
        
        return view('reports.show', compact('reports', 'start_date', 'end_date', 'status', 'role'));
    }
}
