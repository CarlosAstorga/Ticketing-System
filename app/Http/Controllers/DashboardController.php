<?php

namespace App\Http\Controllers;

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
        return User::withCount([
            'submittedTickets as open'      => function ($query) {
                $query->where('status_id', 1);
            },
            'submittedTickets as solving'   => function ($query) {
                $query->where('status_id', 2);
            },
            'submittedTickets as pending'   => function ($query) {
                $query->where('status_id', 3);
            },
            'submittedTickets as solved'    => function ($query) {
                $query->where('status_id', 4);
            },
            'submittedTickets as closed'    => function ($query) {
                $query->where('status_id', 5);
            },
            'submittedTickets as tickets_count'
        ])->with(['submittedTickets'        => function ($query){
                $query->orderBy('id', 'DESC')->limit(6);
        }])->find(auth()->user()->id);
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
