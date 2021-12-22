<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Idea;
use App\Models\Status;
use App\Models\Category;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowIdeasTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function list_of_ideas_shows_on_main_page()
    {

        
        $statusOpen =Status::factory()->create(['name' => 'Open','classes' =>'bg-gray-200']);
        $statusConsidering =Status::factory()->create(['name' => 'Considering','classes'=> 'bg-purple text-white']);
        
        $categoryOne = Category::factory()->create(['name'=>'Category 1']);
        $categoryTwo = Category::factory()->create(['name'=>'Category 2']);

        $ideaOne = Idea::factory()->create([
            'title' => 'My First Title',
            'category_id'=>$categoryOne->id,
            'status_id'=> $statusOpen->id,
            'description' => 'Description of my first Idea'
        ]);

        $ideaTwo = Idea::factory()->create([
            'title' => 'My Second Title',
            'category_id'=>$categoryTwo->id,
            'status_id'=> $statusConsidering->id,
            'description' => 'Description of my Second Idea'
        ]);

        $response = $this->get(route('idea.index'));

        $response->assertSuccessful();
        $response->assertSee($ideaOne->title);
        $response->assertSee($ideaOne->description);
        $response->assertSee($categoryOne->name);
        $response->assertSee('<div class="bg-gray-200 text-xxs font-semibold uppercase leading-none rounded-full
        text-center w-28 h-7 px-4 py-2">Open</div>',false);

        $response->assertSee($ideaTwo->title);
        $response->assertSee($ideaTwo->description);
        $response->assertSee($categoryTwo->name);
        $response->assertSee('<div class="bg-purple text-white text-xxs font-semibold uppercase leading-none rounded-full
        text-center w-28 h-7 px-4 py-2">Considering</div>',false);
        
    }

    /** @test */
    public function single_idea_shows_correctly_on_th_show_page()
    {
        $categoryOne = Category::factory()->create(['name'=>'Category 1']);
        $statusOpen =Status::factory()->create(['name' => 'Open','classes' =>'bg-gray-200']);

        $idea = Idea::factory()->create([
            'category_id'=>$categoryOne->id,
            'status_id'=>$statusOpen->id,
            'title' => 'My First Title',
            'description' => 'Description of my first Idea'
        ]);

        $response = $this->get(route('idea.show', $idea));

        $response->assertSuccessful();
        $response->assertSee($idea->title);
        $response->assertSee($idea->description);
        $response->assertSee($categoryOne->name);
        $response->assertSee('<div class="bg-gray-200 text-xxs font-semibold uppercase leading-none rounded-full
        text-center w-28 h-7 px-4 py-2">Open</div>',false);
    }

    /** @test */
    public function ideas_pagination_works()
    {
        $categoryOne = Category::factory()->create(['name'=>'Category 1']);
        $statusOpen =Status::factory()->create(['name' => 'Open','classes' =>'bg-gray-200']);


        Idea::factory(Idea::PAGINATION_COUNT + 1)->create([
            'category_id'=>$categoryOne->id,
            'status_id'=>$statusOpen->id,
        ]);

        $ideaOne = Idea::find(1);
        $ideaOne->title = 'My First Idea';
        $ideaOne->save();

        $ideaElevent = Idea::find(11);
        $ideaElevent->title = 'My Elevent Idea';
        $ideaElevent->save();

        $response = $this->get('/');

        $response->assertSee($ideaOne->title);
        $response->assertDontSee($ideaElevent->title);

        $response = $this->get('/?page=2');

        $response->assertSee($ideaElevent->title);
        $response->assertDontSee($ideaOne->title);

    }

    /** @test */
    public function same_idea_title_different_slug()
    {
        $categoryOne = Category::factory()->create(['name'=>'Category 1']);
        $statusOpen =Status::factory()->create(['name' => 'Open','classes' =>'bg-gray-200']);

        $ideaOne = Idea::factory()->create([
            'category_id'=>$categoryOne->id,
            'status_id'=>$statusOpen->id,
            'title' => 'My First Title',
            'description' => 'Description of my first idea'
        ]);

        $ideaTwo = Idea::factory()->create([
            'category_id'=>$categoryOne->id,
            'status_id'=>$statusOpen->id,
            'title' => 'My First Title',
            'description' => 'Another Description of my first idea'
        ]);

        $response = $this->get(route('idea.show',$ideaOne));

        $response->assertSuccessful();
        $this->assertTrue(request()->path() === 'ideas/my-first-idea');

        $response = $this->get(route('idea.show',$ideaTwo));

        $response->assertSuccessful();
        $this->assertTrue(request()->path() === 'ideas/my-first-idea-1');
    }
}
