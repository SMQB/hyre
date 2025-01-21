<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CoachingSession;
use Illuminate\Support\Facades\Auth;

class CoachingSessionController extends Controller
{
    public function index()
    {
        return CoachingSession::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:client_profiles,id',
            'title' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        return CoachingSession::create($request->all());
    }

    public function show(CoachingSession $session)
    {
        return $session;
    }

    public function update(Request $request, CoachingSession $session)
    {
        $session->update($request->all());
        return $session;
    }

    public function destroy(CoachingSession $session)
    {
        $session->delete();
        return response()->json(['message' => 'Session deleted']);
    }

    public function uncompleted()
    {
        $sessions = CoachingSession::where('client_id', Auth::id())->where('completed', false)->get();
        return response()->json($sessions);
    }

    public function complete(CoachingSession $session)
    {
        if ($session->client_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $session->update(['completed' => true]);
        return response()->json(['message' => 'Session marked as completed']);
    }
}

