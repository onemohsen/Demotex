<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    private function create_user($isAdmin = false)
    {
        if ($isAdmin) $this->user = User::factory()->create(['is_admin' => true]);
        if (!$isAdmin) $this->user = User::factory()->create();
    }

    /** @test */
    public function guest_cannot_access_task()
    {
        $response = $this->get('/tasks');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    /** @test */
    public function user_can_access_task()
    {
        $this->create_user();
        $response = $this->actingAs($this->user)->get('/tasks');
        $response->assertStatus(200);
        $response->assertSee($this->user->name);
    }

    /** @test */
    public function user_cannot_see_link_admin_panel()
    {
        $this->create_user();
        $response = $this->actingAs($this->user)->get('/tasks');
        $response->assertStatus(200);
        $response->assertDontSee('پنل مدیریت');
    }

    /** @test */
    public function admin_can_see_link_admin_panel()
    {
        $this->create_user(true);
        $response = $this->actingAs($this->user)->get('/tasks');
        $response->assertStatus(200);
        $response->assertSee('پنل مدیریت');
    }

    /** @test */
    public function admin_can_access_admin_panel()
    {
        $this->create_user(true);
        $response = $this->actingAs($this->user)->get('/admin');
        $response->assertStatus(200);
        $response->assertSee('گزارش');
    }

    /** @test */
    public function user_cannot_access_admin_panel()
    {
        $this->create_user();
        $response = $this->actingAs($this->user)->get('/admin');
        $response->assertStatus(302);
        $response->assertDontSee('گزارش');
        $response->assertRedirect('/');
    }

    /** @test */
    public function user_can_route_to_create_page()
    {
        $this->create_user();
        $response = $this->actingAs($this->user)->get('/tasks/create');
        $response->assertStatus(200);
        $response->assertSee('name');
        $response->assertSee('note');
    }

    /** @test */
    public function user_can_edit_own_tasks()
    {
        $this->create_user();
        $task = $this->user->tasks()->create(['name'=>'test','note'=>'test']);
        $response = $this->actingAs($this->user)->get('/tasks/'.$task->id.'/edit');
        $response->assertStatus(200);
        $response->assertSee('name');
        $response->assertSee('note');

    }

    /** @test */
    public function user_cannot_edit_other_user_tasks()
    {
        $this->create_user();
        $otherUser = User::factory()->create();
        $task = $otherUser->tasks()->create(['name'=>'test','note'=>'test']);
        $response = $this->actingAs($this->user)->get('/tasks/'.$task->id.'/edit');
        $response->assertStatus(403);
        $response->assertSee('This action is unauthorized');
    }
}
