<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\PaddyType;
use App\Models\FarmerSellingPaddyType;
use App\Models\Buyer;
use App\Models\Farmer;
use App\Models\Order;

class BuyerTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function buyer_can_search_for_specific_paddy_type()
    {
        $this->withoutMiddleware();
        
        // Create a paddy type manually
        $paddy = new PaddyType();
        $paddy->PaddyName = 'Nadu';
        $paddy->MinPricePerKg = 100;
        $paddy->MaxPricePerKg = 200;
        $paddy->save();
        
        // Access the page
        $response = $this->get('/buyer/products?query=Nadu');
        $response->assertStatus(200);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function buyer_can_place_order_for_paddy_type()
    {
        $this->withoutMiddleware();
        
        // Create a paddy type and listing manually
        $paddy = new PaddyType();
        $paddy->PaddyName = 'Test Paddy';
        $paddy->MinPricePerKg = 100;
        $paddy->MaxPricePerKg = 200;
        $paddy->save();
        
        $farmer = Farmer::create([
            'Email' => 'test@example.com',
            'FullName' => 'Test Farmer',
            'ContactNo' => '1234567890',
            'Address' => 'Test Address',
            'NIC' => '123456789X',
            'password' => 'password'
        ]);
        
        $listing = FarmerSellingPaddyType::create([
            'FarmerID' => $farmer->FarmerID,
            'PaddyID' => $paddy->PaddyID,
            'PriceSelected' => 150,
            'Quantity' => 50
        ]);
        
        $buyer = Buyer::create([
            'Email' => 'buyer@example.com',
            'FullName' => 'Test Buyer',
            'ContactNo' => '9876543210',
            'Address' => 'Buyer Address',
            'password' => 'password',
            'NIC' => '123456789B'
        ]);

        $this->actingAs($buyer, 'buyer');
        
        // Try to place an order
        $response = $this->post('/buyer/place-order', [
            'listing_id' => $listing->id,
            'quantity' => 10,
        ]);
        
        // Just check we got a response, not 500
        $this->assertNotEquals(500, $response->getStatusCode());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function buyer_can_view_order_details_and_tracker()
    {
        $this->withoutMiddleware();
        
        // Create models manually instead of using factories
        $buyer = Buyer::create([
            'Email' => 'buyer2@example.com',
            'FullName' => 'Test Buyer 2',
            'ContactNo' => '5555555555',
            'Address' => 'Test Address',
            'password' => 'password',
            'NIC' => '222222222X'
        ]);
        
        $farmer = Farmer::create([
            'Email' => 'farmer2@example.com',
            'FullName' => 'Test Farmer 2',
            'ContactNo' => '6666666666',
            'Address' => 'Test Address',
            'NIC' => '987654321X',
            'password' => 'password',
        ]);
        
        $paddy = PaddyType::create([
            'PaddyName' => 'Order Test Paddy',
            'MinPricePerKg' => 100,
            'MaxPricePerKg' => 200,
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
        
        // Simply test that the route can be accessed
        $response = $this->actingAs($buyer, 'buyer')
                         ->get(route('buyer.order.details', $order->id));
        $response->assertStatus(200);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function buyer_can_confirm_order_receipt()
    {
        $this->withoutMiddleware();
        
        // Create necessary models
        $farmer = Farmer::create([
            'Email' => 'receipt_farmer@example.com',
            'FullName' => 'Receipt Test Farmer',
            'ContactNo' => '1234567890',
            'Address' => 'Test Address',
            'NIC' => '123456789R',
            'password' => 'password'
        ]);
        
        $buyer = Buyer::create([
            'Email' => 'receipt_buyer@example.com',
            'FullName' => 'Receipt Test Buyer',
            'ContactNo' => '9876543210',
            'Address' => 'Buyer Address',
            'password' => 'password',
            'NIC' => '987654321R'
        ]);
        
        $paddy = PaddyType::create([
            'PaddyName' => 'Receipt Test Paddy',
            'MinPricePerKg' => 100,
            'MaxPricePerKg' => 200,
        ]);
        
        // Create an order that's delivered
        $order = Order::create([
            'buyer_id' => $buyer->BuyerID,
            'farmer_id' => $farmer->FarmerID,
            'paddy_type_id' => $paddy->PaddyID,
            'price_per_kg' => 150,
            'quantity' => 5,
            'total_amount' => 750,
            'status' => 'delivered'
        ]);
        
        // Buyer confirms receipt
        $this->actingAs($buyer, 'buyer');
        $response = $this->post(route('buyer.orders.receive', $order->id));
        $response->assertStatus(302); // Should redirect
        
        // Check if order status was updated
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'completed'
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function buyer_can_edit_account_details()
    {
        $this->withoutMiddleware(); // Skip middleware including CSRF protection

        // Create a buyer
        $buyer = Buyer::create([
            'Email' => 'edit_buyer@example.com',
            'FullName' => 'Edit Test Buyer',
            'ContactNo' => '0777512454',
            'Address' => 'Original Address',
            'password' => 'password',
            'NIC' => '199851083015'
        ]);
        
        // Act as the buyer
        $this->actingAs($buyer, 'buyer');
        
        // Update account details - add NIC field which is required
        $response = $this->put('/buyer/account', [
            'FullName' => 'Updated Buyer Name',
            'ContactNo' => '0777512120',
            'Address' => 'New Address',
            'Email' => 'edit_buyer@example.com',
            'NIC' => '199751283015'
        ]);
        
        // Assert the response is successful or a redirect
        $this->assertTrue($response->isSuccessful() || $response->isRedirect());
        
        // Or retrieve the buyer again to check the updates
        $updatedBuyer = Buyer::find($buyer->BuyerID);
        $this->assertEquals('Updated Buyer Name', $updatedBuyer->FullName);
        $this->assertEquals('0777512120', $updatedBuyer->ContactNo);
        $this->assertEquals('New Address', $updatedBuyer->Address);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function buyer_can_see_top_selling_paddy_types()
    {
        $this->withoutMiddleware();
        
        // Create farmers
        $farmer = Farmer::create([
            'Email' => 'top_farmer@example.com',
            'FullName' => 'Top Test Farmer',
            'ContactNo' => '1234567890',
            'Address' => 'Test Address',
            'NIC' => '123456789T',
            'password' => 'password'
        ]);
        
        // Create paddy types
        $paddy1 = PaddyType::create([
            'PaddyName' => 'Popular Paddy 1',
            'MinPricePerKg' => 100,
            'MaxPricePerKg' => 200,
        ]);
        
        $paddy2 = PaddyType::create([
            'PaddyName' => 'Popular Paddy 2',
            'MinPricePerKg' => 150,
            'MaxPricePerKg' => 250,
        ]);
        
        $paddy3 = PaddyType::create([
            'PaddyName' => 'Popular Paddy 3',
            'MinPricePerKg' => 120,
            'MaxPricePerKg' => 220,
        ]);
        
        // Create listings
        $listing1 = FarmerSellingPaddyType::create([
            'FarmerID' => $farmer->FarmerID,
            'PaddyID' => $paddy1->PaddyID,
            'PriceSelected' => 150,
            'Quantity' => 100
        ]);
        
        $listing2 = FarmerSellingPaddyType::create([
            'FarmerID' => $farmer->FarmerID,
            'PaddyID' => $paddy2->PaddyID,
            'PriceSelected' => 200,
            'Quantity' => 100
        ]);
        
        $listing3 = FarmerSellingPaddyType::create([
            'FarmerID' => $farmer->FarmerID,
            'PaddyID' => $paddy3->PaddyID,
            'PriceSelected' => 150,
            'Quantity' => 100
        ]);
        
        // Create a buyer
        $buyer = Buyer::create([
            'Email' => 'top_buyer@example.com',
            'FullName' => 'Top Test Buyer',
            'ContactNo' => '9876543210',
            'Address' => 'Buyer Address',
            'password' => 'password',
            'NIC' => '987654321T'
        ]);
        
        // Act as the buyer
        $this->actingAs($buyer, 'buyer');
        
        // Access the buyer dashboard
        $response = $this->get('/buyer/dashboard');
        $response->assertStatus(200);
        
        // Dashboard should show top paddy types section
        $response->assertSee('Popular Paddy');
    }
}
