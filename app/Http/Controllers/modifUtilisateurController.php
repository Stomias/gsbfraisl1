<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Exception;
use App\metier\GsbFrais;

class modifUtilisateurController extends Controller
{
    /**
     * @param $id
     * Initialise un formulaire avec les détails d'un utilisateur
     * @return vue formModifVisiteurDelegue
     * @return vue home
     */
    public function voirDetailUtilisateur($id){
        $error= "";
        $gsbFrais = new GsbFrais();
        $detailsVisiteur = $gsbFrais->getInfosVisiteurID($id);
        $regions = $gsbFrais->getRegionSecteurVisiteurID($id);
        $retour = "/getListeVisiteurDelegue";
        if (Session::get('role') == 'Responsable'){
            return view('formModifVisiteurDelegue', compact('detailsVisiteur','regions','retour','error'));
        }
        else{
            return view('home');
        }
    }

    /**
     * @param $request, $id
     * Permet de modifier les infos d'un utilisateur
     * @return vue confirmModifInfosUtilisateur
     */
    public function modifInfosUtilisateur(Request $request, $id){
        $this->validate($request, [
            'id' => 'bail|required',
            'reg' => 'bail|required',
            'role' => 'bail|required',
        ]);
        // Récupérer les données pour mettre à jour la 
        $idVisiteur = $request->input('id');
        $reg = $request->input('reg');
        $role = $request->input('role');
        $gsbFrais = new GsbFrais();
        $info = $gsbFrais->modifInfosParResponsable($idVisiteur, $reg, $role);

        //Confirmer la MAJ
        return view('confirmModifInfosUtilisateur');
    }
}
