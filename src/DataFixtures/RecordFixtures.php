<?php

namespace App\DataFixtures;

use App\Entity\Note;
use App\Entity\Record;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class RecordFixtures extends BaseFixture implements DependentFixtureInterface
{
    protected function loadData()
    {
        $this->createMany(100, 'record', function () {
            $record = (new Record())
                ->setTitle($this->faker->catchPhrase)
                ->setDescription($this->faker->optional()->realText())
                ->setReleaseAt($this->faker->dateTimeBetween('-2 years'))
                ->setArtist($this->getRandomReference('artist'))
                ->setLabel($this->faker->boolean(75) ? $this->getRandomReference('label') : null)
            ;

            // Création des notes de l'album

            $nbUsers = $this->faker->numberBetween(0, 10);
            $users = $this->getRandomReference('user', $nbUsers);

            // Création des notes
            foreach ($users as $user) {

                $note = (new Note())
                    ->setUser($user)
                    ->setValue($this->faker->numberBetween(0, 10))
                    ->setCreatedAt($this->faker->dateTimeBetween($record->getReleaseAt()))
                ;

                // Ajout de la note au Record
                $record->addNote($note);
            }

            return $record;
        });

        // $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ArtistFixtures::class,
            LabelFixtures::class,
        ];
    }
}