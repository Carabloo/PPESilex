<?php

use Symfony\Component\HttpFoundation\Request;
use PPESilex\Form\Type\GroupeType;

// Home page
$app->match('/accueil/', function (Request $request) use ($app){
      require '../src/class.pdoPPE.inc.php';
      require '../src/Form/Type/FormulaireConnexion.php';
      $pdo = PdoPPE::getPdoPPE();
      if(isset($_SESSION['login']) && isset($_SESSION['password'])){
          return $app['twig']->render('v_accueil.html.twig', array());
          }
          else{
              if($request->getMethod()=='GET'){
                  $form = $app['form.factory']->create(GroupeType::class);
                  $formView = $form->createView();
                  return $app['twig']->render('v_connexion.html.twig',array('form' => $formView));
              }
              if($request->getMethod() == 'POST'){
                  $form = $app['form.factory']->create(GroupeType::class);
                  $form->handleRequest($request);
                  if($form->isValid()){
                      $data = $form->getData();
                      $visiteurs=$pdo->getUser();
                      foreach ($visiteurs as $visiteur){
                          if($data['login']==$visiteur['login'] && $data['password']==$visiteur['mdp']){
                              $_SESSION['login']=$visiteur['login'];
                              $_SESSION['password']=$visiteur['mdp'];
                              $_SESSION['idVisiteur']=$visiteur['id'];
                          }
                      }
                      return $app->redirect($app['url_generator']->generate('homepage'), array());
              }
          }
      }
})
->bind('homepage'); // nom attribué à la route


$app->get('/listeMedecins/', function () use ($app){
  require '../src/class.pdoPPE.inc.php';
  $pdo = PdoPPE::getPdoPPE();
  $medecins = $pdo->getListeMedecins();

  return $app['twig']->render('v_listeMedecins.html.twig', array('medecins' => $medecins));
})
->bind('listeMedecins');

$app->get('/infosMedecin/{id}', function ($id) use ($app){
  require '../src/class.pdoPPE.inc.php';
  $pdo = PdoPPE::getPdoPPE();
  $infosMedecin = $pdo->getInfosMedecin($id);

  return $app['twig']->render('v_infosMedecin.html.twig', array('medecins' => $infosMedecin));
})
->bind('infosMedecins');

//listeMedicament
$app->get('/listeMedicaments/', function () use ($app){
  require '../src/class.pdoPPE.inc.php';
  $pdo = PdoPPE::getPdoPPE();
  $medicaments = $pdo->getListeMedicaments();

  return $app['twig']->render('v_listeMedicament.html.twig', array('medicaments' => $medicaments));
})
->bind('listeMedicaments');


/*$app->get('/listeGroupe/', function () use ($app){
    require '../src/class.pdoPPE.inc.php';
    $pdo = PdoPPE::getPdoPPE();
    $groupes = $pdo->getListeGroupes();

    return $app['twig']->render('v_listeGroupe.html.twig', array('groupes' => $groupes));

    ob_start();             // démarre la temporisation de sortie
    require '../views/v_listeGroupe.php';
    $view = ob_get_clean(); // récupère le code HTML généré
    return $view;
})
->bind('listeGroupe');*/


/*$app->get('/etablissement/', function () use ($app){
    require '../src/class.pdoPPE.inc.php';
    $pdo = PdoPPE::getPdoPPE();
    $etablissement = $pdo->getListeEtablissement();

    return $app['twig']->render('v_listeEtablissement.html.twig', array('etablissement' => $etablissement));
})
->bind('etablissement');*/

$app->match('/ajoutCompteRendu/', function(Request $request) use ($app){
  require '../src/class.pdoPPE.inc.php';
	require '../src/Form/Type/GroupeType.php';
    $pdo = PdoPPE::getPdoPPE();
    if($request->getMethod()=='GET'){
		    $medecins=$pdo->getListeMedecins();
		    $motif=$pdo->getListeMotif();
        $medicaments=$pdo->getListeMedicaments();
        $data[0]=$medecins;
        $data[1]=$motif;
        $data[2]=$medicaments;
        $form = $app['form.factory']->create(GroupeType::class, $data);
        $formView = $form->createView();
        return $app['twig']->render('v_creerCompteRendu.html.twig',array('form' => $formView));
    }
    if($request->getMethod() == 'POST'){
		    $medecins=$pdo->getListeMedecins();
		    $motif = $pdo->getListeMotif();
        $medicaments=$pdo->getListeMedicaments();
        $data[0]=$medecins;
        $data[1]=$motif;
        $data[2]=$medicaments;
        $form = $app['form.factory']->create(GroupeType::class, $data);
        $form->handleRequest($request);

        if($form->isValid()){
            $data = $form->getData();
            $date=$data['date'];
            $date=substr($date->format("Y-m-d H-i-s"),0,10);
            echo $date;
			      $motif=$data['motif'];
            $bilan=$data['bilan'];
            $idVisiteur=$data['idVisiteur'];
            $idMedecin=$data['idMedecin'];
            $idMedicament=$data['idMedicament'];
            $quantite=$data['quantite'];
            $pdo->creerCompteRendu($date,$motif,$bilan,$idVisiteur,$idMedecin);
            $idRapport=$pdo->getIdRapport();
            $pdo->offreMedicament($idRapport,$idMedicament,$quantite);
            return $app->redirect($app['url_generator']->generate('ajoutCompteRendu', array()));
        }
    }
})
->bind('ajoutCompteRendu');

$app->get('/voirLeGroupe/{id}',function ($id) use ($app){
    require '../src/class.pdoPPE.inc.php';
    $pdo = PdoPPE::getPdoPPE();
    $infos = $pdo->getInfosGroupe($id);
   return $app['twig']->render('v_voirLeGroupe.html.twig', array('infos' => $infos));
})
->bind('voirLeGroupe');

$app->get('/listerRapport/', function () use ($app){
    require '../src/class.pdoPPE.inc.php';
    $pdo = PdoPPE::getPdoPPE();
    $rapports = $pdo->getRapportUser($_SESSION['idVisiteur']);
    $medecins = $pdo->getUnMedecin($rapports['idMedecin']);
   return $app['twig']->render('v_voirRapportUser.html.twig', array('Rapports' => $rapports,'sessions' => $_SESSION,'medecins' => $medecins));
})
->bind('listerRapport');


$app->match('/modifFormMedecin/{id}', function(Request $request,$id) use ($app){
  require '../src/class.pdoPPE.inc.php';
	require '../src/Form/Type/formMedecin.php';
    $pdo = PdoPPE::getPdoPPE();
    if($request->getMethod()=='GET'){
		$medecins=$pdo->getInfosMedecin($id);
        $form = $app['form.factory']->create(GroupeType::class);
        $formView = $form->createView();
        return $app['twig']->render('v_modifierMedecin.html.twig',array('form' => $formView, 'medecin' => $medecins));
    }
    if($request->getMethod() == 'POST'){
		$medecins=$pdo->getInfosMedecin($id);
        $form = $app['form.factory']->create(GroupeType::class, $medecins);
        $form->handleRequest($request);

        if($form->isValid()){
            $data = $form->getData();
            $nom=$data['nom'];
			      $prenom=$data['prenom'];
            $tel=$data['tel'];
            $adresse=$data['adresse'];
            $specialite=$data['specialite'];
            $departement=$data['departement'];
            $pdo->modifFormMedecin($id,$nom,$prenom,$adresse,$tel,$specialite,$departement);
            return $app->redirect($app['url_generator']->generate('listeMedecins', array()));
        }
    }
})
->bind('modifFormMedecin');
