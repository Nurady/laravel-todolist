<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodoListControllerTest extends TestCase
{
    public function testTodoList()
    {
        $this->withSession([
            'user' => 'adis',
            'todolist' => [
                [
                    'id' => '1',
                    'todo' => 'my'
                ],
                [
                    'id' => '2',
                    'todo' => 'my2'
                ]
            ]
        ])->get('/todolist')->assertSeeText('1')->assertSeeText('my')->assertSeeText('2')->assertSeeText('my2');
    }
    
    public function testAddTodoFailed()
    {
        $this->withSession([
            'user' => 'adis'
        ])->post('/todolist', [])->assertSeeText('todo is required');
    }

    public function testAddTodoSuccess()
    {
        $this->withSession([
            'user' => 'adis'
        ])->post('/todolist', [
            'todo' => 'my'
        ])->assertRedirect('/todolist');
    }

    public function testRemoveTodoList()
    {
        $this->withSession([
            'user' => 'adis',
            'todolist' => [
                [
                    'id' => '1',
                    'todo' => 'my'
                ],
                [
                    'id' => '2',
                    'todo' => 'my2'
                ]
            ]
        ])->post('/todolist/1/delete')->assertRedirect('/todolist');
    }
}
