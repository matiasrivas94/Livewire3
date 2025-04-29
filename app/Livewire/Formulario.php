<?php

namespace App\Livewire;

use App\Livewire\Forms\PostCreateForm;
use App\Livewire\Forms\PostEditForm;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class Formulario extends Component
{
    use WithFileUploads; // Permite la carga de archivos.
    use WithPagination;

    public $categories, $tags; // Variables para almacenar las categorías y etiquetas.
    public $image;

    public PostCreateForm $postCreate;
    public PostEditForm $postEdit;

    //Ciclo de vida de un componente
    public function mount(){
        $this->categories = Category::all();
        $this->tags = Tag::all();
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

        $this->resetPage(pageName: 'pagPosts'); // Reiniciar la paginación al guardar un nuevo post.
        $this->postCreate->reset(); // Limpiar los campos después de guardar.
    } 

    public function edit($postId){

        $this->postEdit->edit($postId);
    }

    public function update(){
        $this->postEdit->update();
    }

    public function destroy($postId){

        $post = Post::find($postId);
        $post->tags()->detach(); // Desvincular las etiquetas del post.
        $post->delete(); // Eliminar el post.
    }

    public function render()
    {
        $posts = Post::orderBy('id','desc')
                    ->paginate(5, pageName: 'pagPosts');
        return view('livewire.formulario', compact('posts'));
    }
}
