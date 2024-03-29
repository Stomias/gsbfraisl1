<?php
namespace App\metier;

use Illuminate\Support\Facades\DB;

/** 
 * Classe d'accès aux données. 
 */
class GsbFrais{   		
/**
 * Retourne les informations d'un visiteur 
 
 * @param $login 
 * @param $mdp
 * @return l'id, le nom et le prénom sous la forme d'un objet 
*/
public function getInfosVisiteur($login, $mdp){
		$req = "SELECT visiteur.id as id, visiteur.nom as nom, visiteur.prenom as prenom, travailler.tra_role as tra_role, region.reg_nom as reg_nom, secteur.sec_nom as sec_nom  from visiteur
		inner join travailler on visiteur.id = travailler.idVisiteur
		inner join region on travailler.tra_reg = region.id
		inner join secteur on region.sec_code = secteur.id
        where visiteur.login=:login and visiteur.mdp=:mdp order by tra_date DESC";
        $ligne = DB::select($req, ['login'=>$login, 'mdp'=>sha1($mdp)]);
        return $ligne;
}


/**
 * Modifie le mot de passe de l'utilisateur avec le mot de passe indiqué
 
 * @param $mdp 
 * @param $idVisiteur
*/
public function modifMdp($mdp, $idVisiteur) {
	$req = "update visiteur set mdp = :mdp 
		where visiteur.id = :idVisiteur";
		DB::update($req, ['mdp'=>sha1($mdp), 'idVisiteur'=>$idVisiteur]);	
}
/**
 * Retourne sous forme d'un tableau d'objets toutes les lignes de frais hors forfait
 * concernées par les deux arguments
 
 * La boucle foreach ne peut être utilisée ici car on procède
 * à une modification de la structure itérée - transformation du champ date-
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return un objet avec tous les champs des lignes de frais hors forfait 
*/
	public function getLesFraisHorsForfait($idVisiteur,$mois){
	    $req = "select * from lignefraishorsforfait where lignefraishorsforfait.idvisiteur =:idVisiteur 
		and lignefraishorsforfait.mois = :mois ";	
            $lesLignes = DB::select($req, ['idVisiteur'=>$idVisiteur, 'mois'=>$mois]);
//            for ($i=0; $i<$nbLignes; $i++){
//                    $date = $lesLignes[$i]['date'];
//                    $lesLignes[$i]['date'] =  dateAnglaisVersFrancais($date);
//            }
            return $lesLignes; 
	}
/**
 * Retourne sous forme d'un tableau associatif toutes les lignes de frais au forfait
 * concernées par les deux arguments
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return un objet contenant les frais forfait du mois
*/
	public function getLesFraisForfait($idVisiteur, $mois){
		$req = "select fraisforfait.id as idfrais, fraisforfait.libelle as libelle, ligneFraisForfait.mois as mois,
		lignefraisforfait.quantite as quantite from lignefraisforfait inner join fraisforfait 
		on fraisforfait.id = lignefraisforfait.idfraisforfait
		where lignefraisforfait.idvisiteur = :idVisiteur and lignefraisforfait.mois=:mois
		order by lignefraisforfait.idfraisforfait";	
//                echo $req;
                $lesLignes = DB::select($req, ['idVisiteur'=>$idVisiteur, 'mois'=>$mois]);
		return $lesLignes; 
	}
/**
 * Retourne tous les id de la table FraisForfait
 * @return un objet avec les données de la table frais forfait
*/
	public function getLesIdFrais() {
		$req = "select id as idfrais, montant from fraisforfait order by fraisforfait.id";
		$lesLignes = DB::select($req);
		return $lesLignes;
	}
/**
 * Met à jour la table ligneFraisForfait
 
 * Met à jour la table ligneFraisForfait pour un visiteur et
 * un mois donné en enregistrant les nouveaux montants
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @param $lesFrais tableau associatif de clé idFrais et de valeur la quantité pour ce frais
*/
	public function majFraisForfait($idVisiteur, $mois, $lesFrais){
		$lesCles = array_keys($lesFrais);
    //            print_r($lesFrais);
		foreach($lesCles as $unIdFrais){
			$qte = $lesFrais[$unIdFrais];
			$req = "update lignefraisforfait set lignefraisforfait.quantite = :qte
			where lignefraisforfait.idvisiteur = :idVisiteur and lignefraisforfait.mois = :mois
			and lignefraisforfait.idfraisforfait = :unIdFrais";
                        DB::update($req, ['qte'=>$qte, 'idVisiteur'=>$idVisiteur, 'mois'=>$mois, 'unIdFrais'=>$unIdFrais]);
		}
		
	}
/**
 * met à jour le nombre de justificatifs de la table ficheFrais
 * pour le mois et le visiteur concerné
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
*/
	public function majNbJustificatifs($idVisiteur, $mois, $nbJustificatifs){
		$req = "update fichefrais set nbjustificatifs = :nbJustificatifs 
		where fichefrais.idvisiteur = :idVisiteur and fichefrais.mois = :mois";
		DB::update($req, ['nbJustificatifs'=>$nbJustificatifs, 'idVisiteur'=>$idVisiteur, 'mois'=>$mois]);	
	}
/**
 * Teste si un visiteur possède une fiche de frais pour le mois passé en argument
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return vrai ou faux 
*/	
	public function estPremierFraisMois($idVisiteur,$mois)
	{
		$ok = false;
		$req = "select count(*) as nblignesfrais from fichefrais 
		where fichefrais.mois = :mois and fichefrais.idvisiteur = :idVisiteur";
		$laLigne = DB::select($req, ['idVisiteur'=>$idVisiteur, 'mois'=>$mois]);
                $nb = $laLigne[0]->nblignesfrais;
		if($nb == 0){
			$ok = true;
		}
		return $ok;
	}
/**
 * Retourne le dernier mois en cours d'un visiteur
 
 * @param $idVisiteur 
 * @return le mois sous la forme aaaamm
*/	
	public function dernierMoisSaisi($idVisiteur){
		$req = "select max(mois) as dernierMois from fichefrais where fichefrais.idvisiteur = :idVisiteur";
		$laLigne = DB::select($req, ['idVisiteur'=>$idVisiteur]);
                $dernierMois = $laLigne[0]->dernierMois;
		return $dernierMois;
	}
	
/**
 * Crée une nouvelle fiche de frais et les lignes de frais au forfait pour un visiteur et un mois donnés
 
 * récupère le dernier mois en cours de traitement, met à 'CL' son champs idEtat, crée une nouvelle fiche de frais
 * avec un idEtat à 'CR' et crée les lignes de frais forfait de quantités nulles 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
*/
	public function creeNouvellesLignesFrais($idVisiteur,$mois){
		$dernierMois = $this->dernierMoisSaisi($idVisiteur);
		$laDerniereFiche = $this->getLesInfosFicheFrais($idVisiteur,$dernierMois);
		if($laDerniereFiche->idEtat=='CR'){
				$this->majEtatFicheFrais($idVisiteur, $dernierMois,'CL');
				
		}
		$req = "insert into fichefrais(idvisiteur,mois,nbJustificatifs,montantValide,dateModif,idEtat) 
		values(:idVisiteur,:mois,0,0,now(),'CR')";
		DB::insert($req, ['idVisiteur'=>$idVisiteur, 'mois'=>$mois]);
		$lesIdFrais = $this->getLesIdFrais();
		foreach($lesIdFrais as $uneLigneIdFrais){
			$unIdFrais = $uneLigneIdFrais->idfrais;
			$req = "insert into lignefraisforfait(idvisiteur,mois,idFraisForfait,quantite) 
			values(:idVisiteur,:mois,:unIdFrais,0)";
			DB::insert($req, ['idVisiteur'=>$idVisiteur, 'mois'=>$mois, 'unIdFrais'=>$unIdFrais]);
		 }
	}
/**
 * Crée un nouveau frais hors forfait pour un visiteur un mois donné
 * à partir des informations fournies en paramètre
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @param $libelle : le libelle du frais
 * @param $date : la date du frais au format français jj//mm/aaaa
 * @param $montant : le montant
*/
	public function creeNouveauFraisHorsForfait($idVisiteur,$mois,$libelle,$date,$montant){
//		$dateFr = dateFrancaisVersAnglais($date);
		$req = "insert into lignefraishorsforfait(idVisiteur, mois, libelle, date, montant) 
		values(:idVisiteur,:mois,:libelle,:date,:montant)";
		DB::insert($req, ['idVisiteur'=>$idVisiteur, 'mois'=>$mois, 'libelle'=>$libelle,'date'=>$date,'montant'=>$montant]);
	}

/**
 * Récupère le frais hors forfait dont l'id est passé en argument
 * @param $idFrais 
 * @return un objet avec les données du frais hors forfait
*/
	public function getUnFraisHorsForfait($idFrais){
		$req = "select * from lignefraishorsforfait where lignefraishorsforfait.id = :idFrais ";
		$fraisHF = DB::select($req, ['idFrais'=>$idFrais]);
//                print_r($unfraisHF);
                $unFraisHF = $fraisHF[0];
                return $unFraisHF;
	}
/**
 * Modifie frais hors forfait à partir de son id
 * à partir des informations fournies en paramètre
 * @param $id 
 * @param $libelle : le libelle du frais
 * @param $date : la date du frais au format français jj//mm/aaaa
 * @param $montant : le montant
*/
	public function modifierFraisHorsForfait($id, $libelle,$date,$montant){
//		$dateFr = dateFrancaisVersAnglais($date);
		$req = "update lignefraishorsforfait set libelle = :libelle, date = :date, montant = :montant
		where id = :id";
		DB::update($req, ['libelle'=>$libelle,'date'=>$date,'montant'=>$montant, 'id'=>$id]);
	}
        
/**
 * Supprime le frais hors forfait dont l'id est passé en argument
 * @param $idFrais 
*/
	public function supprimerFraisHorsForfait($idFrais){
		$req = "delete from lignefraishorsforfait where lignefraishorsforfait.id = :idFrais ";
		DB::delete($req, ['idFrais'=>$idFrais]);
	}
/**
 * Retourne les fiches de frais d'un visiteur à partir d'un certain mois
 * @param $idVisiteur 
 * @param $mois mois début
 * @return un objet avec les fiches de frais de la dernière année
*/
	public function getLesFrais($idVisiteur, $mois){
		$req = "select * from  fichefrais where idvisiteur = :idVisiteur
                and  mois >= :mois   
		order by fichefrais.mois desc ";
                $lesLignes = DB::select($req, ['idVisiteur'=>$idVisiteur, 'mois'=>$mois]);
                return $lesLignes;
	}
/**
 * Retourne les informations d'une fiche de frais d'un visiteur pour un mois donné
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return un objet avec des champs de jointure entre une fiche de frais et la ligne d'état 
*/	
	public function getLesInfosFicheFrais($idVisiteur,$mois){
		$req = "select ficheFrais.idEtat as idEtat, ficheFrais.dateModif as dateModif, ficheFrais.nbJustificatifs as nbJustificatifs, 
			ficheFrais.montantValide as montantValide, etat.libelle as libEtat from  fichefrais inner join Etat on ficheFrais.idEtat = Etat.id 
			where fichefrais.idvisiteur = :idVisiteur and fichefrais.mois = :mois";
		$lesLignes = DB::select($req, ['idVisiteur'=>$idVisiteur,'mois'=>$mois]);			
		return $lesLignes[0];
	}
/** 
 * Modifie l'état et la date de modification d'une fiche de frais
 * Modifie le champ idEtat et met la date de modif à aujourd'hui
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 */
 
