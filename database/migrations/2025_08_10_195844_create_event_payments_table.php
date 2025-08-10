<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $t) {
            $t->id();
            $t->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $t->foreignId('registration_id')->constrained()->cascadeOnDelete();
            $t->decimal('amount',10,2);
            $t->string('currency',3)->default('TRY');
            $t->string('provider')->nullable();
            $t->string('provider_ref')->nullable();
            $t->string('status')->default('initiated');
            $t->json('meta')->nullable();
            $t->timestamps();
            $t->index(['registration_id','status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_payments');
    }
};
