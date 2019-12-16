@extends('layouts.master')
@section('content')
{!! Form::open(['url' => 'ajoutUser']) !!}  
<div class="col-md-12 well well-md">
    <h2>Ajouter un utilisateur</h2>
    <div class="form-horizontal">   
        <i>Pour ajouter un nouvel utilisateur, veuillez remplir tous les champs ci-dessous</i><br><br> 
        <div class="form-group">
            <label class="col-md-3 control-label">Id : </label>
            <div class="col-md-6 col-md-3">
                <input type="text" name="id" ng-model="id" class="form-control" placeholder="Id utilisateur" maxlength="4" required>
                @if($errors->has('id'))
                <div class="alert alert-danger">
                    {{ $errors->first('id') }}
                </div>
                @endif
            </div>  
        </div>  
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
                <input type="text" name="prenom" ng-model="prenom" class="form-control" placeholder="Prénom utilisateur" maxlength="30"  required>
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
                <input type="password" name="password" ng-model="password" class="form-control" placeholder="Mot de passe utilisateur" readonly
                 maxlength="8"  required value = {{$mdp}}> 
                @if($errors->has('password'))
                <div class="alert alert-danger">
                    {{ $errors->first('password') }}
                </div>
                @endif
            </div>  
            <label class="col-md-3 control-label" style="color:red">*ne peut être modifié</label>
        </div>
        
        <div class="form-group">
            <label class="col-md-3 control-label">Code postal : </label>
            <div class="col-md-6 col-md-3">
                 <input type="text" name="cp" ng-model="cp" class="form-control" placeholder="Code postal utilisateur" size ="5"  required> 
                 @if($errors->has('cp'))
                 <div class="alert alert-danger">
                     {{ $errors->first('cp') }}
                 </div>
                  @endif
                 </div> 
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Adresse : </label>
            <div class="col-md-6 col-md-3">
                <input type="text" name="adresse" ng-model="adresse" class="form-control" placeholder="Votre adresse" maxlength="30" required>
                @if($errors->has('adresse'))
                <div class="alert alert-danger">
                    {{ $errors->first('adresse') }}
                </div>
                @endif
            </div>  
        </div>  
        <div class="form-group">
            <label class="col-md-3 control-label">Ville : </label>
            <div class="col-md-6 col-md-3">
                <input type="text" name="ville" ng-model="ville" class="form-control" placeholder="Votre ville" maxlength="30" pattern ="^[a-zéèàêâùïüëA-Z][a-zéèàêâùïüëA-Z-'\s]{1,29}$" required>
                @if($errors->has('ville'))
                <div class="alert alert-danger">
                    {{ $errors->first('ville') }}
                </div>
                @endif
            </div>  
        </div>   
        <div class="form-group">
            <label class="col-md-3 control-label">Tel : </label>
            <div class="col-md-6 col-md-3">
                <input type="text" name="tel" ng-model="tel" class="form-control" placeholder="Votre numero de telephone" maxlength="15" pattern="^(?:0|\(?\+33\)?\s?|0033\s?)[1-79](?:[\.\-\s]?\d\d){4}$" required>
                @if($errors->has('tel'))
                <div class="alert alert-danger">
                    {{ $errors->first('tel') }}
                </div>
                @endif
            </div>  
        </div>   
        <div class="form-group">
            <label class="col-md-3 control-label">Email : </label>
            <div class="col-md-6 col-md-3">
                <input type="email" name="email" ng-model="email" class="form-control" placeholder="Votre email" maxlength="30" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                @if($errors->has('email'))
                <div class="alert alert-danger">
                    {{ $errors->first('email') }}
                </div>
                @endif
            </div>  
        </div>    
        <div class="form-group">
            <label class="col-md-3 control-label">Date d'embauche : </label>
            <div class="col-md-6 col-md-3">
                <input type="date" name="embauche" ng-model="embauche" class="form-control" placeholder="Date embauche utilisateur" maxlength="30"   required>
                @if($errors->has('email'))
                <div class="alert alert-danger">
                    {{ $errors->first('email') }}
                </div>
                @endif
            </div>  
        </div>    
        <div class="form-group">
                <label class="col-md-3 control-label">Role utilisateur: </label>
                <div class="col-md-6 col-md-3">
                    <select class="browser-default"  name="role" size="1">
                            <option value="" disabled selected>Choisir un role</option>
                            <option value="Visiteur" selected>Visiteur</option>
                            <option value="Délégué">Délégué</option>
                            
                    </select>
            </div>  
        </div> 
        <div class="form-group">
                <label class="col-md-3 control-label">Région de travail: </label>
                <div class="col-md-6 col-md-3">
                    <select class="browser-default"  name="reg" size="1">
                            <option value="" disabled selected>Choisir un lieu  </option>

                            @foreach ($regions as $region)
                                <option selected value='{{$region->id}}'>{{$region->id}} </option>
                            @endforeach
                
                    </select>
            </div>  
        </div> 
        
        
        <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
                <button type="submit" class="btn btn-default btn-primary"><span class="glyphicon glyphicon-log-in"></span> Valider</button>
                <a href="{{ url('/') }}" class="btn btn-default btn-danger">retour</a>
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

