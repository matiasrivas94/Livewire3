<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Livewire\Component;

class Formulario extends Component
{

    public $categories, $tags; // Variables para almacenar las categorías y etiquetas.
    public $category_id = '', $title, $content; // Variables para almacenar los datos del formulario.
    public $selectedTags = []; // Variable para almacenar las etiquetas seleccionadas.
    public $posts; // Variable para almacenar los posts.

    public function mount(){
        $this->categories = Category::all();
        $this->tags = Tag::all();
        $this->posts = Post::all();
    }

    public function save(){

        // Forma 1
        // $post = Post::create([
        //     'title' => $this->title,
        //     'content' => $this->content,
        //     'category_id' => $this->category_id
        // ]);

        // Forma 2
        $post = Post::create(
            $this->only(['title', 'content', 'category_id']) // Recoger los campos del formulario.
        );

        $post->tags()->attach($this->selectedTags); // Asignar las etiquetas seleccionadas al post.

        $this->reset(['title', 'content', 'category_id', 'selectedTags']); // Limpiar los campos después de guardar.

        $this->posts = Post::all(); // Actualizar la lista de posts.
    } 

    public function render()
    {
        return view('livewire.formulario');
    }
}
