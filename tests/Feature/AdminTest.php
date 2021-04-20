<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    private $user;

    private function create_user($isAdmin = false)
    {
        if ($isAdmin) $this->user = User::factory()->create(['is_admin' => true]);
        if (!$isAdmin) $this->user = User::factory()->create();
    }

    /** @test */
    public function admin_can_see_users_table()
    {
        $this->create_user(true);
        $user = User::first();
        $user2 = User::latest()->first();
        $response = $this->actingAs($this->user)->get('/admin/users');
        $response->assertSee($user->name);
        $response->assertSee($user2->name);
    }

    /** @test */
    public function admin_can_see_report_table()
    {
        $this->create_user(true);
        $tasks = Task::all();
        $response = $this->actingAs($this->user)->get('/admin/reports');
        $response->assertSee($tasks->first()->date);
    }

    /** @test */
    public function admin_cannot_see_report_table_paginate()
    {
        $this->create_user(true);
        $task = Task::with('user')->latest()->first();
        $response = $this->actingAs($this->user)->get('/admin/reports');
        $response->assertDontSee($task->user->email);
    }
}
