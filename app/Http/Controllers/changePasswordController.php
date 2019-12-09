<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Validator;
use App\metier\GsbFrais;

class changePasswordController extends Controller
{
    /**
     * @return vue formModifMdp
     */
    public function affFormModifMdp(){
        return view('formModifMdp');
    }

    /**
     * @return vue formModifMdp
     */
    public function verifInfos(Request $request){
        $this->validate($request, [
            'ancienMdp' => 'bail|required|between:5,8',
            'newMdp' => 'bail|required|between:6,8',
            'repeterMdp' => 'bail|required|between:6,8'
        ]);
        $gsbFrais = new GsbFrais();
        $idVisiteur = Session::get('id');
        $info = $gsbFrais->getInfosPerso($idVisiteur);

        // $validator = new Validator();

        $ancienMdp = $request->input('ancienMdp');
        $newMdp = $request->input('newMdp');
        $repeterMdp = $request->input('repeterMdp');
        if (sha1($ancienMdp) === $info->mdp) {
            if ($newMdp === $repeterMdp) {
                $gsbFrais->modifMdp($newMdp, $info->id);
                $valide = "Votre mot de passe a été mis à jour.";
                return back()->with('valide', $valide);
            } else {
                $error = 'Les mots de passe ne correspondent pas !';
                return back()->with('newMdp', $error);
            }
        } else {
            $error = 'Ce n\'est pas le bon mot de passe !';
            return back()->with('ancienMdp', $error);
        }
    }
}
