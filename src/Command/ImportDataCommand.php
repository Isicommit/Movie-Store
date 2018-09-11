<?php

namespace App\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use App\Entity\Film;

class ImportDataCommand extends ContainerAwareCommand 
{

    protected function configure()
    {
        $this->setName('app:import-data');
        $this->setDescription('import des données de themovieDB');
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //on importe la clé de l'api spécifiée dans les paramètres de l'appli
        $key = $this->getContainer()->getParameter('app.import_key');
        //on construit l'URL permettant de récupérer une liste de films sur themoviedb et on les récupère
        $url = "https://api.themoviedb.org/3/list/1?api_key=" . $key;
        $raw = file_get_contents($url);
        $data = json_decode($raw, true, 512, JSON_BIGINT_AS_STRING);
        $manager = $this->getContainer()->get('doctrine')->getManager();
        //gestion de l'entité Film
       

        $array_films = $data['items'];

        for ($i = 0; $i < 5; $i++) {
            $film = new Film();



            $film->setTitre($array_films[$i]['title'])
            ->setDateReal(new \Datetime($array_films[$i]['release_date']))
            ->setDescription($array_films[$i]['overview'])
            ->setImage($array_films[$i]['poster_path']);

            $manager->persist($film);

        }
        $manager->flush();


        return $array_films;

    }
}
