<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Services\UserService;
use App\DTOs\User\CreateUserDTO;
use App\DTOs\User\UpdateUserDTO;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserServiceTest extends TestCase
{
use RefreshDatabase;

    private UserService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = $this->app->make(UserService::class);
    }

    /** @test */
    public function it_creates_a_user_successfully()
    {
        $dto = new CreateUserDTO(
            name: 'Ahmed',
            email: 'ahmed@example.com',
            password: 'secret123',
            role: 'admin'
        );

        $user = $this->service->createUser($dto);

        $this->assertDatabaseHas('users', ['email' => 'ahmed@example.com']);
        $this->assertEquals('Ahmed', $user->name);
    }

       /** @test */
    public function it_updates_a_user_successfully()
    {
        $user = User::create([
            'name' => 'Ahmed',
            'email' => 'ahmed@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        $dto = UpdateUserDTO::fromArray($user->id, [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);

        $updatedUser = $this->service->updateUser($dto);

        $this->assertEquals('Updated Name', $updatedUser->name);
        $this->assertEquals('updated@example.com', $updatedUser->email);
        $this->assertDatabaseHas('users', ['email' => 'updated@example.com']);
    }

        /** @test */
    public function it_deletes_a_user_successfully()
    {
        
        $user = User::create([
            'name' => 'Ahmed',
            'email' => 'ahmed@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);
        
        $this->service->deleteUser($user->id);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
