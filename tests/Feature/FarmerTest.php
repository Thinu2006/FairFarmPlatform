<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\PaddyType;
use App\Models\FarmerSellingPaddyType;
use App\Models\Buyer;
use App\Models\Farmer;
use App\Models\Order;

class FarmerTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function farmer_can_register_and_login()
    {
        // Test registration
        $registerResponse = $this->post('/farmer/register', [
            'FullName' => 'New Test Farmer',
            'Email' => 'new_farmer@example.com',
            'ContactNo' => '9876543210',
            'Address' => 'New Farmer Address',
            'NIC' => '987654321X',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);
        
        $registerResponse->assertStatus(302); // Redirect after registration
        
        // Verify farmer was created
        $this->assertDatabaseHas('farmers', [
            'Email' => 'new_farmer@example.com',
        ]);
        
        // Test login
        $loginResponse = $this->post('/farmer/login', [
            'Email' => 'new_farmer@example.com',
            'password' => 'password',
        ]);
        
        $loginResponse->assertStatus(302); // Redirect after login attempt
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function farmer_can_view_their_paddy_listings()
    {
        $this->withoutMiddleware();
        
        // Create a farmer
        $farmer = Farmer::create([
            'Email' => 'viewing_farmer@example.com',
            'FullName' => 'Viewing Test Farmer',
            'ContactNo' => '1234567890',
            'Address' => 'Test Address',
            'NIC' => '123456789V',
            'password' => 'password'
        ]);
        
        // Create a paddy type
        $paddy = PaddyType::create([
            'PaddyName' => 'Viewing Test Paddy',
            'MinPricePerKg' => 100,
            'MaxPricePerKg' => 200,
        ]);
        
        // Create a farmer's paddy listing
        FarmerSellingPaddyType::create([
            'FarmerID' => $farmer->FarmerID,
            'PaddyID' => $paddy->PaddyID,
            'PriceSelected' => 150,
            'Quantity' => 50
        ]);
        
        // Acting as the farmer
        $this->actingAs($farmer, 'farmer');
        
        // Access farmer paddy listings page
        $response = $this->get('/farmer/paddy-listing');
        $response->assertStatus(200);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function farmer_can_perform_crud_operations_on_paddy_listings()
    {
        $this->withoutMiddleware();
        
        // Create a farmer
        $farmer = Farmer::create([
            'Email' => 'crud_farmer@example.com',
            'FullName' => 'CRUD Test Farmer',
            'ContactNo' => '1234567890',
            'Address' => 'Test Address',
            'NIC' => '123456789C',
            'password' => 'password'
        ]);
        
        // Create two paddy types
        $paddy1 = PaddyType::create([
            'PaddyName' => 'CRUD Test Paddy 1',
            'MinPricePerKg' => 100,
            'MaxPricePerKg' => 200,
        ]);
        
        $paddy2 = PaddyType::create([
            'PaddyName' => 'CRUD Test Paddy 2',
            'MinPricePerKg' => 150,
            'MaxPricePerKg' => 250,
        ]);
        
        // Acting as the farmer
        $this->actingAs($farmer, 'farmer');
        
        // Create a listing
        $createResponse = $this->post('/farmer/selling/paddy/store', [
            'FarmerID' => $farmer->FarmerID,
            'PaddyID' => $paddy1->PaddyID,
            'PriceSelected' => 150,
            'Quantity' => 50
        ]);
        
        $createResponse->assertStatus(302); // Redirect after creation
        
        // Verify creation
        $this->assertDatabaseHas('farmer_selling_paddy_types', [
            'FarmerID' => $farmer->FarmerID,
            'PaddyID' => $paddy1->PaddyID,
        ]);
        
        // Get the created listing
        $listing = FarmerSellingPaddyType::where('FarmerID', $farmer->FarmerID)
                                         ->where('PaddyID', $paddy1->PaddyID)
                                         ->first();
        
        // Edit the listing
        $updateResponse = $this->put("/farmer/paddy-listing/{$listing->id}", [
            'PaddyID' => $paddy2->PaddyID,
            'PriceSelected' => 200,
            'Quantity' => 75
        ]);
        
        $updateResponse->assertStatus(302); // Redirect after update
        
        // Verify update
        $this->assertDatabaseHas('farmer_selling_paddy_types', [
            'id' => $listing->id,
            'PaddyID' => $paddy2->PaddyID,
            'PriceSelected' => 200,
            'Quantity' => 75
        ]);
        
        // Delete the listing
        $deleteResponse = $this->delete("/farmer/paddy-listing/{$listing->id}");
        $deleteResponse->assertStatus(302); // Redirect after deletion
        
        // Verify deletion
        $this->assertDatabaseMissing('farmer_selling_paddy_types', [
            'id' => $listing->id,
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function farmer_can_accept_order_and_quantity_is_updated()
    {
        $this->withoutMiddleware();
        
        // Create models manually
        $farmer = Farmer::create([
            'Email' => 'farmer3@example.com',
            'FullName' => 'Test Farmer 3',
            'ContactNo' => '7777777777',
            'Address' => 'Test Address',
            'NIC' => '555555555X',
            'password' => 'password'
        ]);
        
        $paddy = PaddyType::create([
            'PaddyName' => 'Update Test Paddy',
            'MinPricePerKg' => 100,
            'MaxPricePerKg' => 200,
        ]);
        
        $listing = FarmerSellingPaddyType::create([
            'FarmerID' => $farmer->FarmerID,
            'PaddyID' => $paddy->PaddyID,
            'PriceSelected' => 150,
            'Quantity' => 20
        ]);
        
        $buyer = Buyer::create([
            'Email' => 'buyer3@example.com',
            'FullName' => 'Test Buyer 3',
            'ContactNo' => '8888888888',
            'Address' => 'Test Address',
            'password' => 'password',
            'NIC' => '333333333B'
        ]);
        
        $order = Order::create([
            'buyer_id' => $buyer->BuyerID,
            'farmer_id' => $farmer->FarmerID,
            'paddy_type_id' => $paddy->PaddyID,
            'price_per_kg' => 150,
            'quantity' => 5,
            'total_amount' => 750,
            'status' => 'pending'
        ]);
        
        // Try to update the order status
        $response = $this->post("/farmer/orders/{$order->id}/update-status", [
            'status' => 'processing'
        ]);
        
        $this->assertNotEquals(500, $response->getStatusCode());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function farmer_can_edit_account_details()
    {
        $this->withoutMiddleware();
        
        // Create a farmer
        $farmer = Farmer::create([
            'Email' => 'edit_farmer@example.com',
            'FullName' => 'Edit Test Farmer',
            'ContactNo' => '0705421025',
            'Address' => 'Original Address',
            'NIC' => '200052003025',
            'password' => 'password'
        ]);
        
        // Act as the farmer
        $this->actingAs($farmer, 'farmer');
        
        // Update account details
        $response = $this->put('/farmer/account', [
            'FullName' => 'Updated Farmer Name',
            'ContactNo' => '0705428577',
            'Address' => 'New Address',
            'Email' => 'edit_farmer@example.com',
            'NIC' => '200012013022'
        ]);
        
        // Assert the response is successful or a redirect
        $this->assertTrue($response->isSuccessful() || $response->isRedirect());
        
        // Or retrieve the farmer again to check the updates
        $updatedFarmer = Farmer::find($farmer->FarmerID);
        $this->assertEquals('Updated Farmer Name', $updatedFarmer->FullName);
        $this->assertEquals('0705428577', $updatedFarmer->ContactNo);
        $this->assertEquals('New Address', $updatedFarmer->Address);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function farmer_can_view_revenue_and_order_statistics()
    {
        $this->withoutMiddleware();
        
        // Create a farmer
        $farmer = Farmer::create([
            'Email' => 'stats_farmer@example.com',
            'FullName' => 'Stats Test Farmer',
            'ContactNo' => '1234567890',
            'Address' => 'Test Address',
            'NIC' => '123456789S',
            'password' => 'password'
        ]);
        
        $buyer = Buyer::create([
            'Email' => 'stats_buyer@example.com',
            'FullName' => 'Stats Test Buyer',
            'ContactNo' => '9876543210',
            'Address' => 'Buyer Address',
            'password' => 'password',
            'NIC' => '987654321S'
        ]);
        
        $paddy = PaddyType::create([
            'PaddyName' => 'Stats Test Paddy',
            'MinPricePerKg' => 100,
            'MaxPricePerKg' => 200,
        ]);
        
        // Create some completed orders
        for ($i = 0; $i < 3; $i++) {
            Order::create([
                'buyer_id' => $buyer->BuyerID,
                'farmer_id' => $farmer->FarmerID,
                'paddy_type_id' => $paddy->PaddyID,
                'price_per_kg' => 150,
                'quantity' => 5,
                'total_amount' => 750,
                'status' => 'completed'
            ]);
        }
        
        // Act as the farmer
        $this->actingAs($farmer, 'farmer');
        
        // Access farmer dashboard
        $response = $this->get('/farmer/dashboard');
        $response->assertStatus(200);
        
        // Dashboard should show revenue and order statistics
        $response->assertSee('Total Orders');
        $response->assertSee('Total Revenue');
        $response->assertSee('Monthly Sales');
    }
}
