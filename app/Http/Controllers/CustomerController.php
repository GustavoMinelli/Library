<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{

    /**
     * Salva um cliente no banco de dados.
     *
     * @param CustomerRequest $request
     * @param Customer $customer
     * @return boolean
     */
    private function save(CustomerRequest $request, Customer $customer): bool
    {
        try {

            DB::beginTransaction();

            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->save();

            DB::commit();

            return true;

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('[CUSTOMER-CONTROLLER][SAVE] Erro ao salvar cliente: ' . $e->getMessage());
            return false;
        }
        
    }

    /**
     * Carrega o formulário de criação/edição de um cliente.
     *
     * @param Customer $customer
     * @return View
     */
    private function form(Customer $customer): View
    {
        $data = [
            'customer' => $customer,
        ];

        return view('customer.create-edit', $data);
    }

    /**
     * Carrega a lista de clientes.
     *
     * @return View
     */
    public function index(): View
    {
        return view('customer.index', [
            'customers' => Customer::orderBy('id')->paginate(10),
        ]);
    }


    /**
     * Carrega o formulário de criação de um cliente.
     *
     * @return View
     */
    public function create(): View
    {   
        return $this->form(new Customer());
    }

    /**
     * Insere um novo cliente.
     *
     * @param CustomerRequest $request
     * @return RedirectResponse
     */
    public function insert(CustomerRequest $request): RedirectResponse
    {
        $customer = new Customer();

        if ($this->save($request, $customer)) {
            return redirect()->route('customers.index')->with('success', 'Cliente salvo com sucesso!');
        }

        return redirect()->route('customers.create')->with('error', 'Erro ao salvar cliente!');

    }

    /**
     * Carrega o formulário de edição de um cliente.
     *
     * @param Customer $customer
     * @return View
     */
    public function edit(Customer $customer): View
    {
        return $this->form($customer);
    }

    /**
     * Atualiza um cliente.
     *
     * @param CustomerRequest $request
     * @return RedirectResponse
     */
    public function update(CustomerRequest $request): RedirectResponse
    {
        $customer = Customer::find($request->id);

        if ($this->save($request, $customer)) {
            return redirect()->route('customers.index')->with('success', 'Cliente atualizado com sucesso!');
        }

        return redirect()->route('customers.edit', $customer->id)->with('error', 'Erro ao atualizar cliente!');
    }

    /**
     * Deleta um cliente.
     *
     * @param Customer $customer
     * @return RedirectResponse
     */
    public function destroy(Customer $customer): RedirectResponse
    {
        try {

            $customer->delete();

            return redirect()->route('customers.index')->with('success', 'Cliente deletado com sucesso!');

        } catch (\Exception $e) {
            Log::error('[CUSTOMER-CONTROLLER][DESTROY] Erro ao deletar cliente: ' . $e->getMessage());
            return redirect()->route('customers.index')->with('error', 'Erro ao deletar cliente!');
        }
    }


}
