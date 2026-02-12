<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::insert([
            [
                'title' => 'Clean Code',
                'author' => 'Robert C. Martin',
                'publisher' => 'Prentice Hall',
                'publication_year' => 2008,
                'category' => 'Programming',
                'isbn' => '9780132350884',
                'status' => 'available',
                'stock' => 5,
                'cover_url' => null,
                'pdf_path' => null,
                'summary' => 'A Handbook of Agile Software Craftsmanship.'
            ],
            [
                'title' => 'Design Patterns',
                'author' => 'Erich Gamma et al.',
                'publisher' => 'Addison-Wesley',
                'publication_year' => 1994,
                'category' => 'Programming',
                'isbn' => '9780201633610',
                'status' => 'available',
                'stock' => 3,
                'cover_url' => null,
                'pdf_path' => null,
                'summary' => 'Elements of Reusable Object-Oriented Software.'
            ],
            [
                'title' => 'Refactoring',
                'author' => 'Martin Fowler',
                'publisher' => 'Addison-Wesley',
                'publication_year' => 1999,
                'category' => 'Programming',
                'isbn' => '9780201485677',
                'status' => 'available',
                'stock' => 4,
                'cover_url' => null,
                'pdf_path' => null,
                'summary' => 'Improving the Design of Existing Code.'
            ],
        ]);
    }
}
