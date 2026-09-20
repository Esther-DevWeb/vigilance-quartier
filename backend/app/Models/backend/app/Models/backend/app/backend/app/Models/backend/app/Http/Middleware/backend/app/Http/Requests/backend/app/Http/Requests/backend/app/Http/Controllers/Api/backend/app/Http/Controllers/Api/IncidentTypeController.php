<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\IncidentType;

class IncidentTypeController extends Controller
{
    public function index()
    {
        return IncidentType::all();
    }
}
