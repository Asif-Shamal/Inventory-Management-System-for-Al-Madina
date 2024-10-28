<?php

namespace Tests\Unit\Controllers\Pos;

use Tests\TestCase;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_store_category()
    {
        // Mocking the authenticated user
        Auth::shouldReceive('user')->andReturn((object) ['id' => 1]);

        $request = new Request([
            'name' => 'Test Category'
        ]);

        $controller = new \App\Http\Controllers\Pos\CategoryController();
        $response = $controller->CategoryStore($request);

        // Assert the category was stored in the database
        $this->assertDatabaseHas('categories', [
            'name' => 'Test Category',
            'created_by' => 1
        ]);

        // Assert the session has the expected notification
        $this->assertEquals('success', session('alert-type'));
    }

    /** @test */
    public function it_can_update_category()
    {
        // Mocking the authenticated user
        Auth::shouldReceive('user')->andReturn((object) ['id' => 1]);

        // Create a category first
        $category = Category::create([
            'name' => 'Original Category',
            'created_by' => 1,
            'created_at' => Carbon::now(),
        ]);

        $request = new Request([
            'id' => $category->id,
            'name' => 'Updated Category'
        ]);

        $controller = new \App\Http\Controllers\Pos\CategoryController();
        $response = $controller->CategoryUpdate($request);

        // Assert the category was updated in the database
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Updated Category',
            'updated_by' => 1
        ]);

        // Assert the session has the expected notification
        $this->assertEquals('success', session('alert-type'));
    }

    /** @test */
    public function it_can_delete_category()
    {
        // Mocking the authenticated user
        Auth::shouldReceive('user')->andReturn((object) ['id' => 1]);

        // Create a category first
        $category = Category::create([
            'name' => 'Category to Delete',
            'created_by' => 1,
        ]);

        $controller = new \App\Http\Controllers\Pos\CategoryController();
        $response = $controller->CategoryDelete($category->id);

        // Assert the category was deleted from the database
        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
        ]);

        // Assert the session has the expected notification
        $this->assertEquals('success', session('alert-type'));
    }

    /** @test */
    public function it_can_retrieve_all_categories()
    {
        // Test retrieving all categories
        $controller = new \App\Http\Controllers\Pos\CategoryController();
        $response = $controller->CategoryAll();

        $this->assertInstanceOf(\Illuminate\View\View::class, $response);
        $this->assertArrayHasKey('categoris', $response->getData());
    }

    /** @test */
    public function it_can_return_category_add_view()
    {
        // Test returning the category add view
        $controller = new \App\Http\Controllers\Pos\CategoryController();
        $response = $controller->CategoryAdd();

        $this->assertInstanceOf(\Illuminate\View\View::class, $response);
        $this->assertEquals('backend.category.category_add', $response->name());
    }

    /** @test */
    public function it_can_return_category_edit_view()
    {
        // Test returning the category edit view
        $category = Category::create([
            'name' => 'To Be Edited Category',
            'created_by' => 1,
        ]);

        $controller = new \App\Http\Controllers\Pos\CategoryController();
        $response = $controller->CategoryEdit($category->id);

        $this->assertInstanceOf(\Illuminate\View\View::class, $response);
        $this->assertEquals('backend.category.category_edit', $response->name());
        $this->assertArrayHasKey('category', $response->getData());
    }
}
