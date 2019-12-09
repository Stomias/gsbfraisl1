@extends('layouts.master')
@section('content')
<div class="col-md-12 well well-md">
    <h2>Ajout utilisateur</h2>
    <div class="alert alert-success">
        Votre utilisateur a été ajouté.
    </div>
</div>
{!! Form::close() !!}
@stop