<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Models\Book;
use App\Models\BookGenre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class BookController extends Controller
{
    /**
     * Salva um livro no banco de dados.
     *
     * @return void
     */
    private function save(BookRequest $request, Book $book): bool
    {

        try {

            DB::beginTransaction();

            $book->title = $request->title;
            $book->author = $request->author;
            $book->book_genre_id = $request->genre_id;
            $book->is_available = $request->is_available ? true : false;
            $book->save();
            
            DB::commit();

            return true;

        } catch (\Exception $e) {

            DB::rollBack();
            Log::info('[BOOK-CONTROLLER][SAVE] Erro ao salvar livro: ' . $e->getMessage());
            return false;

        }

    }

    /**
     * Carrega o formulário de criação/edição de um livro.
     *
     * @return View
     */
    private function form(Book $book): View
    {
        $data = [
            'book' => $book,
            'genres' => BookGenre::orderBy('id')->get(),
        ];

        return view('book.create-edit', $data);
    }

    /**
     * Retorna a view de listagem de livros.
     *
     * @return View
     */
    public function index(): View
    {
        $books = Book::orderBy('id')->paginate(10);

        $data = [
            'books' => $books,
        ];

        return view('book.index', $data);
    }

    /**
     * Criar um novo livro.
     *
     * @return void
     */
    public function create()
    {
        return $this->form(new Book());
    }

    /**
     * Insere um novo livro dentro do banco de dados.
     *
     * @param BookRequest $request
     * @return void
     */
    public function insert(BookRequest $request)
    {

        dd($request->all());

        if ($this->save($request, new Book())) {
            return redirect('books.index')->with('success', 'Livro criado com sucesso!');
        }

        return redirect('books.create')->whith('error', 'Não foi possível inserir o livro. Tente novamente mais tarde.');

    }

    /**
     * Abre o formulário de edição de um livro.
     *
     * @param Book $book
     * @return void
     */
    public function edit(Book $book)
    {
        if (!$book) {
            return redirect('books.index')->with('error', 'Livro não encontrado.');
        }

        return $this->form($book);

    }

    public function update(BookRequest $request)
    {
        $book = Book::find($request->id);

        // dd($request->all());

        if (!$book) {
            return redirect()->route('books.index')->with('error', 'Livro não encontrado.');
        }

        if ($this->save($request, $book)) {
            return redirect()->route('books.index')->with('success', 'Livro atualizado com sucesso!');
        }

        return redirect()->route('books.index')->whith('error', 'Não foi possível atualizar o livro. Tente novamente mais tarde.');

    }
}
