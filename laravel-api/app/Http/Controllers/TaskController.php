<?php

namespace App\Http\Controllers;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Task::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validation 
        $request->validate([
            'title'=>'required',
            'description'=>'required',
            'status'=>'required'
        ]);
        
        return Task::create($request->all());
      
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Task::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //udpdate

        $task=Task::find($id);
        $task->update($request->all());
        return $task;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //delete
        return Task::destroy($id);
    }
}