	public function majEtatFicheFrais($idVisiteur,$mois,$etat){
		$req = "update ficheFrais set idEtat = :etat, dateModif = now() 
		where fichefrais.idvisiteur = :idVisiteur and fichefrais.mois = :mois";
		DB::update($req, ['etat'=>$etat, 'idVisiteur'=>$idVisiteur, 'mois'=>$mois]);
	}

/**
 * Retourne les informations personnelles d'un visiteur
 
* @param $id 
* @return la ville et le cp sous la forme d'un objet 
*/

	public function getInfosPerso($id){
		$req = "select * from visiteur where visiteur.id=:id";
		$ligne = DB::select($req, ['id'=>$id]);
		return $ligne[0];
	}

	/**
	 * Modifie le CP,la ville, l'adresse, l'email et le téléphone du visiteur
	 * @param $codePostal
	 * @param $ville
	 * @param $idVisiteur 
	 * @param $adresse
	 * @param $email
	 * @param $tel
	 */
	public function modifInfos($codePostal, $ville, $idVisiteur, $adresse, $email, $tel){
		$req = "update visiteur set cp = :codePostal, ville = :ville, adresse = :adresse, email = :email, tel = :tel
		where id = :idVisiteur";
		DB::update($req, ['codePostal'=>$codePostal, 'idVisiteur'=>$idVisiteur, 'ville'=>$ville, 'adresse'=>$adresse, 'email'=>$email, 'tel'=>$tel]);
	}

