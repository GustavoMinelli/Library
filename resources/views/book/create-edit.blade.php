<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Livros') }}
        </h2>
    </x-slot>

    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex mb-3">
                <x-primary-link-button href="{{ route('books.index') }}">
                    {{ __('Voltar') }}
                </x-primary-link-button>
            </div>

            @php
                $isEdit = isset($book->id);

                $validationErrors = $errors->all();

                // dd($validationErrors);
            @endphp

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 "> 

                    <form action="{{ url('livros') }}" method="POST" class="">

                        @csrf
                        @method($isEdit ? 'PUT' : 'POST')

                        <input type="hidden" name="id" value="{{ $book->id }}">

                        <div class="flex items-center mb-3">
                            <input id="is_available" name="is_available" type="checkbox" {{ $book->is_available ? 'checked="checked"' : '' }} class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                            <label for="is_available" class="ml-2 block text-sm text-gray-900">
                                Disponível
                            </label>
                        </div>

                        <div class="w-full flex gap-5">
                            
                            <div class="mb-3 w-6/12">
                                <x-input-label for="title" :value="__('Título')" />
                                <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $book->title)" required autofocus autocomplete="title" />
                                <x-input-error class="mt-2" :messages="$errors->get('title')" />
                            </div>
                            
                            <div class="mb-3 w-6/12">
                                <x-input-label for="author" :value="__('Autor')" />
                                <x-text-input id="author" name="author" type="text" class="mt-1 block w-full" :value="old('author', $book->author)" required autofocus autocomplete="author" />
                                <x-input-error class="mt-2" :messages="$errors->get('author')" />
                            </div>

                            <div class="mb-3 w-6/12">

                                <x-input-label for="genre_id" :value="__('Gênero')" />
                                
                                <select id="genre_id" name="genre_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">Selecione um gênero</option>

                                    @foreach($genres as $genre)
                                        <option value="{{ $genre->id }}" {{ $genre->id == old('genre_id', $book->book_genre_id) ? 'selected' : ''  }}>{{ $genre->name }}</option>
                                    @endforeach

                                </select>

                                <x-input-error class="mt-2" :messages="$errors->get('genre_id')" />

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