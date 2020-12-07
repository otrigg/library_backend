<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;
use App\Models\Book;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'      => 'Admin',
            'username'  => 'Admin',
            'email'     => 'admin@example.com',
            'email_verified_at' => now(),
            'password'  => Hash::make('Admin'),
            'remember_token' => Str::random(10),
        ]);
        User::create([
            'name'      => 'User',
            'username'  => 'user',
            'email'     => 'user@example.com',
            'email_verified_at' => now(),
            'password'  => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);
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
