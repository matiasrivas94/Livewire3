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
    public $open = false; // Variable para controlar la visibilidad del formulario.
    public $postEditId = '';
    public $postEdit = [
        'title' => '',
        'content' => '',
        'category_id' => '',
        'tags' => []
    ];

    public function mount(){
        $this->categories = Category::all();
        $this->tags = Tag::all();
        $this->posts = Post::all();
    }

    public function save(){

        $this->validate([
            'title' => 'required',
            'content' => 'required',
            'category_id' => 'required | exists:categories,id',
            'selectedTags' => 'required | array'
        ]);

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

    public function edit($postId){

        $this->open = true;

        $this->postEditId = $postId; // Guardar el ID del post a editar.

        $post = Post::find($postId);
        $this->postEdit['title'] = $post->title;
        $this->postEdit['content'] = $post->content;
        $this->postEdit['category_id'] = $post->category_id;
        $this->postEdit['tags'] = $post->tags->pluck('id')->toArray();
    }

    public function update(){

        $post = Post::find($this->postEditId);

       $post->update([
            'title' => $this->postEdit['title'],
            'content' => $this->postEdit['content'],
            'category_id' => $this->postEdit['category_id']
        ]);

        $post->tags()->sync($this->postEdit['tags']);

        $this->reset(['postEditId', 'postEdit', 'open']); // Limpiar los campos después de actualizar.

        $this->posts = Post::all(); // Actualizar la lista de posts.
    }

    public function destroy($postId){

        $post = Post::find($postId);
        $post->tags()->detach(); // Desvincular las etiquetas del post.
        $post->delete(); // Eliminar el post.

        $this->posts = Post::all(); // Actualizar la lista de posts.
    }

    public function render()
    {
        return view('livewire.formulario');
    }
}
