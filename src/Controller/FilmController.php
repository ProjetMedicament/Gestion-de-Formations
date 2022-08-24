<?php

namespace App\Controller;

use App\Entity\Film;
use App\Entity\Studio;
use App\Form\FilmType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FilmController extends AbstractController
{
    /**
     * @Route("/film", name="film")
     */

    public function ajoutAction()
    {   
        $studio1 = new Studio();
        //
        // à compléter en utilisant les setter
        //
        $nom = $studio1-> setNom("Studio 1");
        $pays = $studio1-> setPays("France");
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($studio1);
        $manager->flush();
        // return $this->render('film/index.html.twig', [
        //     'controller_name' => 'FilmController',
        // ]);
        
        $film1 = new Film();
        //
        // à compléter en utilisant les setter
        //
        $date = new \DateTime("2000/10/01");
        $resume = "Nouveau film";
        $titre = $film1-> setTitre("titre1");
        $datesortie = $film1-> setDateSortie($date);
        $nomresume = $film1-> setResume($resume);
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($film1);
        $manager->flush();
        return $this->render('film/index.html.twig', [
            'controller_name' => 'FilmController',
        ]);

    }

    /**
     * @Route("/affFilm/{id}", name="app_film" )
     */
    // public function afficherFilmAction($id)
    // {
    //     $film = $this->getDoctrine()->getRepository(Film::class)->find($id);
    //     if ($film) {
    //         echo "Date de sortie : ".$film->getDateSortie()->format('d-m-Y');
    //         echo "<p>";
    //         echo "Titre : ".$film->getTitre() ;
    //         echo "<p>";
    //         echo "Résumé : ".$film->getResume() ;
    //     }
    //     return $this->render('film/index.html.twig',['controller_name' => 'FilmController',]);
    // }

    public function afficherFilmAction($id)
    {
        $film = $this->getDoctrine()->getRepository(Film::class)->find($id);
        if ($film) {
        }
        return $this->render('film/unFilm.html.twig',array('unFilm' => $film));
    }

    /**
     * @Route("/afficheLesFilms", name="app_aff" )
     */
    // public function afficherLesFilmsAction()
    // {   
    //     $film = $this->getDoctrine()->getRepository(Film::class)->findAll();
    //     foreach ($film as $key => $films) {
    //         if ($films) {
    //             echo "Date de sortie : ".$films->getDateSortie()->format('d-m-Y');
    //             echo "<p>";
    //             echo "Titre : ".$films->getTitre() ;
    //             echo "<p>";
    //             echo "Résumé : ".$films->getResume() ;
    //             echo "<p> -------- <p>";
    //         }
    //     }
    //     return $this->render('film/index.html.twig', [
    //         'controller_name' => 'FilmController',
    //     ]);
    // }
    public function afficherLesFilmsAction()
    {   
        $films = $this->getDoctrine()->getRepository(Film::class)->findAll();
        if (!$films) {
            $message ="Pas de films";
        }
        else {
            $message = null;
        }
        return $this->render('film/listeFilm.html.twig',array('ensFilms' => $films , 'message' => $message));
    }

    /**
     * @Route("/affFilm2000", name="app_affFilm2000" )
     */
    public function findFilmPlus2000Action()
    {   
        $films = $this->getDoctrine()->getRepository(Film::class)->findFilmPlus2000();
        foreach ($films as $key => $lesfilms) {
            if ($lesfilms) {
                echo "Date de sortie : ".$lesfilms->getDateSortie()->format('d-m-Y');
                echo "<p>";
                echo "Titre : ".$lesfilms->getTitre() ;
                echo "<p>";
                echo "Résumé : ".$lesfilms->getResume() ;
                echo "<p> -------- <p>";
            }
        }
        return $this->render('film/index.html.twig', [
            'controller_name' => 'FilmController',
        ]);
    }

    public function index(): Response
    {
        return $this->render('film/index.html.twig', [
            'controller_name' => 'FilmController',
        ]);
    }

    /**
     * @Route("/suppFilm/{id}", name="app_film_sup" )
     */
    public function suppFilmAction($id)
    {
        $film = $this->getDoctrine()->getRepository(Film::class)->find($id);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($film);
        $manager->flush();
        return $this->redirectToRoute('app_aff');
    }

    /**
     * @Route("/ajoutFilm", name="app_film_ajouter" )
     */
    public function ajoutFilmAction(Request $request, $film= null)
    {
        if ($film==null) {
            $film = new Film();
        }
        $form = $this->createForm(FilmType::class, $film);
        // récupération de la requête
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($film);
            $em->flush();
            return $this->redirectToRoute('app_aff');
        }
        
        return $this->render('film/editer.html.twig', array('form'=>$form->createView()));
    }

    /**
     * @Route("/modifFilm/{id}", name="app_film_modifier" )
     */

    public function modiFilmAction(Request $request, $id)
    {   
        $film = $this->getDoctrine()->getRepository(Film::class)->find($id);
        if ($film==null) {
            $film = new Film();
        }
        $form = $this->createForm(FilmType::class, $film);
        // récupération de la requête
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($film);
            $em->flush();
            return $this->redirectToRoute('app_aff');
        }
        
        return $this->render('film/editer.html.twig', array('form'=>$form->createView()));
    }

    /**
     * @Route("/listeacteur/{id}", name="app_film_listeacteur" )
     */
    public function afficherFilmActeursAction($id)
    {
        $film = $this->getDoctrine()->getRepository(Film::class)->find($id);
        if ($film) {
        }
        return $this->render('film/lesActeurs.html.twig',array('unFilm' => $film));
    }
}
