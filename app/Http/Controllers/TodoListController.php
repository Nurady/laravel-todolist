<?php

namespace App\Http\Controllers;

use App\Services\TodoListService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TodoListController extends Controller
{
    private TodoListService $todoListService;

    public function __construct(TodoListService $todoListService)
    {
        $this->todoListService = $todoListService;
    }
    
    public function todoList(Request $request)
    {
        return response()->view('todolist.todolist', [
            'title' => 'todolist',
            'todolist' => $this->todoListService->getTodoList()
        ]);
    }

    public function addTodo(Request $request)
    {
        $todo = $request->input('todo');

        if (empty($todo)) {
            $todolist = $this->todoListService->getTodoList();
            return response()->view('todolist.todolist', [
                'title' => 'todolist',
                'todolist' => $todolist,
                'error' => 'todo is required'
            ]);
        }

        $this->todoListService->saveTodo(uniqid(), $todo);

        return redirect()->action([TodoListController::class,'todoList']);
    }

    public function removeTodo(Request $request, string $todoId): RedirectResponse
    {
        $this->todoListService->removeTodo($todoId);
        return redirect()->action([TodoListController::class, 'todoList']);
    }
}
