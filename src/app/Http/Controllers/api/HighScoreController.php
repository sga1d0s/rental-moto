<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HighScoreController extends Controller
{
    public function index(Request $request)
    {
        $limit = min((int) $request->query('limit', 10), 50);
        $game  = (string) $request->query('game', 'forge_in_the_hell');

        $rows = DB::table('high_scores')
            ->where('game', $game)
            ->orderByDesc('score')
            ->orderBy('created_at')
            ->limit($limit)
            ->get(['name', 'score']);

        return response()->json($rows);
    }

    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'game'  => 'nullable|string|max:50',
            'name'  => 'required|string|min:1|max:3',
            'score' => 'required|integer|min:0|max:2000000000',
        ]);

        if ($v->fails()) {
            return response()->json(['errors' => $v->errors()], 422);
        }

        $game  = (string) $request->input('game', 'forge_in_the_hell');
        $name  = strtoupper(substr((string) $request->input('name'), 0, 3));
        $score = (int) $request->input('score');

        DB::table('high_scores')->insert([
            'game' => $game,
            'name' => $name,
            'score' => $score,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['ok' => true], 201);
    }
}