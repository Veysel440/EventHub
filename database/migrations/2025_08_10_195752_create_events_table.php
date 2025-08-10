<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $t) {
            $t->id();
            $t->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $t->foreignId('venue_id')->nullable()->constrained()->nullOnDelete();
            $t->uuid('public_id')->unique();
            $t->string('title');
            $t->text('description')->nullable();
            $t->dateTime('starts_at');
            $t->dateTime('ends_at');
            $t->string('status')->default('draft');
            $t->timestamps();
            $t->index(['tenant_id','starts_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
