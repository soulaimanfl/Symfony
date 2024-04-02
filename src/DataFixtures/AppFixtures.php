<?php

namespace App\DataFixtures;
ini_set('memory_limit', '700M'); // Increase to 256MB or more as needed

use App\Entity\Etablissement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $fichier = 'data/data.csv';
        $file = fopen($fichier, 'r');

        // Ignore l'en-tête du fichier CSV, si présent
        fgetcsv($file, 0, ";");
        $i = 0; // compteur

        while (($line = fgetcsv($file, 0, ";")) !== false) {
            $etablissement = new Etablissement();

            $etablissement->setAppellationOfficielle($line[1]);
            $etablissement->setDenominationPrincipale($line[2]);

            $secteur = strtolower($line[4]);
            if (!in_array($secteur, ['public', 'privé'])) {
                continue;
            }

            $etablissement->setSecteur($secteur);

            $etablissement->setAdresse($line[5]);
            $etablissement->setCommune($line[10]);
            $etablissement->setLatitude((float)$line[14]);
            $etablissement->setLongitude((float)$line[15]);
            $etablissement->setDepartement($line[22]);
            $etablissement->setRegion($line[23]);
            $etablissement->setAcademie($line[24]);

            $dateOuverture = \DateTime::createFromFormat('Y-m-d', $line[34]);
            if ($dateOuverture === false) {
                continue;
            }
            $etablissement->setDateOuverture($dateOuverture);

            $manager->persist($etablissement);

            if (($i % 50) === 0) {
                $manager->flush();
                $manager->clear();
            }
            $i++;
        }

        $manager->flush();
        fclose($file);
    }
}