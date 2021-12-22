<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Idea extends Model
{
    use HasFactory, Sluggable;

    const PAGINATION_COUNT = 10;
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

}
