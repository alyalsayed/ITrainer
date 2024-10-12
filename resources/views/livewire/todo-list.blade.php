<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title box-title">To Do List</h4>
            <div class="card-content">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" 
                           placeholder="Add new todo" 
                           wire:model.live="task"
                           wire:keydown.enter="addTodo"
                           > 
                         
                    <button class="btn btn-primary" wire:click="addTodo">
                        {{ $editingTodoId ? 'Update' : 'Add' }}
                    </button>
                </div>
                <div class="todo-list">
                    <div class="tdl-holder">
                        <div class="tdl-content">
                            <ul>
                                @foreach($todos as $todo)
                                    <li>
                                        <label>
                                            <input type="checkbox" wire:click="toggleCompletion({{ $todo['id'] }})" {{ $todo['status'] === 'completed' ? 'checked' : '' }}>
                                            <i class="check-box"></i>
                                            <span class="{{ $todo['status'] === 'completed' ? 'text-decoration-line-through' : '' }}">{{ $todo['task'] }}</span>
                                            <a href="" class="fa fa-times" wire:click.prevent="deleteTodo({{ $todo['id'] }})"></a>
                                            <a href="" class="fa fa-pencil" wire:click.prevent="editTodo({{ $todo['id'] }})"></a>
                                            <a href="" class="fa fa-check" wire:click.prevent="toggleCompletion({{ $todo['id'] }})"></a>
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div> <!-- /.todo-list -->
            </div>
        </div> <!-- /.card-body -->
    </div><!-- /.card -->

    <!-- No todos message -->
    @if(count($todos) === 0)
        <div class="alert alert-info mt-3">
            No todos available. Add a new todo!
        </div>
    @endif
</div>