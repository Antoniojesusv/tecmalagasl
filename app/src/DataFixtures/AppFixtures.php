<?php

namespace App\DataFixtures;

use App\Entity\Text;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $textsArray = $this->loadTexts();
        foreach ($textsArray as $text) {
            $textEntity = new Text();
            $textEntity->setText($text['text']);
            $manager->persist($textEntity);
        }

        $manager->flush();
    }

    private function loadImages()
    {
        return [
            ['name' => '/image/imagen1'],
            ['name' => '/image/imagen2'],
            ['name' => '/image/imagen3'],
            ['name' => '/image/imagen4'],
            ['name' => '/image/imagen5']
        ];
    }

    private function loadTexts()
    {
        return [
            ['text' => 'Hola yo soy un texto'],
            ['text' => 'Hola yo soy un texto1'],
            ['text' => 'Hola yo soy un texto2'],
            ['text' => 'Hola yo soy un texto3'],
            ['text' => 'Hola yo soy un texto4'],
            ['text' => 'Hola yo soy un texto5'],
            ['text' => 'Hola yo soy un texto6'],
            ['text' => 'Hola yo soy un texto7'],
            ['text' => 'Hola yo soy un texto8'],
            ['text' => 'Hola yo soy un texto9']
        ];
    }

    private function loadProducts()
    { }

    private function loadCharacteristics()
    { }
}
