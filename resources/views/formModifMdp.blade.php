@extends('layouts.master')
@section('content')
{!! Form::open(['url' => 'changeMdp']) !!}  
<div class="col-md-12 well well-md">
    <h2>Modification de mon mot de passe</h2>
    <div class="form-horizontal">    

        <i>Pour les mots de passe: une majuscule, une minuscule, un chiffre et entre 6 et 8 caractères</i><br><br>
        <div class="form-group">
            <label class="col-md-3 control-label">Ancien mot de passe : </label>
            <div class="col-md-6 col-md-3">
                <input type="password" name="ancienMdp" ng-model="password" class="form-control" maxlength="30" required>
                @if(session('ancienMdp'))
                <div class="alert alert-danger">
                    {{ session('ancienMdp') }}
                </div>
                @endif
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Nouveau mot de passe : </label>
            <div class="col-md-6 col-md-3">
                <input type="password" name="newMdp" ng-model="password" class="form-control" pattern="(?=^.{6,8}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" maxlength="30" required>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label">Répéter mot de passe : </label>
            <div class="col-md-6 col-md-3">
                <input type="password" name="repeterMdp" ng-model="password" class="form-control" pattern="(?=^.{6,8}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" maxlength="30" required>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
                    @if(session('newMdp'))
                    <div class="alert alert-danger">
                        {{ session('newMdp') }}
                    </div>
                    @endif
                <button type="submit" class="btn btn-default btn-primary"><span class="glyphicon glyphicon-log-in"></span> Valider</button>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
                @if(session('valide'))
                <div class="alert alert-success">
                    {{ session('valide') }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
@stop

