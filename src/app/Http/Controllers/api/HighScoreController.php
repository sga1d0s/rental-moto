<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HighScoreController extends Controller
{
    /**
     * CORS helper SOLO para el juego
     */
    private function withGameCors(Request $request, $response)
    {
        $origin = $request->headers->get('Origin');
        $allowed = [
            'http://192.168.1.96:5180',
        ];

        if ($origin && in_array($origin, $allowed, true)) {
            $response->headers->set('Access-Control-Allow-Origin', $origin);
            $response->headers->set('Vary', 'Origin');
        }

        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');

        return $response;
    }

    /**
     * PRE-FLIGHT (OPTIONS)
     * 👉 ESTO es el punto B)
     */
    public function options(Request $request)
    {
        $response = response('', 204);
        return $this->withGameCors($request, $response);
    }

    /**
     * GET /api/high-scores
     */
    public function index(Request $request)
    {
        $limit = min((int)$request->query('limit', 10), 50);
        $game  = $request->query('game', 'forge_in_the_hell');

        $rows = DB::table('high_scores')
            ->where('game', $game)
            ->orderByDesc('score')
            ->orderBy('created_at')
            ->limit($limit)
            ->get(['name', 'score']);

        $response = response()->json($rows);
        return $this->withGameCors($request, $response);
    }

    /**
     * POST /api/high-scores
     */
    public function store(Request $request)
    {
        $name  = strtoupper(substr($request->input('name', ''), 0, 3));
        $score = (int)$request->input('score', 0);
        $game  = $request->input('game', 'forge_in_the_hell');

        DB::table('high_scores')->insert([
            'game' => $game,
            'name' => $name,
            'score' => max(0, $score),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = response()->json(['ok' => true], 201);
        return $this->withGameCors($request, $response);
    }
}