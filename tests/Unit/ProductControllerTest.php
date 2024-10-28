<?php

namespace Tests\Unit\Controllers\Pos;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use App\Models\Unit;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_store_product()
    {
        // Mock authenticated user
        Auth::shouldReceive('user')->andReturn(User::factory()->create());

        $supplier = Supplier::factory()->create();
        $category = Category::factory()->create();
        $unit = Unit::factory()->create();

        $request = new Request([
            'name' => 'Test Product',
            'supplier_id' => $supplier->id,
            'unit_id' => $unit->id,
            'category_id' => $category->id,
        ]);

        $controller = new \App\Http\Controllers\Pos\ProductController();
        $response = $controller->ProductStore($request);

        // Assert the product was stored in the database
        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'supplier_id' => $supplier->id,
            'unit_id' => $unit->id,
            'category_id' => $category->id,
            'created_by' => Auth::user()->id,
        ]);

        // Assert the session has the expected notification
        $this->assertEquals('success', session('alert-type'));
    }

    /** @test */
    public function it_can_update_product()
    {
        // Mock authenticated user
        Auth::shouldReceive('user')->andReturn(User::factory()->create());

        // Create a product first
        $product = Product::create([
            'name' => 'Original Product',
            'supplier_id' => Supplier::factory()->create()->id,
            'unit_id' => Unit::factory()->create()->id,
            'category_id' => Category::factory()->create()->id,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        $supplier = Supplier::factory()->create();
        $category = Category::factory()->create();
        $unit = Unit::factory()->create();

        $request = new Request([
            'id' => $product->id,
            'name' => 'Updated Product',
            'supplier_id' => $supplier->id,
            'unit_id' => $unit->id,
            'category_id' => $category->id,
        ]);

        $controller = new \App\Http\Controllers\Pos\ProductController();
        $response = $controller->ProductUpdate($request);

        // Assert the product was updated in the database
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Product',
            'supplier_id' => $supplier->id,
            'unit_id' => $unit->id,
            'category_id' => $category->id,
            'updated_by' => Auth::user()->id,
        ]);

        // Assert the session has the expected notification
        $this->assertEquals('success', session('alert-type'));
    }

    /** @test */
    public function it_can_delete_product()
    {
        // Mock authenticated user
        Auth::shouldReceive('user')->andReturn(User::factory()->create());

        // Create a product first
        $product = Product::create([
            'name' => 'Product to Delete',
            'supplier_id' => Supplier::factory()->create()->id,
            'unit_id' => Unit::factory()->create()->id,
            'category_id' => Category::factory()->create()->id,
            'created_by' => Auth::user()->id,
        ]);

        $controller = new \App\Http\Controllers\Pos\ProductController();
        $response = $controller->ProductDelete($product->id);

        // Assert the product was deleted from the database
        $this->assertDatabaseMissing('products', [
            'id' => $product->id,
        ]);

        // Assert the session has the expected notification
        $this->assertEquals('success', session('alert-type'));
    }

    /** @test */
    public function it_can_retrieve_all_products()
    {
        // Test retrieving all products
        $controller = new \App\Http\Controllers\Pos\ProductController();
        $response = $controller->ProductAll();

        $this->assertInstanceOf(\Illuminate\View\View::class, $response);
        $this->assertArrayHasKey('product', $response->getData());
    }

    /** @test */
    public function it_can_return_product_add_view()
    {
        // Test returning the product add view
        $controller = new \App\Http\Controllers\Pos\ProductController();
        $response = $controller->ProductAdd();

        $this->assertInstanceOf(\Illuminate\View\View::class, $response);
        $this->assertEquals('backend.product.product_add', $response->getName());
    }

    /** @test */
    public function it_can_return_product_edit_view()
    {
        // Create a product first
        $product = Product::create([
            'name' => 'Product to Edit',
            'supplier_id' => Supplier::factory()->create()->id,
            'unit_id' => Unit::factory()->create()->id,
            'category_id' => Category::factory()->create()->id,
            'created_by' => Auth::user()->id,
        ]);

        // Test returning the product edit view
        $controller = new \App\Http\Controllers\Pos\ProductController();
        $response = $controller->ProductEdit($product->id);

        $this->assertInstanceOf(\Illuminate\View\View::class, $response);
        $this->assertEquals('backend.product.product_edit', $response->getName());
        $this->assertArrayHasKey('product', $response->getData());
    }

    /** @test */
    public function it_can_generate_product_wise_report_csv()
    {
        // Test generating product wise CSV report
        $controller = new \App\Http\Controllers\Pos\ProductController();
        $response = $controller->productWiseReportCsv();

        // Assert response is a file download
        $this->assertTrue($response->getFile()->isFile());
    }
}
