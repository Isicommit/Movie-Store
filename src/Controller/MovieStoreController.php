<?php

namespace App\Controller;

use App\Entity\Film;
use App\Entity\Personne;
use App\Entity\Fonction;
use App\Repository\FilmRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class MovieStoreController extends Controller
{
    /**
     * Affiche la liste des films en page d'accueil
     *
     * @Route("/", name="accueil")
     * 
     */
    public function home(FilmRepository $repo)
    {
        $films = $repo->findAll();

        return $this->render('movie_store/home.html.twig', [
            'films' => $films,
        ]);
    }
    /**
     * Affiche les détails d'un film
     *
     * @Route("/film/{id}", name="film_show")
     *  
     */

    public function showFilm($id)
    {
   
    $film = $this->getDoctrine()->getRepository(Film::class)->find($id);
    $personnes = $film->getPersonnes(); 
 
   
      return $this->render('movie_store/show_film.html.twig', [
            'film' => $film,
            'personnes'=> $personnes,
 
        ]);
    }
    /**
     * Affiche les détails d'une personne
     *
     * @Route("/personne/{id}", name="person_show")
     * 
     */

    public function showPerson($id)
    {
 
        $personne= $this->getDoctrine()->getRepository(Personne::class)->find($id);
        $films = $personne->getFilms();
        $fonctions = $personne->getFonctions();

      return $this->render('movie_store/show_person.html.twig', [
            'films' => $films,
            'personne' => $personne,
            'fonctions' => $fonctions
        ]);
    }
}
