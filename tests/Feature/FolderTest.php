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
   
}
