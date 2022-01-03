<?php

namespace App\Http\Livewire;

use App\Models\Idea;
use Livewire\Component;
use Illuminate\Http\Response;

class SetStatusAdmin extends Component
{

    public $idea;
    public $status;

    public function mount(Idea $idea)
    {
        # code...
        $this->idea = $idea;
        $this->status = $this->idea->status_id;
    }

    public function setStatus()
    {
        # code...
        if(!auth()->check() || !auth()->user()->isAdmin()){
            abort(Response::HTTP_FORBIDDEN);
        }

        $this->idea->status_id = $this->status;
        $this->idea->save();

        //if(*this->)

        $this->emit('statusWasUpdated');

    }


    public function render()
    {
        return view('livewire.set-status-admin');
    }
}
