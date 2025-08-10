<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ticket_types', function (Blueprint $t) {
            $t->id();
            $t->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $t->foreignId('event_id')->constrained()->cascadeOnDelete();
            $t->string('name');
            $t->unsignedInteger('stock');
            $t->decimal('price',10,2);
            $t->string('currency',3)->default('TRY');
            $t->timestamps();
            $t->unique(['event_id','name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_ticket_types');
    }
};
