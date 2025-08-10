<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_sessions', function (Blueprint $t) {
            $t->id();
            $t->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $t->foreignId('event_id')->constrained()->cascadeOnDelete();
            $t->string('title')->nullable();
            $t->dateTime('starts_at');
            $t->dateTime('ends_at');
            $t->timestamps();
            $t->index(['event_id','starts_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_sessions');
    }
};
