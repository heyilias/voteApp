<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    
    use RefreshDatabase;

    /** @test */
    public function user_can_generate_gravatar_default_image_when_no_email_found()
    {
        $user = User::factory()->create([
            'name' => 'Andre',
            'email' => 'afakeemail@hotmail.com',
        ]);

        $gravatarUrl = $user->getAvatar();

        $this->assertEquals(
            'https://en.gravatar.com/avatar/'.md5($user->email).'?s=200&d=https://s3.amazonaws.com/laracasts/
             images/forum/avatars/default-avatar-1.png',
             $gravatarUrl
        );

        
        
    } 
}
