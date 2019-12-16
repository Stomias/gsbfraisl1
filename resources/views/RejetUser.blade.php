@extends('layouts.master')
@section('content')
<div class="col-md-12 well well-md">
    <h2>Ajout utilisateur</h2>
    <div class="alert alert-danger">
        L'utilisateur existe déjà! Veuillez réessayer.
    </div>
</div>
{!! Form::close() !!}
@stop