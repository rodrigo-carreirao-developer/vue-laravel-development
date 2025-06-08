<?php

// tests/Feature/UserCrudTest.php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Create an admin user for authenticated requests
    $this->adminUser = User::factory()->create([
        'email' => 'admin@test.com'
    ]);
    
    // Create a regular user for testing
    $this->regularUser = User::factory()->create([
        'email' => 'user@test.com',
        'name' => 'John Doe',
    ]);
});

describe('User CRUD Operations', function () {
    
    describe('Index (List Users)', function () {
        
        it('can list all users for admin', function () {
            // Create additional users
            User::factory(5)->create();
            
            $response = $this->actingAs($this->adminUser)
                ->getJson('/api/users');
            
            $response->assertStatus(200)
                ->assertJsonStructure([
                    'data' => [
                        '*' => [
                            'id',
                            'name',
                            'email',
                            'created_at',
                            'updated_at'
                        ]
                    ],
                    'pagination'
                ]);
            
            expect($response->json('pagination.total'))->toBeGreaterThanOrEqual(7);
        });
        
        it('returns paginated results', function () {
            User::factory(25)->create();
            
            $response = $this->actingAs($this->adminUser)
                ->getJson('/api/users?per_page=10');
            
            $response->assertStatus(200);
            
            expect($response->json('pagination.per_page'))->toBe(10);
            expect($response->json('data'))->toHaveCount(10);
            expect($response->json('pagination.total'))->toBe(27); 
        });
        
        it('can filter users by search term', function () {
            User::factory()->create(['name' => 'Jane Smith', 'email' => 'jane@test.com']);
            User::factory()->create(['name' => 'Bob Johnson', 'email' => 'bob@test.com']);
            
            $response = $this->actingAs($this->adminUser)
                ->getJson('/api/users?search=Jane');
            
            $response->assertStatus(200);
            
            expect($response->json('data'))->toHaveCount(1);
            expect($response->json('data.0.name'))->toBe('Jane Smith');
        });
        
    });
    
    describe('Show (Get Single User)', function () {
        
        it('can show a specific user', function () {
            $response = $this->actingAs($this->adminUser)
                ->getJson("/api/users/{$this->regularUser->id}");
            
            $response->assertStatus(200)
                ->assertJson([
                    'data' => [
                        'id' => $this->regularUser->id,
                        'name' => $this->regularUser->name,
                        'email' => $this->regularUser->email,
                    ]
                ]);
        });
        
        it('returns 404 for non-existent user', function () {
            $response = $this->actingAs($this->adminUser)
                ->getJson('/api/users/999999');
            
            $response->assertStatus(404);
        });
        
        it('allows users to view their own profile', function () {
            $response = $this->actingAs($this->regularUser)
                ->getJson("/api/users/{$this->regularUser->id}");
            
            $response->assertStatus(200);
        });
        
    });
    
    describe('Store (Create User)', function () {
        
        it('can create a new user with valid data', function () {
            $userData = [
                'name' => 'New User',
                'email' => 'newuser@test.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ];
            
            $response = $this
                ->postJson('/api/users', $userData);
            
            $response->assertStatus(201)
                ->assertJsonStructure([
                    'data' => [
                        'id',
                        'name',
                        'email',
                        'created_at',
                        'updated_at'
                    ]
                ]);
            
            $this->assertDatabaseHas('users', [
                'name' => 'New User',
                'email' => 'newuser@test.com',
            ]);
            
            expect($response->json('data.name'))->toBe('New User');
        });
        it('validates required fields', function () {
            $response = $this
                ->postJson('/api/users', []);
            
            $response->assertStatus(422)
                ->assertJsonValidationErrors([
                    'name','email', 'password'
                ]);
        });
        
        it('validates email uniqueness', function () {
            $userData = [
                'name' => 'Test User',
                'email' => $this->regularUser->email, // Existing email
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ];
            
            $response = $this
                ->postJson('/api/users', $userData);
            
            $response->assertStatus(422)
                ->assertJsonValidationErrors(['email']);
        });
        
        it('validates email format', function () {
            $userData = [
                'name' => 'Test User',
                'email' => 'invalid-email',
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ];
            
            $response = $this
                ->postJson('/api/users', $userData);
            
            $response->assertStatus(422)
                ->assertJsonValidationErrors(['email']);
        });
        
        it('validates password confirmation', function () {
            $userData = [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => 'password123',
                'password_confirmation' => 'different_password',
            ];
            
            $response = $this
                ->postJson('/api/users', $userData);
            
            $response->assertStatus(422)
                ->assertJsonValidationErrors(['password']);
        });
        
        it('hashes the password', function () {
            $userData = [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ];
            
            $response = $this
                ->postJson('/api/users', $userData);
            
            $response->assertStatus(201);
            
            $user = User::where('email', 'test@example.com')->first();
            expect(Hash::check('password123', $user->password))->toBeTrue();
        });
        
    });
    describe('Update (Edit User)', function () {
        
        it('can update user with valid data', function () {
            $updateData = [
                'name' => 'Updated Name',
                'email' => 'updated@test.com',
            ];
            
            $response = $this
                ->putJson("/api/users/{$this->regularUser->id}", $updateData);
            
            $response->assertStatus(200)
                ->assertJson([
                    'data' => [
                        'id' => $this->regularUser->id,
                        'name' => 'Updated Name',
                        'email' => 'updated@test.com',
                    ]
                ]);
            
            $this->assertDatabaseHas('users', [
                'id' => $this->regularUser->id,
                'name' => 'Updated Name',
                'email' => 'updated@test.com',
            ]);
        });
        
        it('can update password', function () {
            $updateData = [
                'name' => $this->regularUser->name,
                'email' => $this->regularUser->email,
                'password' => 'newpassword123',
                'password_confirmation' => 'newpassword123',
            ];
            
            $response = $this
                ->putJson("/api/users/{$this->regularUser->id}", $updateData);
            
            $response->assertStatus(200);
            
            $this->regularUser->refresh();
            expect(Hash::check('newpassword123', $this->regularUser->password))->toBeTrue();
        });
        
        it('can update without changing password', function () {
            $originalPassword = $this->regularUser->password;
            
            $updateData = [
                'name' => 'Updated Name Only',
                'email' => $this->regularUser->email,
            ];
            
            $response = $this
                ->putJson("/api/users/{$this->regularUser->id}", $updateData);
            
            $response->assertStatus(200);
            
            $this->regularUser->refresh();
            expect($this->regularUser->password)->toBe($originalPassword);
        });
        
        it('validates email uniqueness on update', function () {
            $anotherUser = User::factory()->create();
            
            $updateData = [
                'name' => 'Test',
                'email' => $anotherUser->email,
            ];
            
            $response = $this
                ->putJson("/api/users/{$this->regularUser->id}", $updateData);
            
            $response->assertStatus(422)
                ->assertJsonValidationErrors(['email']);
        });
        
        it('returns 404 for non-existent user', function () {
            $response = $this
                ->putJson('/api/users/999999', [
                    'name' => 'Test',
                    'email' => 'test@test.com'
                ]);
            
            $response->assertStatus(404);
        });
       /* */
    });
    
    describe('Destroy (Delete User)', function () {
        
        it('can delete a user', function () {
            $userToDelete = User::factory()->create();
            
            $response = $this
                ->deleteJson("/api/users/{$userToDelete->id}");
            
            $response->assertStatus(204);
            
            $this->assertDatabaseMissing('users', [
                'id' => $userToDelete->id,
            ]);
        });
        
        it('returns 404 when deleting non-existent user', function () {
            $response = $this
                ->deleteJson('/api/users/999999');
            
            $response->assertStatus(404);
        });
        
    });
});

// Helper functions for the tests
function createUserData(array $overrides = []): array
{
    return array_merge([
        'name' => fake()->name(),
        'email' => fake()->unique()->safeEmail(),
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ], $overrides);
}