<?php

namespace App\Http\Controllers;

use App\Http\Requests\task\FilterDateTaskRequest;
use App\Models\Task;

class ReportController extends Controller
{
    private $perPage = 10 ;

    public function task()
    {
        return view('admin.report.task', [
            'tasks' => Task::with('user')->paginate($this->perPage)
        ]);
    }

    public function filterDate(FilterDateTaskRequest $filterDateTaskRequest)
    {
        $tasks = Task::with('user')
            ->whereBetween('date', [
                $filterDateTaskRequest->startDate,
                $filterDateTaskRequest->endDate
            ])->paginate($this->perPage);
        return view('admin.report.task', compact('tasks'));
    }
}
