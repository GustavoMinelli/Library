<?php

namespace Database\Seeders;

use App\Models\BookGenre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

/**
 * Seeder de gêneros de livros.
 *
 * @author Gustavo Minelli <gustavo@gustavominelli.com.br>
 * @since 14/11/2024 
 * @version 1.0.0
 */
class BookGenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $genreArr = ['Ficção', 'Romance', 'Terror', 'Fantasia', 'Aventura', 'Biografia', 'História', 'Policial', 'Autoajuda', 'Didático'];

        foreach ($genreArr as $genre) {
            BookGenre::create(['name' => $genre]);
        }

    }
}
