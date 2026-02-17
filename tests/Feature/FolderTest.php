<?php

namespace Tests\Feature;

use App\Models\Folder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FolderTest extends TestCase {

    use RefreshDatabase;

    public function test_a_user_can_create_a_folder(): void {

        $user = User::factory()->create();

        Folder::create(['user_id' => $user->id, 'name' => 'Inspiration']);

        $this->assertDatabaseHas('folders', 
        ['name' => 'Inspiration', 'user_id' => $user->id]);
    }

    public function test_a_folder_can_have_subfolders(): void {

        $user = User::factory()->create();

        $parent = Folder::create(['user_id' => $user->id, 'name' => 'Inspiration']);

        Folder::create(['user_id' => $user->id,
        'parent_id' => $parent->id,
        'name' => 'Illustrations']);

        $this->assertDatabaseHas('folders', ['name' => 'Illustrations' , 'parent_id' => $parent->id]);       
    }

    public function test_a_folder_belongs_to_a_user(): void {

        $user = User::factory()->create();

        $folder = Folder::create(['user_id' => $user->id, 'name' => 'Inspiration']);

        $this->assertEquals($user->id, $folder->$user->id);
    }
   
}
