<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_unless(Gate::allows('project_access'), 403, 'Acción no autorizada');
        return view('projects.index', ['module' => 'projects']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_unless(Gate::allows('project_create'), 403, 'Acción no autorizada');
        return view('projects.form', [
            'module'        => 'projects',
            'project'       => new Project()
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
        abort_unless(Gate::allows('project_create'), 403, 'Acción no autorizada');
        Project::create($request->validate([
            'title'         => 'required|max:100',
            'description'   => 'required|max:150',
        ]));
        return redirect('projects');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        abort_unless(Gate::allows('project_show'), 403, 'Acción no autorizada');
        return view('projects.project', [
            'module'        => 'projects',
            'project'       => $project
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        abort_unless(Gate::allows('project_edit'), 403, 'Acción no autorizada');
        return view('projects.form', [
            'module'        => 'projects',
            'project'       => $project
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        abort_unless(Gate::allows('project_edit'), 403, 'Acción no autorizada');
        $project->update($request->validate([
            'title'         => 'required|max:100',
            'description'   => 'required|max:150',
        ]));
        return redirect('projects');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        abort_unless(Gate::allows('project_delete'), 403, 'Acción no autorizada');
        $project->tickets()->update(['project_id' => null]);
        $project->delete();
    }

    public function list(Request $request)
    {
        $filter = $request->input('filter', null);

        $projects = Project::query();
        $projects = $filter ?
            $projects->where(function ($query) use ($filter) {
                $query->where('title', 'LIKE', '%' . $filter . '%')
                    ->orWhere('description', 'LIKE', '%' . $filter . '%');
            }) : $projects;

        $projects = $projects->orderBy('id', 'DESC');
        $paginator = $projects->paginate(10);
        return $paginator;
    }
}
