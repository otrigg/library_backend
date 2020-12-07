<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;
use App\Models\Book;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();
        \App\Models\Author::factory(10)->create();

        $authors = Author::all();

        foreach ($authors as $author) {
            $booksNumber = rand(1, 10);

            for ($i = 0; $i < $booksNumber; $i++) {
                $book = new Book;
                $faker = Faker::create();
                $book->create([
                    'author_id' => $author->id,
                    'title'     => $faker->sentence(6),
                    'year'      => $faker->year(),
                    'isbn'      => $faker->isbn13
                ]);
            }
        }
    }
}
