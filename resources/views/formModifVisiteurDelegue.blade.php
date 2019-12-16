@extends('layouts.master')
@section('content')
{!! Form::open(['url' => '/voirDetailVisiteurDelegue/{id}']) !!}  
<div class="col-md-12 well well-md">
    <h2>Informations personnelles de {{ $detailsVisiteur->nom}} {{ $detailsVisiteur->prenom }} </h2>
    <div class="form-horizontal">    
        <div class="form-group">
            <label class="col-md-3 control-label">Identifiant : </label>
            <div class="col-md-6 col-md-3">
                <input type="text" readonly name="id" ng-model="id" class="form-control" placeholder="Votre identifiant" maxlength="30" value="{{ $detailsVisiteur->id }}" required>
                @if($errors->has('region'))
                <div class="alert alert-danger">
                    {{ $errors->first('region') }}
                </div>
                @endif
            </div>  
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Région : </label>
            <div class="col-md-6 col-md-3">
            <select name="reg" ng-model="reg" class="form-control">
                    @foreach ($regions as $region)
                        <option @if($detailsVisiteur->reg_nom == $region->reg_nom ) selected @endif value="{{ $region->id }}">{{ $region->reg_nom }}</option>
                    @endforeach
                 </select>
                @if($errors->has('region'))
                <div class="alert alert-danger">
                    {{ $errors->first('region') }}
                </div>
                @endif
            </div>  
        </div> 
        <div class="form-group">
            <label class="col-md-3 control-label">Rôle : </label>
            <div class="col-md-6 col-md-3">
                 <select name="role" ng-model="role" class="form-control">
                    <option @if($detailsVisiteur->tra_role == 'Visiteur') selected @endif  value="Visiteur">Visiteur</option>
                    <option @if($detailsVisiteur->tra_role == 'Délégué') selected @endif  value="Délégué">Délégué</option>
                 </select>
                 @if($errors->has('role'))
                 <div class="alert alert-danger">
                     {{ $errors->first('role') }}
                 </div>
                  @endif
                 </div> 
        </div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
                <button type="submit" class="btn btn-default btn-primary"><span class="glyphicon glyphicon-log-in"></span> Valider</button>
            </div>
        </div>
  @if (session('erreur'))
        <div class="alert alert-danger">
         {{ session('erreur') }}
        </div>
  @endif
    </div>
</div>
{!! Form::close() !!}
@stop

