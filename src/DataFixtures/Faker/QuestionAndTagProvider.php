<?php

namespace App\DataFixtures\Faker;

class QuestionAndTagProvider extends \Faker\Provider\Base{

    protected static $questions = [

        'Is cereal soup? Why or why not?',
        'What is the sexiest and least sexy name?',
        'What secret conspiracy would you like to start?',
        'What’s invisible but you wish people could see?',
        'What’s the weirdest smell you have ever smelled?',
        'Is a hotdog a sandwich? Why or why not?',
        'What’s the best Wi-Fi name you’ve seen?',
        'What’s the most ridiculous fact you know?',
       ' What is something that everyone looks stupid doing?',
        'What is the funniest joke you know by heart?',
        'In 40 years, what will people be nostalgic forr?',
        'What are the unwritten rules of where you work?',
        'How doo you feel about putting pineapple on pizza?',
        'What part of a kid’s movie completely scarred you?',
        'What kind of secret society would you like to start?',
        'If animals could talk, which would be the rudest?',
        'What’s the best type of cheese?',
        'Where is the strangest place you’ve urinated or defecated?',
        'What’s the best inside joke you’ve been a part of?',
        'In one sentence, how would you sum up the internet?',
        'How many chickens would it take to kill an elephant?',
        'What is the most embarrassing thing you have ever worn?',
        'What’s the most imaginative insult you can come up with?',
        'Which body part do you wish you could detach and why?',
        'What used to be considered trashy but now is very classy?',
        'What’s the weirdest thing a guest has done at your house?',
        'What mythical creature would improve the world most if it existed?',
        'What inanimate object do you wish you could eliminate from existence?',
        'What is the weirdest thing you have seen in someone else’s home?',
        'What would be the absolute worst name you could give your child?',
        'What would be the worst thing for the government to make illegal?',
        'What are some of the nicknames you have for customers or coworkers?',
        'If peanut butter wasn’t called peanut butter, what would it be called?',
        'What movie would be greatly improved if it was made into a musical?',
    ];

    protected static $tags = [

        'torture',
        'torture',
        'archery',
        'rugby',
        'boats',
        'elephants',
        'x-rays',
        'carousels',
        'pineapple',
        'turtles',
        'spiritism',
        'sewing machines',
        'firemen',
        'donkeys',
        'dentistry',
        'skull',
        'oil',
        'windmills',
        'women in the army',
        'seesaws',
        'puppets',
        'Europe',
        'airplanes',
        'motorcycles',
        'monkeys',
        'camels',

    ];

    public static function questionTitle(){
        return static::randomElement(static::$questions);
    }
    public static function questionTag(){
        return static::randomElement(static::$tags);
    }

}