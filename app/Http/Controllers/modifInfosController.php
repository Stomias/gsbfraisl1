<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\metier\GsbFrais;

class modifInfosController extends Controller
{
    /**
     * Initialise le formulaireavec les infos personnelles
     * @return vue formModifInfos
     */
    public function affFormModifInfos(){
        $error = "";
        $idVisiteur = Session::get('id');
        $gsbFrais = new GsbFrais();
        $info = $gsbFrais->getInfosPerso($idVisiteur);
        return view('formModifInfos', compact('info', 'erreur'));
    }

    public function verifInfos(Request $request){
        $this->validate($request, [
            'cp' => 'bail|required|digits:5',
            // bail fait en sorte que des qu'il y a une erreur, on arrete la verification
            // required obligatoire
            // digits:x = x chiffre
            'ville' => 'bail|required|between:2,30|alpha'
            // between pour la taille
            // alpha pour alphanumeric
        ]);
        // Récupérer les données pour mettre à jour la 
        $adresse = $request->input('adresse');
        $cp = $request->input('cp');
        $ville = $request->input('ville');
        $idVisiteur = Session::get('id');
        // To do : Modifier la BDD

        $gsbFrais = new GsbFrais();
        $info = $gsbFrais->modifInfos($cp, $ville, $idVisiteur);

        //Confirmer la MAJ
        return view('confirmModifInfos');
    }
}
