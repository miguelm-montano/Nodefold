<?php

namespace Tests\Feature;

use App\Models\Resource;
use App\Models\Folder;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResourceTest extends TestCase {

    use RefreshDatabase;

    public function test_a_user_can_create_a_resource(): void {

        $user = User::factory()->create();

        Resource::create(['user_id' => $user->id, 'title' => 'Arial', 'type' => 'font']);

        $this->assertDatabaseHas('resources', ['title' => 'Arial', 'user_id' => $user->id]);
    }

    public function test_a_resource_can_belong_to_a_folder(): void {

        $user = User::factory()->create();

        $folder = Folder::create(['user_id' => $user->id, 'name' => 'Fonts']);

        Resource::create(['user_id' => $user->id, 'folder_id' => $folder->id, 'title' => 'Arial', 'type' => 'font']);

        $this->assertDatabaseHas('resources', ['folder_id' => $folder->id]);
    }

    public function test_a_resource_can_have_tags(): void {

        $user = User::factory()->create();

        $resource = Resource::create(['user_id' => $user->id, 'title' => 'Arial', 'type' => 'font']);

        $tag = Tag::create(['name' => 'modern']);

        $resource->tags()->attach($tag->id);

        $this->assertTrue($resource->tags->contains($tag));

    }
    
   
}
