<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Ticket;
use App\Models\Status;
use App\Models\Project;
use App\Models\Priority;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(Gate::allows('ticket_access'), 403, 'Acción no autorizada');
        return view('tickets.index', ['module' => 'tickets']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(Gate::allows('ticket_create'), 403, 'Acción no autorizada');
        return view('tickets.form', [
            'module'    => 'tickets',
            'ticket'    => new Ticket(),
            'catalogs'  => $this->catalogs()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort_unless(Gate::allows('ticket_create'), 403, 'Acción no autorizada');
        Ticket::create($this->validateRequest($request));
        return redirect('tickets');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        abort_unless(Gate::allows('ticket_show'), 403, 'Acción no autorizada');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        abort_unless(Gate::allows('ticket_edit'), 403, 'Acción no autorizada');
        return view('tickets.form', [
            'module'    => 'tickets',
            'ticket'    => $ticket,
            'catalogs'  => $this->catalogs()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {
        abort_unless(Gate::allows('ticket_edit'), 403, 'Acción no autorizada');
        $ticket->update($this->validateRequest($request));
        return redirect('tickets');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        abort_unless(Gate::allows('ticket_delete'), 403, 'Acción no autorizada');
        $ticket->delete();
    }

    public function list(Request $request)
    {
        $filter = $request->input('filter', null);
        $tickets = Ticket::query();

        if (Gate::denies('user_assigment')) {
            $tickets = Ticket::where(function ($query) use ($request) {
                $query->where('submitter_id', $request->user()->id)
                    ->orWhere('developer_id', $request->user()->id);
            });
        }

        $tickets->filtered($filter)->orderBy('id', 'DESC');
        $paginator = $tickets->paginate(10)->toJson();
        return $paginator;
    }

    public function ticketsByProject(Request $request)
    {
        $project    = explode('/', $request->path())[1];
        $filter     = $request->input('filter', null);
        $tickets    = Ticket::where('project_id', $project)->filtered($filter)->orderBy('id', 'DESC');
        $paginator  = $tickets->paginate(10);
        return $paginator;
    }

    public function catalogs()
    {
        if (Gate::allows('user_assigment')) {
            $users = User::whereHas('roles', function ($query) {
                $query->whereHas('permissions', function ($query) {
                    $query->where('title', '=', 'ticket_resolve');
                });
            })->get();
            $status = Gate::allows('ticket_close') ?
                Status::get() : Status::where('id', '<', 4)->get();

            $catalogs['user']       = $users;
            $catalogs['status']     = $status;
            $catalogs['project']    = Project::get();
            $catalogs['priority']   = Priority::get();
        }
        $catalogs['category']       = Category::get();
        return $catalogs;
    }

    public function validateRequest($request)
    {
        $rules = [
            'title'          => 'required|max:100',
            'description'    => 'required|max:150',
            'category_id'    => 'required|exists:App\Models\Category,id'
        ];
        $request->due_date      ? $rules['due_date']    = 'date_format:Y-m-d|after:yesterday'       : null;
        $request->project_id    ? $rules['project_id']  = 'exists:App\Models\Project,id'            : null;

        if (Gate::allows('user_assigment')) {
            $rules['developer_id']  = 'required|exists:App\Models\User,id';
            $rules['priority_id']   = 'required|exists:App\Models\Priority,id';
        }

        if (Gate::allows('ticket_close') || Gate::allows('ticket_resolve')) {
            $rules['status_id']     = 'required|exists:App\Models\Status,id';
        }

        $validatedData = $request->validate($rules);
        $validatedData['submitter_id'] = $request->user()->id;
        return $validatedData;
    }
}
