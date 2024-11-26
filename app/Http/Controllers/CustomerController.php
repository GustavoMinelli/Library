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

    private function form(Customer $customer): View
    {
        $data = [
            'customer' => $customer,
        ];

        return view('customer.create-edit', $data);
    }


    public function index(): View
    {
        return view('customer.index', [
            'customers' => Customer::orderBy('id')->paginate(10),
        ]);
    }


    public function create(): View
    {   
        return $this->form(new Customer());
    }

    public function insert(CustomerRequest $request): RedirectResponse
    {
        $customer = new Customer();

        if ($this->save($request, $customer)) {
            return redirect()->route('customers.index')->with('success', 'Cliente salvo com sucesso!');
        }

        return redirect()->route('customers.create')->with('error', 'Erro ao salvar cliente!');

    }

    public function edit(Customer $customer): View
    {
        return $this->form($customer);
    }

    public function update(CustomerRequest $request): RedirectResponse
    {
        $customer = Customer::find($request->id);

        if ($this->save($request, $customer)) {
            return redirect()->route('customers.index')->with('success', 'Cliente atualizado com sucesso!');
        }

        return redirect()->route('customers.edit', $customer->id)->with('error', 'Erro ao atualizar cliente!');
    }

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
