<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Entity\Formation;
use App\Entity\Inscription;
use App\Form\InscriptionType;
use App\Entity\Produit;
use App\Form\FormationType;
use App\Form\EmpConnexionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FormationController extends AbstractController
{
    /**
     * @Route("/formation", name="formation")
     */

    // public function index(): Response
    // {
    //     return $this->render('formation/accueil.html.twig', [
    //         'controller_name' => 'FormationController',
    //         'logmail' => 'logmail',
    //         'logmdp' => 'logmdp',
    //     ]);
    // }
    
    /**
     * @Route("/formation", name="formation")
     */

    public function index(Request $request, $employe= null) : Response
    {
        if ($employe==null) {
            $employe = new Employe();
        }
        $form = $this->createForm(EmpConnexionType::class, $employe);
        // récupération de la requête
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('app_connexion', array('login'=> $employe->getLogin(),'mdp' => $employe->getMdp()));
        }
        
        return $this->render('formation/accueil.html.twig', array('form'=>$form->createView()));
    }

    /**
     * @Route("/connexion/{login},{mdp}", name="app_connexion")
     */
    public function VerifloginMdp($login,$mdp)
    {
        // $employe = $this->getDoctrine()->getRepository(Employe::class)->findOneBy(array ("login" => $login));
        // $employe2 = $this->getDoctrine()->getRepository(Employe::class)->findOneBy(array ("mdp" =>md5($mdp)));
        $user = $this->getDoctrine()->getRepository(Employe::class)->findOneBy(array ('login' => $login, 'mdp' => md5($mdp)));
        if ($user) {
            $statut=$user->getStatut();
            if($statut > 0){
            $formations = $this->getDoctrine()->getRepository(Formation::class)->findAll();
            // $inscriptions = $this->getDoctrine()->getRepository(Inscription::class)->findAll();
            $inscriptions = $this->getDoctrine()->getRepository(Inscription::class)->findBy(array ("statut"=>"En cours"));
            $inscriptionsA = $this->getDoctrine()->getRepository(Inscription::class)->findBy(array ("statut"=>"Accepté"));
                if (!$formations) {
                    $message ="Pas de formation";
                }
                else {
                    $message = null;
                }
                if (!$inscriptions) {
                    $messageI ="Pas d'inscriptions";
                }
                else{
                    $messageI = null;
                }
                if (!$inscriptionsA) {
                    $messageA = "Pas d'inscriptions";
                } else {
                    $messageA = null;
                }
                // var_dump($statut);
                return $this->render('formation/listeform.html.twig',array('lesForms' => $formations , 'message' => $message , 'messageI' => $messageI , 'messageA' => $messageA , 'insc' => $inscriptions , 'inscA' => $inscriptionsA));
            }
            else {
                $formations = $this->getDoctrine()->getRepository(Formation::class)->findAll();
                if (!$formations) {
                    $message ="Pas de formation";
            }
                else {
                    $message = null;
                }
                // var_dump($statut);
                return $this->render('formation/listeform0.html.twig',array('lesForms' => $formations , 'message' => $message,'employe' => $user));
            }
        } 
        else{
            // var_dump($employe2);
            echo "<script> alert('Identifiants incorrects')</script>";
            return $this->redirectToRoute('formation');
            
        }
        
    }

    /**
     * @Route("/testajout", name="app_addform")
     */
    public function ajoutAction()
    {   
        $employe1 = new Employe();
        //
        // à compléter en utilisant les setter
        //
        $login = $employe1-> setLogin("toto");
        $mdp = $employe1-> setMdp(md5("toto20"));
        $nom = $employe1-> setNom("Dupond");
        $prenom = $employe1-> setPrenom("Toto");
        $statut = $employe1-> setStatut(1);
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($employe1);
        $manager->flush();
        return $this->render('film/index.html.twig', [
            'controller_name' => 'FilmController',
        ]);
    }
    /**
     * @Route("/lesformations", name="app_espaceemp")
     */
    public function afficherFormationsAction(){
    $formations = $this->getDoctrine()->getRepository(Formation::class)->findAll();
        if (!$formations) {
            $message ="Pas de formations";
        }
        else {
            $message = null;
        }
        return $this->render('formation/listeform.html.twig',array('lesForms' => $formations , 'message' => $message));
    }

    /**
     * @Route("/suppform/{id}", name="app_suppform")
     */
    public function suppFormAction($id)
    {   
        $employe = new Employe();
        $formation = $this->getDoctrine()->getRepository(Formation::class)->find($id);
        $desinscriptions = $this->getDoctrine()->getRepository(Inscription::class)->findBy(array("formation"=>$formation));
        if ($desinscriptions){
            echo "Impossible de supprimer,une/des inscription(s) sont présentes";
            $formations = $this->getDoctrine()->getRepository(Formation::class)->findAll();
            $inscriptions = $this->getDoctrine()->getRepository(Inscription::class)->findBy(array ("statut"=>"En cours"));
            $inscriptionsA = $this->getDoctrine()->getRepository(Inscription::class)->findBy(array ("statut"=>"Accepté"));
            if (!$formations) {
        
            $message ="Pas de formation";
            }
            else {
                $message = null;
            }
            if (!$inscriptions) {
                $messageI ="Pas d'inscriptions";
            }
            else{
                $messageI = null;
            }
            if (!$inscriptionsA) {
                $messageA = "Pas d'inscriptions";
            } else {
                $messageA = null;
            }
            return $this->render('formation/listeform.html.twig' , array ("login" => $employe->getLogin() , "mdp" => $employe->getMdp() ,"lesForms" => $formations, "insc"=>$inscriptions, "message"=>$message , "messageI"=>$messageI,"messageA"=>$messageA,"inscA"=>$inscriptionsA));
        }
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($formation);
        $manager->flush();
        echo "Formation supprimée";
        $formations = $this->getDoctrine()->getRepository(Formation::class)->findAll();
        $inscriptions = $this->getDoctrine()->getRepository(Inscription::class)->findBy(array ("statut"=>"En cours"));
        $inscriptionsA = $this->getDoctrine()->getRepository(Inscription::class)->findBy(array ("statut"=>"Accepté"));
        if (!$formations) {
            $message ="Pas de formation";
        }
        else {
            $message = null;
            }
        if (!$inscriptions) {
            $messageI ="Pas d'inscriptions";
        }
        else{
            $messageI = null;
        }
        if (!$inscriptionsA) {
            $messageA = "Pas d'inscriptions";
        } else {
            $messageA = null;
        }
        return $this->render('formation/listeform.html.twig' , array ("login" => $employe->getLogin() , "mdp" => $employe->getMdp() ,"lesForms" => $formations, "insc"=>$inscriptions, "message"=>$message , "messageI"=>$messageI,"messageA"=>$messageA,"inscA"=>$inscriptionsA));
    }
    
    /**
     * @Route("/ajoutForm", name="app_ajoutform" )
     */
    public function ajoutFormAction(Request $request, $formation= null)
    {   
        $employe = new Employe();
        if ($formation==null) {
            $formation = new Formation();
        }
        $form = $this->createForm(FormationType::class, $formation);
        // récupération de la requête
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($formation);
            $em->flush();
            $formations = $this->getDoctrine()->getRepository(Formation::class)->findAll();
            $inscriptions = $this->getDoctrine()->getRepository(Inscription::class)->findBy(array ("statut"=>"En cours"));
            $inscriptionsA = $this->getDoctrine()->getRepository(Inscription::class)->findBy(array ("statut"=>"Accepté"));
            if (!$formations) {
                $message ="Pas de formation";
            }
            else {
                $message = null;
                }
            if (!$inscriptions) {
                $messageI ="Pas d'inscriptions";
            }
            else{
                $messageI = null;
            }
            if (!$inscriptionsA) {
                $messageA = "Pas d'inscriptions";
            } else {
                $messageA = null;
            }
            return $this->render('formation/listeform.html.twig' , array ("login" => $employe->getLogin() , "mdp" => $employe->getMdp() ,"lesForms" => $formations, "insc"=>$inscriptions, "message"=>$message , "messageI"=>$messageI,"messageA"=>$messageA,"inscA"=>$inscriptionsA));
        }
        
        return $this->render('formation/editerform.html.twig', array('form'=>$form->createView()));
    }

    /**
     * @Route("/inscriptionform/{id},{login}", name="app_insc_form")
     */
    public function inscFormAction($id,$login)
    {
        $inscription = new Inscription();
        //
        // à compléter en utilisant les setter
        //
        $employe = $this->getDoctrine()->getRepository(Employe::class)->findOneBy(array ("login" => $login));
        $formsearch = $this->getDoctrine()->getRepository(Formation::class)->findOneBy(array ("id" => $id));
        // $idInsc = $this->getDoctrine()->getRepository(Inscription::class)->findAll();
        // $verifId = $idInsc->getId();
        // var_dump($employe);
        // var_dump($formsearch);
        if ($employe && $formsearch) {
            // $emp = new Employe($employe->getId(),$employe->getLogin(),$employe->getMdp(),$employe->getNom(),$employe->getPrenom(),$employe->getStatut());
            // $form = new Formation($formsearch->getId(),$formsearch->getDateDebut(),$formsearch->getNbreHeures(),$formsearch->getDepartement());
            // var_dump($emp);
            $formation = $inscription->setFormation($formsearch);
            $formation = $inscription->setEmploye($employe);
            $formation = $inscription->setStatut('En cours');
            // var_dump($formation);
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($inscription);
            $manager->flush();
            $formations = $this->getDoctrine()->getRepository(Formation::class)->findAll();
                if (!$formations) {
                    $message ="Pas de formation";
            }
                else {
                    $message = null;
                }
                // var_dump($statut);
                echo "Vous vous êtes inscrit";
                return $this->render('formation/listeform0.html.twig',array('lesForms' => $formations , 'message' => $message,'employe' => $employe));
                
            }
            $formations = $this->getDoctrine()->getRepository(Formation::class)->findAll();
                if (!$formations) {
                    $message ="Pas de formation";
            }
                else {
                    $message = null;
                }
                // var_dump($statut);
                return $this->render('formation/listeform0.html.twig',array('lesForms' => $formations , 'message' => $message,'employe' => $employe));
        }
    
        /**
        * @Route("/modifstatut/{id}", name="app_modifinsc" )
        */
        public function modifStatutAction(Request $request, $id)
        {   
            $uneInscription = $this->getDoctrine()->getRepository(Inscription::class)->find($id);
            $employe = new Employe();
            if ($uneInscription==null) {
                $uneInscription = new Inscription();
            }
            $form = $this->createForm(InscriptionType::class, $uneInscription);
            // récupération de la requête
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                echo "Modification réussie";
                $em = $this->getDoctrine()->getManager();
                $em->persist($uneInscription);
                $em->flush();
                $formations = $this->getDoctrine()->getRepository(Formation::class)->findAll();
                $inscriptions = $this->getDoctrine()->getRepository(Inscription::class)->findBy(array ("statut"=>"En cours"));
                $inscriptionsA = $this->getDoctrine()->getRepository(Inscription::class)->findBy(array ("statut"=>"Accepté"));
                if (!$formations) {
                    $message ="Pas de formation";
                }
                else {
                    $message = null;
                    }
                if (!$inscriptions) {
                    $messageI ="Pas d'inscriptions";
                }
                else{
                    $messageI = null;
                }
                if (!$inscriptionsA) {
                    $messageA = "Pas d'inscriptions";
                } else {
                    $messageA = null;
                }
                return $this->render('formation/listeform.html.twig' , array ("login" => $employe->getLogin() , "mdp" => $employe->getMdp() ,"lesForms" => $formations, "insc"=>$inscriptions, "message"=>$message , "messageI"=>$messageI,"messageA"=>$messageA,"inscA"=>$inscriptionsA));
            }
            
            return $this->render('formation/editerform.html.twig', array('form'=>$form->createView()));
        }

    /**
     * @Route("/modif2/{id}", name="app_modifforma2" )
     */
        public function mdifFormAction(Request $request,$id)
        {   
            $laformation = $this->getDoctrine()->getRepository(Formation::class)->find($id);
            $employe = new Employe();
            if ($laformation==null) {
                $laformation = new Formation();
            }
            $form = $this->createForm(FormationType::class, $laformation);
            // récupération de la requête
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($laformation);
                $em->flush();
                $formations = $this->getDoctrine()->getRepository(Formation::class)->findAll();
                $inscriptions = $this->getDoctrine()->getRepository(Inscription::class)->findBy(array ("statut"=>"En cours)"));
                $inscriptionsA = $this->getDoctrine()->getRepository(Inscription::class)->findBy(array ("statut"=>"Accepté"));
                if (!$formations) {
                    $message ="Pas de formation";
                }
                else {
                    $message = null;
                    }
                if (!$inscriptions) {
                    $messageI ="Pas d'inscriptions";
                }
                else{
                    $messageI = null;
                }
                if (!$inscriptionsA) {
                    $messageA = "Pas d'inscriptions";
                } else {
                    $messageA = null;
                }
                return $this->render('formation/listeform.html.twig' , array ("login" => $employe->getLogin() , "mdp" => $employe->getMdp() ,"lesForms" => $formations, "insc"=>$inscriptions, "message"=>$message , "messageI"=>$messageI,"messageA"=>$messageA,"inscA"=>$inscriptionsA));
                    }
            
            return $this->render('formation/editerform.html.twig', array('form'=>$form->createView()));
        }

    /**
     * @Route("/listeinscrits/{id}", name="app_listeinscrits" )
     */
        public function afficherInscritsFormations($id)
        {
            $inscriptions = $this->getDoctrine()->getRepository(Inscription::class)->findBy(array ("formation"=>$id));
            return $this->render('formation/listeinscrits.html.twig' , array ("lesInscs" => $inscriptions));     
        }

    /**
     * @Route("/popularforms", name="app_popularforms" )
     */
        public function carousselForms()
        {
            return $this->render('formation/popularforms.html.twig');
        }
}
