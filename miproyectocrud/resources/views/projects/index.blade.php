@extends('projects.layout')
@section('content')
<div class="container">
<h2 class="text-center mt-5 mb-3">Laravel Project Manager</h2>
<div class="card">
<div class="card-header">
<a class="btn btn-outline-primary" href="{{ route('projects.create') }}">
Create New Project
</a>
</div>
<div class="card-body">
@if ($message = Session::get('success'))
<div class="alert alert-success">
<b>{{ $message }}</b>
</div>
@endif
<table class="table table-bordered">
<tr>
<th>Name</th>
<th>Description</th>
<th>Titulo</th>
<th width="240px">Action</th>

</tr>
@foreach ($projects as $project)
<tr>
<td>{{ $project->name }}</td>
<td>{{ $project->description }}</td>
<td>{{ $project->titulo }}</td>
<td>
<form action="{{ route('projects.destroy',$project->id) }}" method="POST">
<a
class="btn btn-outline-info"
href="{{ route('projects.show',$project->id) }}">
Show
</a>
<a
class="btn btn-outline-success"
href="{{ route('projects.edit',$project->id) }}">
Edit
</a>
@csrf
@method('DELETE')
<button type="submit" class="btn btn-outline-danger">Delete</button>
</form>
</td>
</tr>
@endforeach
</table>
</div>
</div>
</div>
@endsection