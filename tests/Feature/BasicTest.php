<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BasicTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function homepage_is_accessible()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function buyer_registration_page_is_accessible()
    {
        $response = $this->get('/buyer/register');
        $response->assertStatus(200);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function farmer_registration_page_is_accessible()
    {
        $response = $this->get('/farmer/register');
        $response->assertStatus(200);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function buyer_login_page_is_accessible()
    {
        $response = $this->get('/buyer/login');
        $response->assertStatus(200);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function farmer_login_page_is_accessible()
    {
        $response = $this->get('/farmer/login');
        $response->assertStatus(200);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function admin_login_page_is_accessible()
    {
        $response = $this->get('/admin/login');
        $response->assertStatus(200);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function non_existent_page_returns_404()
    {
        $response = $this->get('/thispagedoesnotexist');
        $response->assertStatus(404);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function buyer_registration_requires_validation()
    {
        $response = $this->post('/buyer/register', []);
        $response->assertStatus(302); // Laravel redirects back with errors
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function buyer_login_requires_validation()
    {
        $response = $this->post('/buyer/login', []);
        $response->assertStatus(302); // Laravel redirects back with errors
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function botman_endpoint_responds()
    {
        // Start output buffering to capture and discard the response output
        ob_start();
        
        $response = $this->post('/botman', ['driver' => 'web', 'message' => 'hi']);
        
        // Discard the output
        ob_end_clean();
        
        $response->assertStatus(200);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function buyer_logout_redirects_to_login()
    {
        $response = $this->post('/buyer/logout');
        $response->assertRedirect('/buyer/login');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function farmer_logout_redirects_to_login()
    {
        $response = $this->post('/farmer/logout');
        $response->assertRedirect('/farmer/login');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function admin_logout_redirects_to_login()
    {
        $response = $this->post('/admin/logout');
        $response->assertRedirect('/admin/login');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function botman_chat_responds_to_common_questions()
    {
        // Start output buffering to capture and discard the response output
        ob_start();
        
        $response = $this->post('/botman', [
            'driver' => 'web',
            'message' => 'What varieties of paddy are currently available?'
        ]);
        
        // Discard the output
        ob_end_clean();
        
        // Only check that the request was successful
        $response->assertStatus(200);
    }
}
