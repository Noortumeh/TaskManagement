<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTaskRequest;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function getAllTasks()
    {
        $tasks = Task::all();
        return response()->json($tasks, 200);
    }

    public function index()
    {
        $tasks = Auth::user()->tasks;

        return response()->json($tasks, 200);
    }

    public function store(StoreTaskRequest $request)
    {
        // $validatedData = $request->validate([
        //     'title' => 'required|string|max:255',
        //     'description' => 'nullable|string',
        //     'is_completed' => 'boolean',
        //     'priority' => 'integer|min:0|max:5',
        // ]);
        $user_id = Auth::user()->id;
        $validatedData = $request->validated();
        $validatedData['user_id'] = $user_id;
        $task = Task::create($validatedData);

        return response()->json($task, 200);
    }

    public function show($id)
    {
        $task = Task::find($id);
        if ($task) {
            return response()->json($task, 200);
        } else {
            return response()->json(['message' => 'Task not found'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $user_id = Auth::user()->id;
        $task = Task::find($id);

        if( $task && $task->user_id != $user_id){
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        if ($task) {
            $task->update($request->only(['title', 'description', 'is_completed', 'priority']));
            return response()->json($task, 200);
        } else {
            return response()->json(['message' => 'Task not found'], 404);
        }
    }

    public function destroy($id)
    {
        $task = Task::find($id);
        if ($task) {
            $task->delete();
            return response()->json(['message' => 'Task deleted'], 200);
        } else {
            return response()->json(['message' => 'Task not found'], 404);
        }
    }

    public function getTaskUser($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }
        $user = $task->user;
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json($user);
    }
    // Assign categories to a task
    public function assignCategories(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->categories()->attach($request->category_ids);
        return response()->json(['message' => 'Categories assigned successfully'], 200);
    }
    // Get categories of a task
    public function getTaskCategories($id){
        $task = Task::findOrFail($id);
        $categories = $task -> categories;
        return response()->json($categories, 200);
    }
}
