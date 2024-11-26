<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clientes') }}
        </h2>
    </x-slot>

    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex mb-3">
                <x-primary-link-button href="{{ route('customers.index') }}">
                    {{ __('Voltar') }}
                </x-primary-link-button>
            </div>

            @php
                $isEdit = isset($customer->id);

                $validationErrors = $errors->all();

                // dd($validationErrors);
            @endphp

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 "> 

                    <form action="{{ url('clientes') }}" method="POST" class="">

                        @csrf
                        @method($isEdit ? 'PUT' : 'POST')

                        <input type="hidden" name="id" value="{{ $customer->id }}">

                        <div class="w-full flex gap-5">
                            
                            <div class="mb-3 w-6/12">
                                <x-input-label for="name" :value="__('Nome')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $customer->name)" required autofocus autocomplete="name" />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>
                            
                            <div class="mb-3 w-6/12">
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" name="email" type="text" class="mt-1 block w-full" :value="old('email', $customer->email)" required autofocus autocomplete="email" />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>

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