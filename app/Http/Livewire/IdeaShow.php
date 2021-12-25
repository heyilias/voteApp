<?php

namespace App\Http\Livewire;

use App\Models\Idea;
use Livewire\Component;
use App\Exceptions\VoteNotFoundException;
use App\Exceptions\DuplicateVoteException;

class IdeaShow extends Component
{

    public $idea;
    public $votesCount;
    public $hasVoted;

    protected $listeners = ['statusWasUpdated'];


    public function mount(Idea $idea, $votesCount)
    {
        $this->idea = $idea;
        $this->votesCount = $votesCount;
        $this->hasVoted = $idea->isVotedByUser(auth()->user());
    }

    public function statusWasUpdated()
    {
        # code...
        $this->idea->refresh();
    }

    public function vote()
    {
        if(!auth()->check()){
            return redirect(route('login'));
        }

        if($this->hasVoted){
            try{
                $this->idea->removeVote(auth()->user());

            }catch(VoteNotFoundException $ex){
                //Code
            }
            
            $this->votesCount--;
            $this->hasVoted = false;
        }
        else{
            try{
                $this->idea->vote(auth()->user());
                
            }catch(DuplicateVoteException $ex){
                //Code
            }

            $this->votesCount++;
            $this->hasVoted = true;
        }
    }

    public function render()
    {
        return view('livewire.idea-show');
    }
}
