<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Todo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class TodoList extends Component
{
    public $todos = [];
    public $task = ''; // Changed from newTodo to task
    public $editingTodoId = null; 

    public function mount()
    {
        $this->fetchTodos();

        Log::info('check Todo', ['task' => $this->task, 'editingTodoId' => $this->editingTodoId]);
    }

    public function fetchTodos()
    {
        $this->todos = Todo::where('user_id', Auth::id())->get()->toArray();
    }

    public function addTodo()
    {
        $this->validate(['task' => 'required|string|max:255']); // Updated validation

        if ($this->editingTodoId) {
            $this->updateTodo();
        } else {
            $this->createTodo();
        }
    
        Log::info('Adding Todo', ['task' => $this->task, 'editingTodoId' => $this->editingTodoId]);
       
        $this->resetInput();
        $this->fetchTodos(); 
    
       // dd($this->todos, $this->task, $this->editingTodoId);
        Log::info('check Todo', ['task' => $this->task, 'editingTodoId' => $this->editingTodoId]);
    }

    private function createTodo()
    {
        Todo::create([
            'task' => $this->task, // Updated variable
            'status' => 'pending',
            'user_id' => Auth::id(),
        ]);
      
    }

    private function updateTodo()
    {
        $todo = Todo::find($this->editingTodoId);
        if ($todo) {
            $todo->task = $this->task; // Updated variable
            $todo->save();
        }
      
    }

    public function editTodo($todoId)
    {
        $todo = Todo::where('user_id', Auth::id())->find($todoId);
        if ($todo) {
            $this->task = $todo->task; // Updated variable
            $this->editingTodoId = $todoId;
            Log::info('Editing Todo', ['task' => $this->task, 'editingTodoId' => $this->editingTodoId]);
        }
    }

    public function deleteTodo($todoId)
    {
        $todo = Todo::where('user_id', Auth::id())->find($todoId);
        if ($todo) {
            $todo->delete();
        }

        $this->fetchTodos();
    }

    public function toggleCompletion($todoId)
    {
        $todo = Todo::where('user_id', Auth::id())->find($todoId);
        if ($todo) {
            $todo->status = $todo->status === 'completed' ? 'pending' : 'completed';
            $todo->save();
        }

        $this->fetchTodos();
    }

    private function resetInput()
    {
        $this->task = ''; 
        $this->editingTodoId = null;
        Log::info('Resetting Input', ['task' => $this->task, 'editingTodoId' => $this->editingTodoId]);
 
    }

    public function render()
    {
        return view('livewire.todo-list');
    }
}
