<div>
    <div class="p-6 mb-6 bg-white rounded-lg shadow">
        <form wire:submit="save">

            <div class="mb-4">
                <x-label>
                    Nombre
                </x-label>
                <x-input class="w-full" wire:model="title" required/>
                <x-input-error for="title"/>
            </div>

            <div class="mb-4">
                <x-label>
                    Contenido
                </x-label>
                <x-textarea class="w-full" wire:model="content" required></x-textarea>
                <x-input-error for="content"/>
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
                    <x-input-error for="category_id"/>
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
                <x-input-error for="selectedTags"/>
            </div>

            <div class="flex justify-end">
                <x-button>
                    Crear
                </x-button>
            </div>

        </form>
    </div>

    <div class="p-6 bg-white rounded-lg shadow">
        <h5>Posts Creados</h5>
        <ul class="list-disc list-inside space-y-2">
            @foreach ($posts as $post)
                <li class="flex justify-between" wire:keys="post-{{ $post->id }}">
                    {{ $post->title }}
                   <div>
                        <x-button wire:click="edit({{ $post->id }})"> Editar </x-button>
                        <x-danger-button wire:click="destroy({{ $post->id }})"> Eliminar </x-danger-button>
                   </div>
                </li>
            @endforeach
        </ul>
    </div>

    {{-- Formulario de edicion. Javascript --}}
    {{-- @if ($open)
    <div class="bg-gray-800 bg-opacity-25 fixed inset-0">
        <div class="py-12">
            <div class="max-w-4x1 mx-auto sm:px-6 lg:px-8">
                <div class="p-6 bg-white rounded-lg shadow">

                    <form wire:submit="update">
                        <div class="mb-4">
                            <x-label>
                                Titulo
                            </x-label>
                            <x-input class="w-full" wire:model="postEdit.title" required></x-input>
                        </div>
            
                        <div class="mb-4">
                            <x-label>
                                Contenido
                            </x-label>
                            <x-textarea class="w-full" wire:model="postEdit.content" required></x-textarea>
                        </div>
            
                        <div class="mb-4">
                            <x-label>
                                Categoria
                            </x-label>
                            
                            @if ($categories)
                                <x-select class="w-full" wire:model="postEdit.category_id">
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
                                            <x-checkbox wire:model="postEdit.tags" value="{{$tag->id}}"/>
                                                {{ $tag->name }}
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
            
                        <div class="flex justify-end">
                            <x-button>
                                Actualizar
                            </x-button>
                            <x-danger-button class="mr-2" wire:click="$set('open', false)">
                                Cancelar
                            </x-danger-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif --}}

     {{-- Formulario de edicion. Componente --}}
     <form wire:submit="update">
        <x-dialog-modal wire:model="open">

            <x-slot name="title">
                Actualizar Post
            </x-slot>
            <x-slot name="content">
            
                <div class="mb-4">
                        <x-label>
                            Titulo
                        </x-label>
                        <x-input class="w-full" wire:model="postEdit.title" required></x-input>
                </div>
        
                    <div class="mb-4">
                        <x-label>
                            Contenido
                        </x-label>
                        <x-textarea class="w-full" wire:model="postEdit.content" required></x-textarea>
                    </div>
        
                    <div class="mb-4">
                        <x-label>
                            Categoria
                        </x-label>
                        
                        @if ($categories)
                            <x-select class="w-full" wire:model="postEdit.category_id">
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
                                        <x-checkbox wire:model="postEdit.tags" value="{{$tag->id}}"/>
                                            {{ $tag->name }}
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                
            </x-slot>
            <x-slot name="footer">
                <x-button wire:click="$set('open', false)">
                    Cancelar
                </x-button>
                <x-button>
                    Actualizar
                </x-button>
            </x-slot>

        </x-dialog-modal>  
    </form>
    
</div>
