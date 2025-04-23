<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Level;
use App\Models\UserModel;
use Illuminate\Http\Request;


class LevelController extends Controller
{
    public function index()
    {
        return Level::all();
    }

    public function store(Request $request)
    {
        $level = Level::create($request->all());
        return response()->json($level, 201);
    }

    public function show(Level $level)
    {
        return Level::find($level);
    }

    public function update(Request $request, Level $level)
    {
        $level->update($request->all());
        return Level::find($level);
    }
    public function destroy(Level $level)
    {
     
        $users = UserModel::where('level_id', $level->id)->get();
        foreach ($users as $user) {
            $user->delete();
        }
        
        // Delete the level itself
        $level->delete();
        
        return response()->json([
            'message' => 'Level and associated users deleted successfully'
        ], 200);
    }
}