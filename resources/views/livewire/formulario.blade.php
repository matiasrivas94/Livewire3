<div>
    <div class="p-6 mb-6 bg-white rounded-lg shadow">
        <form wire:submit="save">

            <div class="mb-4">
                <x-label>
                    Nombre
                </x-label>
                <x-input class="w-full" wire:model="title" required></x-input>
            </div>

            <div class="mb-4">
                <x-label>
                    Contenido
                </x-label>
                <x-textarea class="w-full" wire:model="content" required></x-textarea>
            </div>

            <div class="mb-4">
                <x-label>
                    Categoria
                </x-label>
                
                @if ($categories)
                    <x-select class="w-full" wire:model="category_id">
                        <option value="" disabled>Seleccione una categoria</option>
                        @foreach ($categories as $category)
                            <option value="{{$category->id}}">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </x-select>
                @else
                    <p>No hay categorías disponibles.</p>
                @endif
            </div>

            <div class="mb-4">
                <x-label>
                    Etiquetas
                </x-label>

                <ul>
                    @foreach ($tags as $tag)
                        <li>
                            <label>
                                <x-checkbox wire:model="selectedTags" value="{{$tag->id}}"/>
                                    {{ $tag->name }}
                            </label>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="flex justify-end">
                <x-button>
                    Crear
                </x-button>
            </div>

        </form>
    </div>

    <div class="p-6 bg-white rounded-lg shadow">
        <h6>Posts Creados</h6>
        <ul class="list-disc list-inside">
            @foreach ($posts as $post)
                <li>
                    {{ $post->title }}
                </li>
            @endforeach
        </ul>
    </div>
</div>
