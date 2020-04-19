<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
//        factory(\App\User::class, 5)
//            ->create()
//            ->each(function($user){
//               for($i=1; $i<rand(5,10); $i++){
//                   $user->questions()->create(factory(App\Question::class)->make()->toArray());
//               }
//            });
        factory(\App\User::class , 5)
            ->create()
            ->each(function ($user){
                $user->questions()
                    ->saveMany(
                        factory(\App\Question::class,rand(2,5))->make()
                    )->each(function ($question){
                        $question->answers()
                            ->saveMany(
                                factory(\App\Answer::class,rand(2,7))->make()
                            );
                    });
            });
    }
}
/*
 * Laravel ke paas 2 tarah ke create() hai.
 * Ek jo object hai class ka uspe kaam karega aur ek jo object lega details wala.
 * saveMany(object)
 * create(array)
 * */