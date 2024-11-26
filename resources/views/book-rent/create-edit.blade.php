<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Aluguel de Livros') }}
        </h2>
    </x-slot>

    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex mb-3">
                <x-primary-link-button href="{{ route('book-rents.index') }}">
                    {{ __('Voltar') }}
                </x-primary-link-button>
            </div>

            @php
                $isEdit = isset($bookRent->id);

                $validationErrors = $errors->all();

            @endphp

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 "> 

                    <form action="{{ url('aluguel-de-livros') }}" method="POST" class="">

                        @csrf
                        @method($isEdit ? 'PUT' : 'POST')

                        <input type="hidden" name="id" value="{{ $bookRent->id }}">

                        <div class="flex items-center mb-3">
                            <input id="is_returned" name="is_returned" type="checkbox" {{ $bookRent->is_returned ? 'checked="checked"' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="is_returned" class="ml-2 block text-sm text-gray-900">
                                Devolvido
                            </label>
                        </div>

                        <div class="flex items-center mb-3">
                            <input id="is_late" name="is_late" type="checkbox" {{ $bookRent->is_late ? 'checked="checked"' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="is_late" class="ml-2 block text-sm text-gray-900">
                                Atrasado
                            </label>
                        </div>

                        <div class="w-full flex gap-5">

                            <div class="mb-3 w-6/12">

                                <x-input-label for="customer_id" :value="__('Cliente')" />
                                
                                <select id="customer_id" name="customer_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">Selecione um cliente</option>

                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ $customer->id == old('customer_id', $bookRent->customer_id) ? 'selected' : ''  }}>{{ $customer->name }}</option>
                                    @endforeach

                                </select>

                                <x-input-error class="mt-2" :messages="$errors->get('customer_id')" />

                            </div>
                            
                            <div class="mb-3 w-6/12">

                                <x-input-label for="book_id" :value="__('Livro')" />
                                
                                <select id="book_id" name="book_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">Selecione um livro</option>

                                    @foreach($books as $book)
                                        <option value="{{ $book->id }}" {{ $book->id == old('book_id', $bookRent->book_id) ? 'selected' : ''  }}>{{ $book->title }}</option>
                                    @endforeach

                                </select>

                                <x-input-error class="mt-2" :messages="$errors->get('book_id')" />

                            </div>

                        </div>
                        
                        <div class="mb-3 w-6/12">

                            <x-input-label for="expired_at" :value="__('Data de devolução')" />
                            
                            <input id="expired_at" name="expired_at" type="date" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('expired_at', $bookRent->expired_at) }}">

                            <x-input-error class="mt-2" :messages="$errors->get('expired_at')" />

                        </div>

                        <div class="flex justify-end">
                            <x-primary-button>{{ __('Salvar') }}</x-primary-button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>