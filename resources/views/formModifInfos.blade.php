@extends('layouts.master')
@section('content')
{!! Form::open(['url' => 'modifInfos']) !!}  
<div class="col-md-12 well well-md">
    <h2>Modification de mes informations personnelles</h2>
    <div class="form-horizontal">    
        <i>Vous pouvez modifier vos informations personnelles ici</i><br><br> 
        <div class="form-group">
            <label class="col-md-3 control-label">Adresse : </label>
            <div class="col-md-6 col-md-3">
                <input type="text" name="adresse" ng-model="adresse" class="form-control" placeholder="Votre adresse" maxlength="30" value="{{isset($errors) && count($errors) > 0 ? old('adresse'): $info->adresse}}" required>
                @if($errors->has('adresse'))
                <div class="alert alert-danger">
                    {{ $errors->first('adresse') }}
                </div>
                @endif
            </div>  
        </div>  
        
        <div class="form-group">
            <label class="col-md-3 control-label">Code postal : </label>
            <div class="col-md-6 col-md-3">
                 <input type="text" name="cp" ng-model="cp" class="form-control" placeholder="Votre code postal" size ="5"  value="{{ isset($errors) && count($errors) > 0 ? old('cp'): $info->cp }}" required> 
                 @if($errors->has('cp'))
                 <div class="alert alert-danger">
                     {{ $errors->first('cp') }}
                 </div>
                  @endif
                 </div> 
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Ville : </label>
            <div class="col-md-6 col-md-3">
                <input type="text" name="ville" ng-model="ville" class="form-control" placeholder="Votre ville" maxlength="30" pattern ="^[a-zéèàêâùïüëA-Z][a-zéèàêâùïüëA-Z-'\s]{1,29}$" value="{{isset($errors) && count($errors) > 0 ? old('ville'): $info->ville}}" required>
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
                <input type="text" name="tel" ng-model="tel" class="form-control" placeholder="Votre numero de telephone" maxlength="30" pattern="^(?:0|\(?\+33\)?\s?|0033\s?)[1-79](?:[\.\-\s]?\d\d){4}$" value="{{isset($errors) && count($errors) > 0 ? old('tel'): $info->tel}}" required>
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
                <input type="email" name="email" ng-model="email" class="form-control" placeholder="Votre email" maxlength="30" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" value="{{isset($errors) && count($errors) > 0 ? old('email'): $info->email}}" required>
                @if($errors->has('email'))
                <div class="alert alert-danger">
                    {{ $errors->first('email') }}
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

