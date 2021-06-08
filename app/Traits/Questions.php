<?php

namespace App\Traits;

Trait Questions {
    protected $faker;

    function __construct() {
        $this->faker = \Faker\Factory::create();
    }

    public function getQuestions() {
        $questions = [];

        while(count($questions) < 10) {
            $countryName = strtoupper($this->faker->country());

            // Make sure only single word country name and max 9 characters
            if(strpos($countryName, ' ') !== false || strlen($countryName) > 9 || $this->findQuestion($questions, $countryName)) continue;

            $questions[] = [
                'question' => $countryName,
                'scrambled' => $this->faker->shuffle($countryName)
            ];            
        }

        return $questions;
    }

    private function findQuestion($questions, $value) {
        foreach($questions as $item) {
            if($item['question'] == $value) return true;
        }

        return false;
    }
}