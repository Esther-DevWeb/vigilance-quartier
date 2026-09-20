<?php

namespace Tests\Feature;

use App\Models\Incident;
use App\Models\IncidentType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModerationTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_administrateur_peut_valider_un_signalement()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $type = IncidentType::create(['name' => 'Vol']);
        $incident = Incident::create([
            'user_id' => $admin->id, 'incident_type_id' => $type->id,
            'title' => 'Test', 'description' => 'x', 'neighborhood' => 'Centre',
            'severity' => 'faible', 'occurred_at' => now(), 'status' => 'en_attente',
        ]);

        $response = $this->actingAs($admin, 'sanctum')
            ->patchJson("/api/incidents/{$incident->id}/status", ['status' => 'valide']);

        $response->assertStatus(200);
        $this->assertDatabaseHas('incidents', ['id' => $incident->id, 'status' => 'valide']);
    }

    public function test_un_habitant_ne_peut_pas_moderer_un_signalement()
    {
        $user = User::factory()->create(['role' => 'habitant']);
        $type = IncidentType::create(['name' => 'Vol']);
        $incident = Incident::create([
            'user_id' => $user->id, 'incident_type_id' => $type->id,
            'title' => 'Test', 'description' => 'x', 'neighborhood' => 'Centre',
            'severity' => 'faible', 'occurred_at' => now(), 'status' => 'en_attente',
        ]);

        $response = $this->actingAs($user, 'sanctum')
            ->patchJson("/api/incidents/{$incident->id}/status", ['status' => 'valide']);

        $response->assertStatus(403);
    }

    public function test_un_habitant_ne_peut_pas_publier_une_alerte()
    {
        $user = User::factory()->create(['role' => 'habitant']);

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/alerts', [
            'title' => 'Alerte', 'message' => 'x', 'urgency' => 'info', 'neighborhood' => 'Centre',
        ]);

        $response->assertStatus(403);
    }
}
