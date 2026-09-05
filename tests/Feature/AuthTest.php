<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A user can register as warga and land on the home page.
     */
    public function test_warga_can_register(): void
    {
        $response = $this->post('/register', [
            'name'                  => 'Warga Baru',
            'email'                 => 'warga@test.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
            'role'                  => 'warga',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['email' => 'warga@test.com', 'role' => 'warga']);
    }

    /**
     * A pemilik_toko registering is sent to shop onboarding.
     */
    public function test_pemilik_register_goes_to_shop_onboarding(): void
    {
        $response = $this->post('/register', [
            'name'     => 'Penjual Baru',
            'email'     => 'penjual@test.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
            'role'                  => 'pemilik_toko',
        ]);

        $response->assertRedirect(route('toko.pendaftaran'));
    }

    /**
     * A warga cannot access the admin dashboard (403).
     */
    public function test_warga_cannot_access_admin_dashboard(): void
    {
        $user = User::create([
            'name'     => 'Warga',
            'email'    => 'warga_admin_check@test.com',
            'password' => 'password',
            'role'     => 'warga',
        ]);

        $this->actingAs($user)->get('/admin/dashboard')->assertForbidden();
    }

    /**
     * An admin can access the admin dashboard.
     */
    public function test_admin_can_access_admin_dashboard(): void
    {
        $admin = User::create([
            'name'     => 'Admin',
            'email'    => 'admin_check@test.com',
            'password' => 'password',
            'role'     => 'admin',
        ]);

        $this->actingAs($admin)->get('/admin/dashboard')->assertOk();
    }
}