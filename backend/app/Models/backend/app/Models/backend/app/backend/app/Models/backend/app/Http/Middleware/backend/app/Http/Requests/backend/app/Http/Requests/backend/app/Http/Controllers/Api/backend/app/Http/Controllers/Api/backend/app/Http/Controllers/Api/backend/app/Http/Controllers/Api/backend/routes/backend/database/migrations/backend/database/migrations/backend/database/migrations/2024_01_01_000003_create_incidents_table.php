<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('incident_type_id')->constrained();
            $table->string('title');
            $table->text('description');
            $table->string('neighborhood');
            $table->string('severity');
            $table->dateTime('occurred_at');
            $table->string('photo_path')->nullable();
            $table->string('status')->default('en_attente');
            $table->timestamps();
            $table->index(['neighborhood', 'status', 'incident_type_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('incidents');
    }
};
