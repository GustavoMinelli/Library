<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clientes') }}
        </h2>
    </x-slot>

    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex mb-3 justify-end">
                <x-primary-link-button href="{{ route('customers.create') }}">
                    {{ __('Novo cliente') }}
                </x-primary-link-button>
            </div>

            <div class="bg-white overflow-hidden h-[600px] shadow-sm sm:rounded-lg">
                <div class="p-6 h-full flex flex-col text-gray-900">
                    
                    @if (count($customers) > 0)
                    <table class="table md:table-auto relative h-full mb-5 table-fixed w-full text-center border-solid">
                        <thead>
                            <tr class="border-solid border-0 border-b border-slate-700">
                                <th class="">ID</th>
                                <th class="">Nome</th>
                                <th class="">Email</th>
                                <th>Ações</th>
                            </tr>
                        </thead>

                        <tbody class="h-10">

                            @foreach ($customers as $customer)

                                <tr class="border-solid border-0 border-b border-slate-700 last:border-transparent">
                                    <td>{{ $customer->id }}</td>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>
                                        <x-primary-link-button href="{{ url('/clientes/'.$customer->id.'/editar') }}">
                                            <i class="fas fa-edit"></i></x-primary-link-button>

                                        <x-danger-button
                                                x-data=""
                                                x-on:click.prevent="$dispatch('open-modal', 'confirm-customer-delete-{{ $customer->id }}')"
                                            ><i class="fas fa-trash"></i></x-danger-button>

                                            <x-modal name="confirm-customer-delete-{{ $customer->id }}">
                                                <form method="post" action="{{ url("clientes/$customer->id") }}" class="p-6">

                                                    @csrf
                                                    @method('DELETE')
                                        
                                                    <h2 class="text-lg font-medium text-gray-900">
                                                        {{ __('Esta ação irá remover o registro do sistema, deseja realmente continuar?') }}
                                                    </h2>
                                        
                                                    <div class="mt-6 flex justify-end">
                                                        <x-secondary-button x-on:click="$dispatch('close')">
                                                            {{ __('Cancelar') }}
                                                        </x-secondary-button>
                                        
                                                        <x-danger-button class="ml-3">
                                                            {{ __('Remover') }}
                                                        </x-danger-button>
                                                    </div>
                                                </form>
                                            </x-modal>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="flex flex-col items-center justify-center">
                        <div class="text-gray-900 text-2xl font-bold mb-2 mt-10">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="text-gray-900 text-2xl font-bold mb-2">
                            Nenhum cliente cadastrado
                        </div>
                    </div>
                @endif

                {{ $customers->links() }}

                </div>
            </div>
        </div>
    </div>

</x-app-layout>