<?php

namespace App\Models;

use App\Exceptions\DuplicateVoteException;
use App\Exceptions\VoteNotFoundException;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Idea extends Model
{
    use HasFactory, Sluggable;

    const PAGINATION_COUNT = 10;

    const CATEGORY_TUTORIAL_REQUEST = "Tutorial Request";
    const CATEGORY_SELECTAGO_FEATURE = "Selectago Feature";

    
    protected $guarded = [];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function Category()
    {
        return $this->belongsTo(Category::class);
    }

    public function Status()
    {
        return $this->belongsTo(Status::class);
    }

    public function votes()
    {
        return $this->belongsToMany(User::class, 'votes'); 
    }

    public function isVotedByUser(?User $user)
    {
        if(!$user){
            return false;
        }
        else{
            return Vote::where('user_id', $user->id)
            ->where('idea_id', $this->id)
            ->exists();
        }
        
    }


    public function vote(User $user)
    {
        if($this->isVotedByUser($user)){
            throw new DuplicateVoteException;
        }

        $this->votes_count++;

        Vote::create([
            'idea_id' => $this->id,
            'user_id' => $user->id,
        ]);
    }

    public function removeVote(User $user)
    {
        $voteToDelete = Vote::where('idea_id', $this->id)
            ->where('user_id', $user->id)
            ->first();
            
        if($voteToDelete){
            $voteToDelete->delete();
            $this->votes_count++;
        }
        else{
            throw new VoteNotFoundException;
        }
    }

    /*
    public function getStatusClasses()
    {


        // METHODE ONE 
        // $allStatus=[
        //     'Open' => 'bg-gray-200',
        //     'Considering' => 'bg-purple text-white',
        //     'In Progress' => 'bg-yellow text-white',
        //     'Implemented' => 'bg-green text-white',
        //     'Closed' => 'bg-red text-white',
            
        // ];

        // return $allStatus[$this->status->name];

        //METHODE TWO
        // if($this->status->name === 'Open'){
        //     return 'bg-gray-200';
        // }else if($this->status->name === 'Considering'){
        //     return 'bg-purple text-white';
        // }else if($this->status->name === 'In Progress'){
        //     return 'bg-yellow text-white';
        // }else if($this->status->name === 'Implemented'){
        //     return 'bg-green text-white';
        // }elseif($this->status->name === 'Closed'){
        //     return 'bg-red text-white';
        // }

        // return 'bg-gray-200';
    }
    */

}
