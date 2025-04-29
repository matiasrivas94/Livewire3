<?php

namespace App\Livewire;

use App\Livewire\Forms\PostCreateForm;
use App\Livewire\Forms\PostEditForm;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Livewire\Component;
use Livewire\WithFileUploads;

class Formulario extends Component
{
    use WithFileUploads; // Permite la carga de archivos.

    public $categories, $tags; // Variables para almacenar las categorías y etiquetas.
    public $posts; // Variable para almacenar los posts.
    public $image;

    public PostCreateForm $postCreate;
    public PostEditForm $postEdit;

    //Ciclo de vida de un componente
    public function mount(){
        $this->categories = Category::all();
        $this->tags = Tag::all();
        $this->posts = Post::all();
    }

    public function save(){

        $this->postCreate->validate();

        $post = Post::create(
            $this->postCreate->only('title', 'content', 'category_id')
        );
        $post->tags()->attach($this->postCreate->tags); // Asignar las etiquetas seleccionadas al post.

        if($this->image){
            $post->image_path = $this->image->store('posts');
            dd($post->image_path);
            $post->save();
        }

        $this->postCreate->reset(); // Limpiar los campos después de guardar.

        $this->posts = Post::all(); // Actualizar la lista de posts.
    } 

    public function edit($postId){

        $this->postEdit->edit($postId);
    }

    public function update(){

        $this->postEdit->update();
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
