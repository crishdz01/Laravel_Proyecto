@extends('projects.layout')
@section('content')
<div class="container">
<h2 class="text-center mt-5 mb-3">Edit Project</h2>
<div class="card">
<div class="card-header">
<a class="btn btn-outline-info float-right" href="{{ route('projects.index') }}">
View All Projects
</a>
</div>
<div class="card-body">
@if ($errors->any())
<div class="alert alert-danger">
<ul>
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif
<form action="{{ route('projects.update',$project->id) }}" method="POST">
@csrf
@method('PUT')
<div class="form-group">
<label for="name">Name</label>
<input type="text" class="form-control" id="name" name="name" value="{{ $project->name }}">
</div>
<div class="form-group">
    <label for="description">Description</label>
    <textarea class="form-control" id="description" rows="3" name="description">{{ $project->description }}</textarea>
</div>

<div class="form-group">
    <label for="titulo">Titulo</label>
    <input type="text" class="form-control" id="titulo" name="titulo" value="{{ $project->titulo }}">
</div>
<button type="submit" class="btn btn-outline-success mt-3">Save Project</button>
</form>
</div>
</div>
</div>
@endsection