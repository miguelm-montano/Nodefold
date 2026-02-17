<?php

namespace Tests\Feature;

use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TagTest extends TestCase {

    use RefreshDatabase;

    public function test_a_tag_can_be_created(): void {

        Tag::create(['name' => 'modern']);

        $this->assertDatabaseHas('tags', ['name' => 'modern']);
    }

    public function test_a_tag_name_must_be_unique(): void {

        Tag::create(['name' => 'modern']);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Tag::create(['name' => 'modern']);

    }
}
