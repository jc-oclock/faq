<?php

namespace App\DataFixtures;

use Faker;

use Faker\Factory;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\DataFixtures\Faker\QuestionAndTagProvider;

class AppFixtures extends Fixture
{  
    public function load(ObjectManager $manager)
    {
    $generator = Factory::create('en_US');
    //ajout provider custom MovieAndGenreProvider 
    //Note : $generator est attendu dans le constructeur de la classe Base de faker
    $generator->addProvider(new QuestionAndTagProvider($generator));
    $populator = new Faker\ORM\Doctrine\Populator($generator, $manager);
    
    /*
     Faker n'apelle pas le constructeur d'origine donc genres n'est pas setté
     -> effet de bord sur adders qui utilise la methode contains sur du null
    */
    $populator->addEntity('App\Entity\Question', 10, array(
        'title' => function() use ($generator) { return $generator->unique()->questionTitle(); },
        'author' => function() use ($generator) { return $generator->name(); },
        'body' => function() use ($generator) { return $generator->realText($maxNbChars = 500, $indexSize = 2); },
       
    ));
        
    $populator->addEntity('App\Entity\Tag', 10, array(
        'name' => function() use ($generator) { return $generator->unique()->questionTag(); },
    ));
    
    
    $populator->addEntity('App\Entity\Answer', 10, array(
        'author' => function() use ($generator) { return $generator->name(); },
        'body' => function() use ($generator) { return $generator->realText($maxNbChars = 2000, $indexSize = 2); },
    ));

    
    
   
    $inserted = $populator->execute();
    //generated lists
    $questions = $inserted['App\Entity\Question'];
    $tags = $inserted['App\Entity\Tag'];
   
    $answers = $inserted['App\Entity\Answer'];
    foreach ($questions as $question) {
        shuffle($tags);
        // tableau rand en amont => recuperation des 3 premiers donne une valeur unique par rapport a mt rand
        $question->addTag($tags[0]);
        
        $question->addAnswer($answers[0]);
        $question->addAnswer($answers[1]);
        $question->addAnswer($answers[2]);
        $manager->persist($question);
    }
    $manager->flush();
}
}
