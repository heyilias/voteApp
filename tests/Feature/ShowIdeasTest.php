<?php

namespace Tests\Feature;

use App\Models\Category;
use Tests\TestCase;
use App\Models\Idea;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowIdeasTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function list_of_ideas_shows_on_main_page()
    {
        $categoryOne = Category::factory()->create(['name'=>'Category 1']);
        $categoryTwo = Category::factory()->create(['name'=>'Category 2']);

        $ideaOne = Idea::factory()->create([
            'title' => 'My First Title',
            'category_id'=>$categoryOne->id,
            'description' => 'Description of my first Idea'
        ]);

        $ideaTwo = Idea::factory()->create([
            'title' => 'My Second Title',
            'category_id'=>$categoryTwo->id,
            'description' => 'Description of my Second Idea'
        ]);

        $response = $this->get(route('idea.index'));

        $response->assertSuccessful();
        $response->assertSee($ideaOne->title);
        $response->assertSee($ideaOne->description);
        $response->assertSee($categoryOne->name);

        $response->assertSee($ideaTwo->title);
        $response->assertSee($ideaTwo->description);
        $response->assertSee($categoryTwo->name);
    }

    /** @test */
    public function single_idea_shows_correctly_on_th_show_page()
    {
        $categoryOne = Category::factory()->create(['name'=>'Category 1']);

        $idea = Idea::factory()->create([
            'category_id'=>$categoryOne->id,
            'title' => 'My First Title',
            'description' => 'Description of my first Idea'
        ]);

        $response = $this->get(route('idea.show', $idea));

        $response->assertSuccessful();
        $response->assertSee($idea->title);
        $response->assertSee($idea->description);
        $response->assertSee($categoryOne->name);
    }

    /** @test */
    public function ideas_pagination_works()
    {
        $categoryOne = Category::factory()->create(['name'=>'Category 1']);

        Idea::factory(Idea::PAGINATION_COUNT + 1)->create([
            'category_id'=>$categoryOne->id,
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

        $ideaOne = Idea::factory()->create([
            'category_id'=>$categoryOne->id,
            'title' => 'My First Title',
            'description' => 'Description of my first idea'
        ]);

        $ideaTwo = Idea::factory()->create([
            'category_id'=>$categoryOne->id,
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
