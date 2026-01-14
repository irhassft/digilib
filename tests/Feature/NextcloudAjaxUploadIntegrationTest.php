<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NextcloudAjaxUploadIntegrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_ajax_upload_returns_json_not_500()
    {
        $user = User::factory()->create();
        \Spatie\Permission\Models\Role::create(['name' => 'admin']);
        $user->assignRole('admin');

        $category = Category::create(['name' => 'Ajax', 'slug' => \Illuminate\Support\Str::slug('Ajax')]);

        $response = $this->actingAs($user)->postJson(route('documents.store'), [
            'title' => 'Ajax Upload',
            'description' => 'Ajax Test',
            'category_id' => $category->id,
            'document_file' => UploadedFile::fake()->create('test.pdf', 1000, 'application/pdf'),
        ]);

        // If server returns 500, output body in test failure message
        $this->assertTrue($response->status() < 500, 'Server returned 500. Body: ' . $response->getContent());
    }
}
