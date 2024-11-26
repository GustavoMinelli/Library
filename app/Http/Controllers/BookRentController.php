<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRentRequest;
use App\Http\Requests\BookRequest;
use App\Models\Book;
use App\Models\BookRent;
use App\Models\Customer;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class BookRentController extends Controller
{

    private function save(BookRentRequest $request, BookRent $bookRent): bool
    {
        try {

            DB::beginTransaction();

            $bookRent->customer_id = $request->customer_id;
            $bookRent->book_id = $request->book_id;
            $bookRent->expired_at = $request->expired_at;
            $bookRent->is_returned = $request->is_returned ? true : false;
            $bookRent->is_late = $request->is_late ? true : false;
            $bookRent->save();

            $book = Book::find($request->book_id);
            $book->is_available = false;

            if ($bookRent->is_returned) {
                $book->is_available = true;
            }
            
            $book->save();

            DB::commit();

            return true;

        } catch (\Exception $e) {

            DB::rollBack();
            Log::info('[BOOK-RENT-CONTROLLER][SAVE] Erro ao salvar aluguel de livro: ' . $e->getMessage());
            return false;

        }

    }

    private function form(BookRent $bookRent): View
    {

        $books = Book::orderBy('id')->get();
        
        if ($bookRent->id) {
            //Insere o book id na collection de books
            $books->push($bookRent->book);
        }

        $customers = Customer::orderBy('id')->get();

        $data = [
            'bookRent' => $bookRent,
            'books' => $books,
            'customers' => $customers,
        ];

        return view('book-rent.create-edit', $data);
    }

    public function index(): View
    {
        $bookRents = BookRent::search()->orderBy('id', 'desc')->paginate(10);
        
        return view('book-rent.index', ['bookRents' => $bookRents]);
    }

    /**
     * Carraga a view de cadastro de aluguel de livro
     *
     * @return View
     */
    public function create(): View
    {
        return $this->form(new BookRent());
    }

    /**
     * Carrega a view de edição de aluguel de livro
     *
     * @param BookRent $bookRent
     * @return View
     */
    public function edit(BookRent $bookRent): View
    {
        return $this->form($bookRent);
    }

    /**
     * Insere um novo aluguel de livro no banco de dados
     *
     * @param BookRentRequest $request
     * @return RedirectResponse
     */
    public function insert(BookRentRequest $request): RedirectResponse
    {
        
        if ($this->save($request, new BookRent())) {
            return redirect()->route('book-rents.index')->with('success', 'Aluguel de livro cadastrado com sucesso!');
        }

        return redirect()->route('book-rents.create')->with('error', 'Erro ao cadastrar aluguel de livro!');
    }

    public function update(BookRentRequest $request): RedirectResponse
    {
        $bookRent = BookRent::find($request->id);

        if (!$bookRent) {
            return redirect()->route('book-rents.index')->with('error', 'Aluguel de livro não encontrado!');
        }

        if ($this->save($request, $bookRent)) {
            return redirect()->route('book-rents.index')->with('success', 'Aluguel de livro atualizado com sucesso!');
        }

        return redirect()->route('book-rents.edit', $bookRent->id)->with('error', 'Erro ao atualizar aluguel de livro!');

    }

    public function destroy(BookRent $bookRent): RedirectResponse
    {

        try {

            DB::beginTransaction();

            $book = Book::find($bookRent->book_id);
            $book->is_available = true;

            $bookRent->delete();

            DB::commit();

            return redirect()->route('book-rents.index')->with('success', 'Aluguel de livro excluído com sucesso!');

        } catch (\Exception $e) {

            DB::rollBack();
            Log::info('[BOOK-RENT-CONTROLLER][DESTROY] Erro ao excluir aluguel de livro: ' . $e->getMessage());
            return redirect()->route('book-rents.index')->with('error', 'Erro ao excluir aluguel de livro!');

        }

    }

}
