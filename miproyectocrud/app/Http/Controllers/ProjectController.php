<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
/**
* Display a listing of the resource.
*/
public function index()
{
$projects = Project::get();
return view('projects.index',['projects' => $projects]);
}
/**
* Show the form for creating a new resource.
*/
public function create()
{
return view('projects.create');
}
/**
* Store a newly created resource in storage.
*/
public function store(Request $request)
{
request()->validate([
'name' => 'required|max:255',
'description' => 'required',
'titulo' => 'required|max:255',
]);
$project = new Project();
$project->name = $request->name;
$project->description = $request->description;
$project->titulo = $request->titulo;
$project->save();
return redirect()->route('projects.index')
->with('success','Project saved successfully!');
}
/**
* Display the specified resource.
*/
public function show(string $id)
{
$project = Project::find($id);
return view('projects.show', ['project' => $project]);
}
/**
* Show the form for editing the specified resource.
*/
public function edit(string $id)
{
$project = Project::find($id);
return view('projects.edit', ['project' => $project]);
}
/**
* Update the specified resource in storage.
*/
public function update(Request $request, string $id)
{
    $request->validate([
        'name' => 'required|max:255',
        'description' => 'required',
        'titulo' => 'required|max:255',
    ]);

    $project = Project::find($id);
    $project->name = $request->name;
    $project->description = $request->description;
    $project->titulo = $request->titulo;
    $project->save();

    return redirect()->route('projects.index')
        ->with('success','Project updated successfully!');
}
/**
* Remove the specified resource from storage.
*/
public function destroy(string $id)
{
Project::destroy($id);
return redirect()->route('projects.index')
->with('success','Project deleted successfully!');
}
}