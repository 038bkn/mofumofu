<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PointController extends Controller
{
    /**
     * ポイントを加算して最新の合計を返す
     * POST /api/points/add
     */
    public function add(Request $request)
    {
        $amount = 5;
        $user = Auth::user();
        $user->increment('points', $amount);
        return response()->json([
            'status' => 'success',
            'points' => $user->fresh()->points,
        ]);
    }
}