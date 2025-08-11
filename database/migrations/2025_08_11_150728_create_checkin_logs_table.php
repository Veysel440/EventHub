<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('checkin_logs', function (Blueprint $t) {
            $t->id();
            $t->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $t->foreignId('registration_id')->constrained()->cascadeOnDelete();
            $t->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $t->string('ip', 45)->nullable();
            $t->string('user_agent')->nullable();
            $t->string('device')->nullable();
            $t->timestamp('checked_in_at');
            $t->timestamps();

            $t->index(['tenant_id','registration_id']);
            $t->index(['checked_in_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checkin_logs');
    }
};
