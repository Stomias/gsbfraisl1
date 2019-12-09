@extends('layouts.master')
@section('content')
{!! Form::open(['url' => 'ajoutUser']) !!}  
<div class="col-md-12 well well-md">
    <h2>Modification de mes informations personnelles</h2>
    <div class="form-horizontal">    

        <div class="form-group">
            <label class="col-md-3 control-label">Nom : </label>
            <div class="col-md-6 col-md-3">
                <input type="text" name="nom" ng-model="nom" class="form-control" placeholder="Nom utilisateur" maxlength="30" required>
                @if($errors->has('nom'))
                <div class="alert alert-danger">
                    {{ $errors->first('nom') }}
                </div>
                @endif
            </div>  
        </div>  
        <div class="form-group">
            <label class="col-md-3 control-label">Prénom : </label>
            <div class="col-md-6 col-md-3">
                <input type="text" name="prenom" ng-model="prenom" class="form-control" placeholder="Préom utilisateur" maxlength="30"  required>
                @if($errors->has('nom'))
                <div class="alert alert-danger">
                    {{ $errors->first('nom') }}
                </div>
                @endif
            </div>  
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Mot de passe : </label>
            <div class="col-md-6 col-md-3">
                <input type="password" name="password" ng-model="password" class="form-control" placeholder="Mot de passe utilisateur" maxlength="30"  required>
                @if($errors->has('password'))
                <div class="alert alert-danger">
                    {{ $errors->first('password') }}
                </div>
                @endif
            </div>  
        </div>
        
        <div class="form-group">
            <label class="col-md-3 control-label">code postal : </label>
            <div class="col-md-6 col-md-3">
                 <input type="text" name="cp" ng-model="cp" class="form-control" placeholder="Votre code postal" size ="5"  required> 
                 @if($errors->has('cp'))
                 <div class="alert alert-danger">
                     {{ $errors->first('cp') }}
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

