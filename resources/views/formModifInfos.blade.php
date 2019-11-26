@extends('layouts.master')
@section('content')
{!! Form::open(['url' => 'modifInfos']) !!}  
<div class="col-md-12 well well-md">
    <h2>Modification de mes informations personnelles</h2>
    <div class="form-horizontal">    
        
        <div class="form-group">
            <label class="col-md-3 control-label">code postal : </label>
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
            <label class="col-md-3 control-label">ville : </label>
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