	/**
	 * Génére un mot de passe aléatoire de taille $size
	 * @param $size
	 * @return le mot passe généré
	 */
	function Genere_Password($size)
	{
		// Initialisation des caractères utilisables
		$characters = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
		$password="";
		for($i=0;$i<$size;$i++)
		{
			$password .= ($i%2) ? strtoupper($characters[array_rand($characters)]) : $characters[array_rand($characters)];
		}
			
		return $password;
	}

	/**
	 * Ajoute un utilisateur dans la base de données
	 * @param $idVisiteur
	 * @param $nom
	 * @param $prénom
	 * @param $cp
	 * @param $ville
	 * @param $adresse
	 * @param $email
	 * @param $tel
	 * @param $embauche
	 * @param $password	 
	 * */

	public function ajoutInfos($idVisiteur, $nom, $prénom, $cp, $ville, $adresse, $email, $tel, $embauche, $password){
		
		DB::insert('insert into visiteur (id,nom,prenom,login,mdp,adresse,cp,ville,dateEmbauche,email,tel) values (?,?,?,?,?,?,?,?,?,?,?)', [$idVisiteur,$nom,$prénom,strtolower($prénom[0] .$nom),sha1($password),$adresse,$cp,$ville,$embauche,$email,$tel]);
		
	}

