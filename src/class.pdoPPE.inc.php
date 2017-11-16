<?php

class PdoPPE{
    private static $serveur='mysql:host=localhost';
    private static $bdd='dbname=PPE';
    private static $user='root' ;
    private static $mdp='root' ;
		private static $monPdo;
		private static $monPdoPPE=null;
/**
 * Constructeur privé, crée l'instance de PDO qui sera sollicitée
 * pour toutes les méthodes de la classe
 */
	private function __construct(){

    	 try{
            PdoPPE::$monPdo = new PDO(PdoPPE::$serveur.';'.PdoPPE::$bdd, PdoPPE::$user, PdoPPE::$mdp);
            PdoPPE::$monPdo->query("SET CHARACTER SET utf8");
            PdoPPE::$monPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           }
        catch (PDOException $e)
        {
            die($e->getMessage());
        }

        }

/**
 * Fonction statique qui crée l'unique instance de la classe

 * Appel : $instancePdoPPE = PdoPPE::getPdoPPE();

 * @return l'unique objet de la classe PdoPPE
 */
	public  static function getPdoPPE(){
		if(PdoPPE::$monPdoPPE==null){
			PdoPPE::$monPdoPPE= new PdoPPE();
		}
		return PdoPPE::$monPdoPPE;
	}

	public static function getListeMedecins(){
		$req="SELECT nom, prenom, id FROM medecin";
		$res=PdoPPE::$monPdo->query($req);
		$lesLignes=$res->fetchAll();
		return $lesLignes;
	}

	public static function getListeVisiteurs(){
		$req="SELECT nom, prenom, id FROM visiteur";
		$res=PdoPPE::$monPdo->query($req);
		$lesLignes=$res->fetchAll();
		return $lesLignes;
	}

    public static function getListeMedicaments(){
		$req="SELECT id ,nomCommercial FROM medicament";
		$res=PdoPPE::$monPdo->query($req);
		$lesLignes=$res->fetchAll();
		return $lesLignes;
	}

	public static function getListeMotif(){
		$req="SELECT distinct motif FROM rapport";
		$res=PdoPPE::$monPdo->query($req);
		$lesLignes=$res->fetchAll();
		return $lesLignes;
	}

	public static function getInfosMedecin($id){
		$req = "SELECT * FROM medecin WHERE id=".$id;
		$res = PdoPPE::$monPdo->query($req);
		$lesLignes=$res->fetch();
		return $lesLignes;
	}

	public static function creerCompteRendu($date,$motif,$bilan,$idVisiteur,$idMedecin){
		$req = "insert into rapport (date, motif, bilan, idVisiteur, idMedecin) values ('".$date."', '".$motif."', '".$bilan."', '".$idVisiteur."',".$idMedecin.")";
		$res = PdoPPE::$monPdo->prepare($req);
		$res->execute();
	}

	public static function getUser(){
		$req = "select id, login, mdp from visiteur";
		$res = PdoPPE::$monPdo->prepare($req);
		$res->execute();
		return $res;
	}

	public static function getRapportUser($id){
		$req = "SELECT * FROM rapport WHERE idVisteur=?";
		$res = PdoPPE::$monPdo->prepare($req);
		$res->execute(array($id));
		return $res;
	}

  public static function modifFormMedecin($id, $nom, $prenom, $adresse, $tel, $specialite, $departement){
    $req = "UPDATE medecin SET nom='".$nom."', prenom='".$prenom."', adresse='".$adresse."', tel='".$tel."', specialitecomplementaire='".$specialite."', departement='".$departement."' WHERE id='".$id."'";
    $res = PdoPPE::$monPdo->query($req);
  }

  public function getIdRapport(){
    $req = "SELECT LAST_INSERT_ID() as last_id";
    $res = PdoPPE::$monPdo->query($req);
    $id=$res->fetch();
    return $id['last_id'];
  }

  public function offreMedicament($idRapport,$idMedicament,$qte){
    $req = "Insert into offrir (idRapport, idMedicament, quantite) values ('".$idRapport."','".$idMedicament."',".$qte.")";
    $res = PdoPPE::$monPdo->query($req);
  }
}
?>
