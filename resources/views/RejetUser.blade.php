@extends('layouts.master')
@section('content')
<div class="col-md-12 well well-md">
    <h2>Ajout utilisateur</h2>
    <div class="alert alert-danger">
        L'utilisateur existe déjà! Veuillez réessayer.
    </div>
    
    <a href="{{ url('/ajoutUser') }}" class="btn btn-default btn-danger">retour</a>
        
</div>
{!! Form::close() !!}
@stop