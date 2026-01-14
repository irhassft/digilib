<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NextcloudUploadIntegrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_real_upload_path_shows_500_or_handles_failure_gracefully()
    {
        $user = User::factory()->create();
        \Spatie\Permission\Models\Role::create(['name' => 'admin']);
        $user->assignRole('admin');

        $category = Category::create(['name' => 'Integration', 'slug' => \Illuminate\Support\Str::slug('Integration')]);

        $response = $this->actingAs($user)->post(route('documents.store'), [
            'title' => 'Integration Upload',
            'description' => 'Integration Test',
            'category_id' => $category->id,
            'document_file' => UploadedFile::fake()->create('test.pdf', 1000, 'application/pdf'),
        ]);

        // We don't assume behavior; test should reveal whether a 500 occurs.
        $this->assertNotEquals(419, $response->getStatusCode(), 'CSRF token issue');
        $this->assertNotEquals(500, $response->getStatusCode(), 'Upload flow returned 500');
    }
}
