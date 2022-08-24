<?php

namespace App\Controller;

use App\Entity\Film;
use App\Entity\Studio;
use App\Form\FilmType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudioController extends AbstractController
{
    /**
     * @Route("/studio", name="studio")
     */
    public function index(): Response
    {
        return $this->render('studio/index.html.twig', [
            'controller_name' => 'StudioController',
        ]);
    }


    /**
     * @Route("/ajoutStudioFilm", name="app_studio_film")
     */
    public function ajoutAction()
    {   
        $studio3 = new Studio();
        //
        // à compléter en utilisant les setter
        //
        $nom = $studio3-> setNom("Studio 3");
        $pays = $studio3-> setPays("Angleterre");
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($studio3);
        $manager->flush();
        // return $this->render('film/index.html.twig', [
        //     'controller_name' => 'FilmController',
        // ]);

        $film5 = new Film();
        //
        // à compléter en utilisant les setter
        //
        $date = new \DateTime("2000/11/01");
        $resume = "Nouveau film de op";
        $titre = $film5-> setTitre("titre5");
        $lestudio = $film5-> setStudio($studio3);
        $datesortie = $film5-> setDateSortie($date);
        $nomresume = $film5-> setResume($resume);
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($film5);
        $manager->flush();
        return $this->render('film/index.html.twig', [
            'controller_name' => 'FilmController',
        ]);

    }

    /**
     * @Route("/afficheFilmEtStudio/{id}", name="app_aff_filmstudio" )
     */
    public function afficheFilmEtStudio($id)
    {
        $film = $this->getDoctrine()->getRepository(Film::class)->find($id);
        if ($film) {
        }
        return $this->render('film/unFilm.html.twig',array('unFilm' => $film));
    }

    /**
     * @Route("/afficheStudioListeFilms/{id}", name="app_aff_studiofilms" )
     */
    public function afficheStudioListeFilms($id)
    {
        $studio = $this->getDoctrine()->getRepository(Studio::class)->find($id);
        if (!$studio) {
            $message = "Aucun film";
        }
        else {
            $message = null;
        }
        return $this->render('studio/unStudio.html.twig',array('unStudio' => $studio , 'message' => $message));
    }
}
