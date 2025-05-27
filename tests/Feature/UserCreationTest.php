<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UserCreationTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function database_seeder_creates_test_user()
    {
        // Run the database seeder
        $this->seed();

        // Assert the test user exists
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'name' => 'Test User',
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function homepage_returns_successful_response()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function user_can_be_created_with_factory()
    {
        $user = User::factory()->create([
            'email' => 'factoryuser@example.com',
            'name' => 'Factory User',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'factoryuser@example.com',
            'name' => 'Factory User',
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function duplicate_user_email_is_not_allowed()
    {
        User::factory()->create([
            'email' => 'unique@example.com',
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        User::factory()->create([
            'email' => 'unique@example.com',
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function user_can_be_updated()
    {
        $user = User::factory()->create([
            'name' => 'Old Name',
        ]);

        $user->update(['name' => 'New Name']);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'New Name',
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function user_can_be_deleted()
    {
        $user = User::factory()->create();

        $user->delete();

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }

    // #[\PHPUnit\Framework\Attributes\Test]
    // public function registration_page_is_accessible()
    // {
    //     $response = $this->get('/register');
    //     $response->assertStatus(200);
    // }

    // #[\PHPUnit\Framework\Attributes\Test]
    // public function login_page_is_accessible()
    // {
    //     $response = $this->get('/login');
    //     $response->assertStatus(200);
    // }

    #[\PHPUnit\Framework\Attributes\Test]
    public function user_password_is_hashed_on_creation()
    {
        $user = User::factory()->create([
            'email' => 'hashcheck@example.com',
            'name' => 'Hash Check',
            'password' => 'plainpassword'
        ]);
        $this->assertNotEquals('plainpassword', $user->password);
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('plainpassword', $user->password));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function user_cannot_be_created_without_email()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        User::factory()->create([
            'email' => null,
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function database_is_empty_after_refresh()
    {
        $this->assertDatabaseCount('users', 0);
    }
}
