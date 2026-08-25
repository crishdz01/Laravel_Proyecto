@extends('projects.layout')
@section('content')
<div class="container">
<h2 class="text-center mt-5 mb-3">Show Project</h2>
<div class="card">
<div class="card-header">
<a class="btn btn-outline-info float-right" href="{{ route('projects.index') }}">
View All Projects
</a>
</div>
<div class="card-body">
<b class="text-muted">Name:</b>
<p>{{$project->name}}</p>
<b class="text-muted">Description:</b>
<p>{{$project->description}}</p>
<b class="text-muted">Titulo:</b>
<p>{{$project->titulo}}</p>
</div>
</div>
</div>
@endsection