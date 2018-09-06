<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

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
        $key =  $this->getContainer()->getParameter('app.import_key');
        //on construit l'URL permettant de récupérer une liste de films sur themoviedb et on les récupère
        $url = "https://api.themoviedb.org/3/list/1?api_key=".$key;
        $raw = file_get_contents($url);
        $data = json_decode($raw, true, 512, JSON_BIGINT_AS_STRING);

        return $data;
       
    }
}