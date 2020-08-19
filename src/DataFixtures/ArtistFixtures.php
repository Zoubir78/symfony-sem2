<?php

namespace App\DataFixtures;

use App\Entity\Artist;

class ArtistFixtures extends BaseFixture
{
    protected function loadData()
    {
        //Créer 50 artistes
        $this->createMany(50, 'artist',  function(){
            // Construction du nom d'artiste
            return (new Artist())
                ->setName($this->faker->name)
                ->setDescription($this->faker->optional()->realText())
            ;    
        });

        //  // Instanciation de l'entité
        //  $artist = (new Artist())
        //     ->setName($name)
        //     ->setDescription($this->faker->realText(50))
        // ;

        //     // Retourner l'entité
        //     return $artist;
        // });

        // // Enregistrer les entités en BDD
        // $manager->flush();
    }
}