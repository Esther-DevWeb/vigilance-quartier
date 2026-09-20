<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    protected $fillable = [
        'user_id', 'incident_type_id', 'title', 'description',
        'neighborhood', 'severity', 'occurred_at', 'photo_path', 'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        return $this->belongsTo(IncidentType::class, 'incident_type_id');
    }
}
