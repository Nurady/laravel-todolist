<?php

namespace Tests\Feature;

use App\Services\TodoListService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class TodoListServiceTest extends TestCase
{
    private TodoListService $todoListService;

    protected function setUp():void
    {
        parent::setUp();

        $this->todoListService = $this->app->make(TodoListService::class);
    }

    public function testTodoListNotNull()
    {
        self::assertNotNull($this->todoListService);
    }

    public function testSaveTodo()
    {
        $this->todoListService->saveTodo('1', 'my');

        $todolist = Session::get('todolist');

        foreach($todolist as $todo){
            self::assertEquals('1', $todo['id']);
            self::assertEquals('my', $todo['todo']);
        }
    }

    public function testGetTodoListEmpty()
    {
        self::assertEquals([], $this->todoListService->getTodoList());
    }

    public function testGetTodoListNotEmpty()
    {
        $expected = [
            [
                'id' => '1',
                'todo' => 'my'
            ],
            [
                'id' => '2',
                'todo' => 'my2'
            ]
        ];

        $this->todoListService->saveTodo('1', 'my');
        $this->todoListService->saveTodo('2', 'my2');

        self::assertEquals($expected, $this->todoListService->getTodoList());
    }

    public function testRemoveTodo()
    {
        $this->todoListService->saveTodo('1', 'my');
        $this->todoListService->saveTodo('2', 'my2');

        self::assertEquals(2, sizeof($this->todoListService->getTodoList()));

        $this->todoListService->removeTodo('3');

        self::assertEquals(2, sizeof($this->todoListService->getTodoList()));

        $this->todoListService->removeTodo('1');

        self::assertEquals(1, sizeof($this->todoListService->getTodoList()));

        $this->todoListService->removeTodo('2');

        self::assertEquals(0, sizeof($this->todoListService->getTodoList()));
    }
}
