<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Task;
use App\Models\Project;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        try {
            $project_id = $request->get('project_id');
            $tasks = $project_id ? Task::where('project_id', $project_id)->orderBy('priority')->get() : collect();
            $projects = Project::all();
            return view('tasks.index', compact('tasks', 'projects', 'project_id'));
        } catch (\Throwable $error) {
            logger($error);
            toastr()->error('Internal server error');
            return back();
        }
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $task = new Task();
            $task->name = $request->name;
            $task->priority = Task::where('project_id', $request->project_id)->count() + 1;
            $task->project_id = $request->project_id;
            $task->save();

            DB::commit();

            toastr()->success("Task created successfully!");
            return redirect()->route('tasks.index', ['project_id' => $request->project_id]);
        } catch (\Throwable $th) {
            DB::rollBack();
            toastr()->error('Internal server error');
            return back();
        }
    }

    public function update(Request $request, Task $task)
    {
        try {
            DB::beginTransaction();
        
            $task->name = $request->name;
            $task->save();
            
            DB::commit();
            toastr()->success("Task updated successfully!");

            return redirect()->route('tasks.index', ['project_id' => $task->project_id]);
        } catch (\Throwable $th) {
            DB::rollBack();
            toastr()->error('Internal server error');
            return back();
        }
    }

    public function destroy(Task $task)
    {
        try {
            $project_id = $task->project_id;
            $task->delete();
            toastr()->success("Task deleted successfully!");

            return redirect()->route('tasks.index', ['project_id' => $project_id]);
        } catch (\Throwable $th) {
            
            toastr()->error('Internal server error');
            return back();
        }
    }

    public function reorder(Request $request)
    {
        $tasks = $request->tasks;
        foreach ($tasks as $priority => $id) {
            Task::where('id', $id)->update(['priority' => $priority + 1]);
        }
    }
}
