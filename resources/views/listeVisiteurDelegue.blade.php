@extends('layouts.master')
@section('content')
<div class="container">
    <div class="col-md-5">
        <div class="blanc">
            <h2>{{$titreVue or ''}}</h2>
        </div>
        <table class="table table-bordered table-striped table-responsive">
            <thead>
                <tr>
                    <th style="width:20%">Nom</th> 
                    <th style="width:20%">Prénom</th> 
                    <th style="width:20%">Rôle</th> 
                    <th style="width:20%">Région</th> 
                    <th style="width:20%">Détails</th>
                </tr>
            </thead>
            @foreach($mesVisiteurDelegue as $unVisiteurDelegue)
            <tr>   
                <td> {{ $unVisiteurDelegue->nom }} </td>
                <td> {{ $unVisiteurDelegue->prenom }} </td>
                <td> {{ $unVisiteurDelegue->aff_role }}</td>
                <td> {{ $unVisiteurDelegue->reg_nom }}</td>
                <td style="text-align:center;"><a href="{{ url('/voirDetailVisiteurDelegue') }}/{{ $unVisiteurDelegue->id }}">
                    <span class="glyphicon glyphicon-eye-open" data-toggle="tooltip" data-placement="top" title="Voir"></span></a>
                </td>
            </tr>
            @endforeach
        </table>
    @if (session('erreur'))
        <div class="alert alert-danger">
         {{ session('erreur') }}
        </div>
    @endif
    </div>
</div>
@stop
