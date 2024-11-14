<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Livros') }}
        </h2>
    </x-slot>

    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="flex mb-3 justify-end">
                <x-primary-link-button href="{{ route('books.create') }}">
                    {{ __('Novo Livro') }}
                </x-primary-link-button>
            </div>

            <div class="bg-white overflow-hidden h-[600px] shadow-sm sm:rounded-lg">
                <div class="p-6 h-full flex flex-col text-gray-900">
                    
                    @if (count($books) > 0)
                    <table class="table md:table-auto relative h-full mb-5 table-fixed w-full text-center border-solid">
                        <thead>
                            <tr class="border-solid border-0 border-b border-slate-700">
                                <th class="">ID</th>
                                <th class="">Titulo</th>
                                <th class="">Autor</th>
                                <th class="">Gênero</th>
                                <th>Ações</th>
                            </tr>
                        </thead>

                        <tbody class="h-10">

                            @foreach ($books as $book)

                                <tr class="border-solid border-0 border-b border-slate-700 last:border-transparent">
                                    <td>{{ $book->id }}</td>
                                    <td>{{ $book->title }}</td>
                                    <td>{{ $book->author }}</td>
                                    <td>{{ $book->genre->name }}</td>
                                    <td>
                                        <x-primary-link-button href="{{ url('/livros/'.$book->id.'/editar') }}">
                                            <i class="fas fa-edit"></i></x-primary-link-button>

                                        <x-danger-button
                                                x-data=""
                                                x-on:click.prevent="$dispatch('open-modal', 'confirm-book-delete-{{ $book->id }}')"
                                            ><i class="fas fa-trash"></i></x-danger-button>

                                            <x-modal name="confirm-book-delete-{{ $book->id }}">
                                                <form method="post" action="{{ url("livros/$book->id") }}" class="p-6">

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
                            Nenhum livro cadastrado
                        </div>
                    </div>
                @endif

                {{ $books->links() }}

                </div>
            </div>
        </div>
    </div>

</x-app-layout>