	/**
	 * Ajoute un utilisateur dans la table travailler
	 * @param $idVisiteur
	 * @param $role
	 * @param $reg
	 * */

	public function ajoutTravail($idVisiteur, $role, $reg){
		DB::insert('insert into travailler (idVisiteur,tra_date,tra_reg,tra_role) values (?,?,?,?)',[$idVisiteur,date("Y-m-d"),$reg,$role]);
	}



	/**
	 * Retourne sous forme d'un tableau associatif touts les visiteurs/délégués/responsables
	 * du même secteur que l'utilisateur $id
	 
	* @param $id
	* @return les informations des utilisateurs 
	*/
	public function getListeVisiteurDelegue($id){
		$req = "select * from vaffectation inner join visiteur on vaffectation.idVisiteur = visiteur.id where aff_sec = (select aff_sec from vaffectation where idVisiteur= :id)";
		$lesLignes = DB::select($req, ['id'=>$id]);
		return $lesLignes; 
	}

	/**
	 * Retourne les informations d'un visiteur 
	 
	* @param $id
	* @return l'id, le nom, le prénom, le role et le secteur sous la forme d'un objet 
	*/
	public function getInfosVisiteurID($id){
		$req = "SELECT visiteur.id as id, visiteur.nom as nom, visiteur.prenom as prenom, travailler.tra_role as tra_role, region.reg_nom as reg_nom, secteur.sec_nom as sec_nom from visiteur
		inner join travailler on visiteur.id = travailler.idVisiteur
		inner join region on travailler.tra_reg = region.id
		inner join secteur on region.sec_code = secteur.id
		where visiteur.id=:id order by tra_date DESC";
		$ligne = DB::select($req, ['id'=>$id]);
		return $ligne[0];
	}

	/**
	 * Retourne les regions du même secteur que l'argument
	 
	* @param $id
	* @return le nom de la region sous la forme d'un objet 
	*/
	public function getRegionSecteurVisiteurID($id){
		$req = "select id,reg_nom from region where sec_code = (select aff_sec from vaffectation where idVisiteur = :id)";
		$ligne = DB::select($req, ['id'=>$id]);
		return $ligne;
	}

	/**
	 * Retourne l'id de l'utilisateur 
	 
	* @param $id
	* @return l'id de l'utilisateur
	*/
	public function UserDispo($id){
		$req = "select id from visiteur where id = :id";
		$ligne = DB::select($req, ['id'=>$id]);
		return $ligne;
	}

	/**
	 * Modifie le role et la region du visiteur
	 * @param $idVisiteur 
	 * @param $reg
	 * @param $role
	 */
	public function modifInfosParResponsable($id, $reg, $role){
		$req = "INSERT INTO travailler (idVisiteur,tra_date, tra_reg, tra_role) VALUES (:idVisiteur, date(now()), :reg, :role)";
		DB::update($req, ['idVisiteur'=>$id, 'reg'=>$reg, 'role'=>$role]);
	}
}
?>