<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks=Task::all();
        return response()->json(['code' => 200, 'data' => $tasks], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title' =>'required','string','unique:tasks',
            'description' =>'required',
        ]);

        $tasks=Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'created_by' => Auth::user()->id,
        ]);

        return response()->json(['code' => 200, 'data' => $tasks], 200);
    }
    
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'title' =>'required','string','unique:tasks'.$id.',id',
            'description' =>'required',
        ]);

        $tasks=Task::find($id);
        $tasks->update([
            'title' => $request->title,
            'description' => $request->description,
            'created_by' => Auth::user()->id,
        ]);

        return response()->json(['code' => 200, 'data' => $tasks], 200);
    }

    public function destroy($id)
    {
        $tasks=Task::find($id);
        $tasks->delete();

        return response()->json([
            'success' => true,
            'message' => 'Deleted Successfully!'
        ]);

    }
}
