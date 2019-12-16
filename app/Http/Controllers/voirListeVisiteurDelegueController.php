<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Exception;
use App\metier\GsbFrais;

class VoirListeVisiteurDelegueController extends Controller
{
    /** 
     * Affiche la liste de tout les visiteur et delegue
     * du secteur du responsable
     */
    public function getListeVisiteurDelegue() {
        $gsbFrais= new GsbFrais();
        $idVisiteur = Session::get('id');
        $mesVisiteurDelegue = $gsbFrais->getListeVisiteurDelegue($idVisiteur);
        $titreVue= "Liste des visiteurs et délégué de mon secteur";
        if (Session::get('role') == 'Responsable'){
            return view('listeVisiteurDelegue', compact('mesVisiteurDelegue', 'titreVue'));
        }
        else{
            return view('home');
        }
    }
}