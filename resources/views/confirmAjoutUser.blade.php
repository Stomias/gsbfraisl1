@extends('layouts.master')
@section('content')
<@php
    
    $mdp = Session::get('mdp');
    $login = Session::get('login');
@endphp
<div class="col-md-12 well well-md">
    <h2>Ajout utilisateur</h2>
    <div class="alert alert-success">
        Votre utilisateur a été ajouté.
    </div>
    @php
        echo "<h3>Son login: " .$login ."</h3>";
        echo "<h3>Son mot de passe: " .$mdp ."</h3>";
    @endphp
    <a href="{{ url('/') }}" class="btn btn-default btn-danger">Retour a l'accueil</a>
</div>
{!! Form::close() !!}
@stop