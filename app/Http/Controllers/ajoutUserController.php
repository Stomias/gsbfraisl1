<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\metier\GsbFrais;

class ajoutUserController extends Controller
{
    /**
     * Initialise le formulaireavec les infos personnelles
     * @return vue formModifInfos
     */
    public function affFormAjoutUser(){
        $error = "";
        $idVisiteur = Session::get('id');
        $secteur = Session::get('reg_id');
        $gsbFrais = new GsbFrais();
        $info = $gsbFrais->getInfosPerso($idVisiteur);
        $regions = $gsbFrais->getRegionSecteurVisiteurID($idVisiteur);
        if (Session::get('role') == 'Responsable'){
            return view('formAjoutUser', compact('info','regions', 'error'));
        }
        else{
            return view('home', compact('info', 'erreur'));
        }
    }

    public function verifInfos(Request $request){
        $this->validate($request, [
            'id' => 'bail|required|between:2,4',
            'nom' => 'bail|required|between:3,30|alpha',
            'prenom' => 'bail|required|between:3,30|alpha',
            'password' => 'required|between:5,8',
            'passwordconf'=> 'required|between:5,8',
            // bail fait en sorte que des qu'il y a une erreur, on arrete la verification
            // required obligatoire
            // digits:x = x chiffre
            'cp' => 'bail|required|digits:5',
            'ville' => 'bail|required|between:2,30|alpha',
            'adresse' => 'bail|required|between:2,30|',
            'email' => 'bail|required|between:2,30|',
            'tel' => 'bail|required|',
            'embauche' => 'required',
            'role' => 'required',
            'reg' => 'required',
            // between pour la taille
            // alpha pour alphanumeric
        ]);
        // Récupérer les données pour mettre à jour la 
        $idVisiteur = $request->input('id');
        $nom = $request->input('nom');
        $prénom = $request->input('prenom');
        $adresse = $request->input('adresse');
        $cp = $request->input('cp');
        $ville = $request->input('ville');
        $email = $request->input('email');
        $tel = $request->input('tel');
        $embauche = $request->input('embauche');
        $password = $request->input('password');
        $password2 = $request->input('passwordconf');
        $role =$request->input('role');
        $role =$request->input('reg');
        
        // To do : Modifier la BDD
        if($password == $password2){
            $gsbFrais = new GsbFrais();
            $info = $gsbFrais->ajoutInfos($idVisiteur, $nom, $prénom, $cp, $ville, $adresse, $email, $tel, $embauche,$password);
            $travail = $gsbFrais->ajoutTravail($idVisiteur, $role, $reg);
            //Confirmer la MAJ
            return view('confirmAjoutUser');
        }
        else{
            echo "<script>alert(\"Les mots de passe ne sont pas identiques\")</script>";
            return view('formAjoutUser');

        }
        
    }
}
