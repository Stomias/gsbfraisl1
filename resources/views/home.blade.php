@extends('layouts.master')


@if (Session::get('id') == '0' || Session::get('id') == null)
    @section('content')
        <div>
            <h2 class="bvn">Bienvenue sur le site intranet du laboratoire GSB.</h2>
            <h3 class="bvn">Vous devez vous connecter pour accéder aux services de ce site et vous déconnecter à chaque fin de session. </h3>
        </div>
    @stop
@else
    @section('content')
        <div>
            <h2 class="bvn">Bienvenue {{Session::get('nom')}} {{Session::get('prenom')}}</h2>
            <h4>Vous êtes affecté à la region <b>{{Session::get('region')}}</b> dans le secteur <b>{{Session::get('secteur')}}</b></h4> <br>
            <h3 class="bvn">Vous êtes bien connecté en tant que {{Session::get('role')}}</h3><br>
            @if (Session::get('role') == "Visiteur")
                <p>
                    L'objectif d'une visite est d'actualiser et rafraîchir vos connaissances sur les produits de l'entreprise. Les visiteurs ne font pas de vente, mais leurs interventions ont un impact certain sur la prescription de la pharmacopée du laboratoire
                </p>
            @elseif(Session::get('role') == "Délégué")
                <p>
                    Un délegué regional occupent trois quarts de son temps professionnel à la visite médicale.
                    Il a un rôle d'intermédiaire entre les visiteurs d'une région et leur responsable de secteur
                </h5>
            @elseif(Session::get('role') == "Responsable")
                <p>
                    Les responsables de secteur ont la charge d'encadrer la formation des nouveaux visiteurs, de dynamiser leurs équipes.Ils définissent les objectifs de vente (indirectement), gèrent les approvisionnements en échantillons et distribuent les budgets de fonctionnement par région. 
                </p>
            @endif
        </div>
    @stop
@endif 
