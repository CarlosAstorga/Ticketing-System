<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard', ['module'  => 'dashboard', 'tickets' => $this->tickets()]);
    }

    public function tickets()
    {
        $tickets = DB::table('tickets')->select(DB::raw('count(*) as total, status_id'));

        if (Gate::denies('user_assigment')) {
            $tickets = $tickets->where(function ($query) {
                $query->where('submitter_id', auth()->user()->id)
                    ->orWhere('developer_id', auth()->user()->id);
            });
        }

        $tickets = $tickets->groupBy('status_id')->get();
        $plucked = $tickets->pluck('total', 'status_id');
        return $plucked;
    }

    public function chart(Request $request) {
        $tickets = DB::table('tickets');

        if (Gate::denies('user_assigment')) {
            $tickets = $tickets->where(function ($query) use ($request) {
                $query->where('submitter_id', $request->user()->id)
                    ->orWhere('developer_id', $request->user()->id);
            });
        }

        $tickets = $tickets->select(DB::raw('count(*) as tickets_count, month(created_at) as m'))
        ->groupBy('m')
        ->get();

        return $tickets;
    }
}
