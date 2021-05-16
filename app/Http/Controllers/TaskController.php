<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $task=Task::all();
        return view('index',compact('task'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|regex:/^[a-zA-Z]+$/u',
            'task_name' => 'required|regex:/^[a-zA-Z0-9_.-]+$/u',
            'datetime' => 'required',
             ]);
        $task=Task::create($request->all());
         return redirect()->route('tasks.index')->with('success','User created successfully!'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $editModel=Task::find($id);
        $editModel->status=2;

        $status=$editModel->save();
          if($status){
             return redirect()->route('tasks.index')->with('success','Task Completed Successfully');   
           }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task=Task::all();
        $editModel=Task::find($id);
        return view('edit',compact('task','editModel'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    { 
      $request->validate([
            'name' => 'required|regex:/^[a-zA-Z]+$/u',
            'task_name' => 'required|regex:/^[a-zA-Z0-9_.-]+$/u',
            'datetime' => 'required',
             ]);
         $task=Task::find($id);
         $task->name=$request->get('name');
         $task->task_name=$request->get('task_name');
         $task->datetime=$request->get('datetime');
         $status=$task->save();
          if($status){
             return redirect()->route('tasks.index')->with('success','Task Update Successfully');   
           }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $editModel=Task::find($id);
         $status=$editModel->delete();
          if($status){
             return redirect()->route('tasks.index')->with('error','Task Delete Successfully');   
           }
    }
}
