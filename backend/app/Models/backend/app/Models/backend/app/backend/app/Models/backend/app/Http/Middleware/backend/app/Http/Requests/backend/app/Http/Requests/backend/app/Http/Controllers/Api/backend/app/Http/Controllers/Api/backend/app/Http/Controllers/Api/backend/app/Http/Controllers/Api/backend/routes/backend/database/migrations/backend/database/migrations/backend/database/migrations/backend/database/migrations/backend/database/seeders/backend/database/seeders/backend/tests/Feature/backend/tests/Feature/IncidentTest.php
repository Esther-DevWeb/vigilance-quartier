<?php

namespace Tests\Feature;

use App\Models\Incident;
use App\Models\IncidentType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IncidentTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_habitant_connecte_peut_creer_un_signalement()
    {
        $user = User::factory()->create();
        $type = IncidentType::create(['name' => 'Vol']);

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/incidents', [
            'incident_type_id' => $type->id,
            'title' => 'Vol de vélo',
            'description' => 'Vélo volé devant le numéro 12.',
            'neighborhood' => 'Centre',
            'severity' => 'moyenne',
            'occurred_at' => now()->toDateTimeString(),
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('incidents', ['title' => 'Vol de vélo', 'status' => 'en_attente']);
    }

    public function test_la_creation_echoue_si_un_champ_requis_manque()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->postJson('/api/incidents', [
            'title' => 'Sans type',
        ]);

        $response->assertStatus(422);
    }

    public function test_un_visiteur_non_authentifie_ne_peut_pas_signaler()
    {
        $response = $this->postJson('/api/incidents', []);
        $response->assertStatus(401);
    }

    public function test_le_fil_public_ne_retourne_que_les_signalements_valides()
    {
        $user = User::factory()->create();
        $type = IncidentType::create(['name' => 'Vol']);

        Incident::create([
            'user_id' => $user->id, 'incident_type_id' => $type->id,
            'title' => 'En attente', 'description' => 'x', 'neighborhood' => 'Centre',
            'severity' => 'faible', 'occurred_at' => now(), 'status' => 'en_attente',
        ]);
        Incident::create([
            'user_id' => $user->id, 'incident_type_id' => $type->id,
            'title' => 'Validé', 'description' => 'x', 'neighborhood' => 'Centre',
            'severity' => 'faible', 'occurred_at' => now(), 'status' => 'valide',
        ]);

        $response = $this->getJson('/api/incidents');
        $response->assertStatus(200)->assertJsonCount(1, 'data');
    }
}
