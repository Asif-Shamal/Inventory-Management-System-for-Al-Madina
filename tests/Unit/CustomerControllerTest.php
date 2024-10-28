<?php

namespace Tests\Unit\Controllers\Pos;

use Tests\TestCase;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;

class CustomerControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_store_customer()
    {
        // Mocking the authenticated user
        Auth::shouldReceive('user')->andReturn((object) ['id' => 1]);

        // Mocking file upload
        Storage::fake('public');
        $file = UploadedFile::fake()->image('customer.jpg');

        $request = new Request([
            'name' => 'Test Customer',
            'mobile_no' => '1234567890',
            'email' => 'test@example.com',
            'address' => '123 Test St',
            'customer_image' => $file
        ]);

        $controller = new \App\Http\Controllers\Pos\CustomerController();
        $response = $controller->CustomerStore($request);

        // Assert the customer was stored in the database
        $this->assertDatabaseHas('customers', [
            'name' => 'Test Customer',
            'mobile_no' => '1234567890',
            'email' => 'test@example.com',
            'address' => '123 Test St',
            'created_by' => 1
        ]);

        // Assert the session has the expected notification
        $this->assertEquals('success', session('alert-type'));
    }

    /** @test */
    public function it_can_update_customer()
    {
        // Mocking the authenticated user
        Auth::shouldReceive('user')->andReturn((object) ['id' => 1]);

        // Create a customer first
        $customer = Customer::create([
            'name' => 'Original Customer',
            'mobile_no' => '1234567890',
            'email' => 'original@example.com',
            'address' => '123 Original St',
            'created_by' => 1,
            'created_at' => Carbon::now(),
        ]);

        // Mocking file upload
        Storage::fake('public');
        $file = UploadedFile::fake()->image('updated_customer.jpg');

        $request = new Request([
            'id' => $customer->id,
            'name' => 'Updated Customer',
            'mobile_no' => '0987654321',
            'email' => 'updated@example.com',
            'address' => '123 Updated St',
            'customer_image' => $file
        ]);

        $controller = new \App\Http\Controllers\Pos\CustomerController();
        $response = $controller->CustomerUpdate($request);

        // Assert the customer was updated in the database
        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
            'name' => 'Updated Customer',
            'mobile_no' => '0987654321',
            'email' => 'updated@example.com',
            'address' => '123 Updated St',
            'updated_by' => 1
        ]);

        // Assert the session has the expected notification
        $this->assertEquals('success', session('alert-type'));
    }

    /** @test */
    public function it_can_delete_customer()
    {
        // Mocking the authenticated user
        Auth::shouldReceive('user')->andReturn((object) ['id' => 1]);

        // Create a customer first
        $customer = Customer::create([
            'name' => 'Customer to Delete',
            'mobile_no' => '1234567890',
            'email' => 'delete@example.com',
            'address' => '123 Delete St',
            'created_by' => 1,
        ]);

        $controller = new \App\Http\Controllers\Pos\CustomerController();
        $response = $controller->CustomerDelete($customer->id);

        // Assert the customer was deleted from the database
        $this->assertDatabaseMissing('customers', [
            'id' => $customer->id,
        ]);

        // Assert the session has the expected notification
        $this->assertEquals('success', session('alert-type'));
    }

    /** @test */
    public function it_can_retrieve_all_customers()
    {
        // Test retrieving all customers
        $controller = new \App\Http\Controllers\Pos\CustomerController();
        $response = $controller->CustomerAll();

        $this->assertInstanceOf(\Illuminate\View\View::class, $response);
        $this->assertArrayHasKey('customers', $response->getData());
    }

    /** @test */
    public function it_can_return_customer_add_view()
    {
        // Test returning the customer add view
        $controller = new \App\Http\Controllers\Pos\CustomerController();
        $response = $controller->CustomerAdd();

        $this->assertInstanceOf(\Illuminate\View\View::class, $response);
        $this->assertEquals('backend.customer.customer_add', $response->name());
    }

    /** @test */
    public function it_can_return_customer_edit_view()
    {
        // Test returning the customer edit view
        $customer = Customer::create([
            'name' => 'To Be Edited Customer',
            'mobile_no' => '1234567890',
            'email' => 'edit@example.com',
            'address' => '123 Edit St',
            'created_by' => 1,
        ]);

        $controller = new \App\Http\Controllers\Pos\CustomerController();
        $response = $controller->CustomerEdit($customer->id);

        $this->assertInstanceOf(\Illuminate\View\View::class, $response);
        $this->assertEquals('backend.customer.customer_edit', $response->name());
        $this->assertArrayHasKey('customer', $response->getData());
    }
}
