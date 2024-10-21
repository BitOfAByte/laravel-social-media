<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class UserControllerTest extends TestCase
{
    use RefreshDatabase; // Reset the database for each test

    public function test_create_user()
    {
        // Arrange: Define user data
        $data = [
            'username' => 'TestUser',
            'email' => 'test@example.com',
            'password' => 'password',
        ];

        // Act: Make a POST request to the store route
        $response = $this->post(route('users.store'), $data);

        // Assert: Check that a user was created
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success', 'User created successfully.');
    }

    public function test_update_user()
    {
        // Arrange: Create a user
        $user = User::factory()->create();

        // Act: Make a PUT request to update the user
        $data = [
            'username' => 'UpdatedUser',
            'email' => 'updated@example.com',
            'password' => 'newpassword',
        ];

        $response = $this->put(route('users.update', $user->id), $data);

        // Assert: Check that the user was updated
        $user->refresh(); // Refresh user data
        $this->assertEquals('Updated User', $user->username);
        $this->assertEquals('updated@example.com', $user->email);
        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success', 'User updated successfully.');
    }

    public function test_delete_user()
    {
        // Arrange: Create a user
        $user = User::factory()->create();

        // Act: Make a DELETE request to destroy the user
        $response = $this->delete(route('users.destroy', $user->id));

        // Assert: Check that the user was deleted
        $this->assertDeleted($user);
        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('success', 'User deleted successfully.');
    }
}
