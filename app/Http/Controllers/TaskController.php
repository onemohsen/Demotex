<?php

namespace App\Http\Controllers;

use App\Http\Requests\task\TaskRequest;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    private $user;
    private $isEdit = false;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user(); // returns user
            return $next($request);
        });
    }

    public function index()
    {
        $tasks = $this->user->tasks()->whereDate('date', Carbon::today())->get();
        return view('task.index', compact('tasks'));
    }

    public function create()
    {
        return view('task.create');
    }

    public function store(TaskRequest $task)
    {
        $this->user->tasks()->create($task->validated());
        return redirect()->route('tasks.index');
    }

    public function edit(Task $task)
    {
        $this->authorize('update-task',$task);
        $this->isEdit = true;
        return view('task.create', [
            'task' => $task,
            'isEdit' => $this->isEdit,
        ]);
    }

    public function update(TaskRequest $taskRequest, Task $task)
    {
        $task->update($taskRequest->validated());
        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index');
    }
}
