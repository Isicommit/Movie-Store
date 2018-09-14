<?php

namespace App\Controller;

use App\Entity\Film;
use App\Entity\Personne;
use App\Form\FilmType;
use App\Form\PersonneType;
use App\Repository\FilmRepository;
use App\Repository\PersonneRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class MovieStoreController extends Controller
{

    /**
     * Affiche la liste des films en page d'accueil(à modifier par la suite)
     *
     * @Route("/", name="accueil")
     */
    public function home(FilmRepository $repo)
    {
        $films = $repo->findAll();

        return $this->render('movie_store/home.html.twig', [
            'films' => $films,
        ]);
    }
    /**
     * Affiche la liste des personnes
     *
     * @Route("/personnes", name="person_list")
     */
    public function showPersonList(PersonneRepository $repo)
    {
        $personnes = $repo->findAll();

        return $this->render('movie_store/person_list.html.twig', [
            'personnes' => $personnes,
        ]);
    }
    /**
     * Affiche les détails d'un film
     *
     * @Route("/film/{id}", requirements={"id" = "\d+"}, name="film_show")
     */
    public function showFilm($id)
    {
        $film = $this->getDoctrine()->getRepository(Film::class)->find($id);
        if (!$film) {
            throw new NotFoundHttpException("Aucun film avec l'id " . $id . " n'est présent dans la base");
        }
        $personnes = $film->getPersonnes();

        return $this->render('movie_store/film_show.html.twig', [
            'film' => $film,
            'personnes' => $personnes,

        ]);
    }
    /**
     * Affiche les détails d'une personne
     *
     * @Route("/personne/{id}", requirements={"id" = "\d+"}, name="person_show")
     */
    public function showPerson($id)
    {

        $personne = $this->getDoctrine()->getRepository(Personne::class)->find($id);
        if (!$personne) {
            throw new NotFoundHttpException("Aucun utilisateur avec l'id " . $id . " n'est présent dans la base");
        }
        $films = $personne->getFilms();
        $fonctions = $personne->getFonctions();

        return $this->render('movie_store/person_show.html.twig', [
            'films' => $films,
            'personne' => $personne,
            'fonctions' => $fonctions,
        ]);
    }
    /**
     * Affiche le formulaire d'enregistrement d'un film
     *
     * @Route("/film/new", name="film_create")
     * @Route("/film/{id}/edit", name="film_edit")
     */
    public function createFilm(Film $film = null, Request $request, ObjectManager $manager)
    {
        if (!$film) {
            $film = new Film();
        }
        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($film);
            $manager->flush();

            return $this->redirectToRoute('film_show', ['id' => $film->getId
                ()]);

        }
        return $this->render('movie_store/film_create.html.twig', [
            'formFilm' => $form->createView(),
            'editMode' => $film->getId() !== null,

        ]);

    }
    /**
     * Affiche le formulaire d'enregistrement d'une personne
     *
     * @Route("/personne/new", name="person_create")
     * @Route("/personne/{id}/edit", name="person_edit")
     */
    public function createPerson(Personne $personne = null, Request $request, ObjectManager $manager)
    {
        if (!$personne) {
            $personne = new Personne();
        }

        $form = $this->createForm(PersonneType::class, $personne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $manager->persist($personne);
            $manager->flush();

            return $this->redirectToRoute('person_show', ['id' => $personne->getId
                ()]);

        }
        return $this->render('movie_store/person_create.html.twig', [
            'formPerson' => $form->createView(),
            'editMode' => $personne->getId() !== null,

        ]);
    }
}
