<?php

namespace App\Http\Livewire;

use App\Models\Idea;
use Livewire\Component;
use App\Models\Category;

class EditIdea extends Component
{
    public $idea;
    public $title;
    public $category;
    public $description;

    public function mount(Idea $idea)
    {
        # code...
        $this->idea = $idea;
        $this->title = $idea->title;
        $this->category = $idea->category_id;
        $this->description = $idea->description;

    }

    public function updateIdea()
    {
        # Authorization
        # Validation

        $this->idea->update([
            'title' => $this->title,
            'category_id' => $this->category,
            'description' => $this->description,
        ]);

        $this->emit('ideaWasUpdated');
    }

    public function render()
    {
        return view('livewire.edit-idea',[
            'categories' => Category::all(),
        ]);
    }
}
