<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function store(Request $request)
    {
       try {
            DB::beginTransaction();

            $project = new Project();
            $project->name = $request->name;
            $project->save();

            DB::commit();
            toastr()->success("Project created successfully!");

            return redirect()->back();
       } catch (\Throwable $error) {
            logger($error);
            toastr()->error('Internal server error');
            return back();;
       }
    }
}
