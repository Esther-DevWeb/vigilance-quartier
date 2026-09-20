<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIncidentRequest;
use App\Models\Incident;
use Illuminate\Http\Request;

class IncidentController extends Controller
{
    public function index(Request $request)
    {
        $query = Incident::with(['type', 'user'])->where('status', 'valide');

        if ($request->filled('neighborhood')) {
            $query->where('neighborhood', $request->neighborhood);
        }
        if ($request->filled('incident_type_id')) {
            $query->where('incident_type_id', $request->incident_type_id);
        }
        if ($request->filled('from')) {
            $query->where('occurred_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->where('occurred_at', '<=', $request->to);
        }

        return $query->orderByDesc('occurred_at')->paginate(10);
    }

    public function show(Request $request, Incident $incident)
    {
        if ($incident->status !== 'valide' && (!$request->user('sanctum') || !$request->user('sanctum')->isAdmin())) {
            return response()->json(['message' => 'Introuvable.'], 404);
        }

        return $incident->load(['type', 'user']);
    }

    public function store(StoreIncidentRequest $request)
    {
        $path = null;
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('incidents', 'public');
        }

        $incident = Incident::create([
            'user_id' => $request->user()->id,
            'incident_type_id' => $request->incident_type_id,
            'title' => $request->title,
            'description' => $request->description,
            'neighborhood' => $request->neighborhood,
            'severity' => $request->severity,
            'occurred_at' => $request->occurred_at,
            'photo_path' => $path,
            'status' => 'en_attente',
        ]);

        return response()->json($incident, 201);
    }

    public function adminIndex()
    {
        return Incident::with(['type', 'user'])->orderByDesc('created_at')->paginate(15);
    }

    public function updateStatus(Request $request, Incident $incident)
    {
        $data = $request->validate([
            'status' => 'required|in:valide,rejete,cloture',
        ]);

        $incident->update(['status' => $data['status']]);

        return $incident;
    }
}
