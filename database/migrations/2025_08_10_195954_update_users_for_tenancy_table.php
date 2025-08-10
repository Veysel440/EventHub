<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $t) {
            $t->foreignId('tenant_id')->after('id')->constrained()->cascadeOnDelete();
            $t->string('name')->change();
        });
    }

    public function down(): void {
        Schema::table('users', function (Blueprint $t) { $t->dropConstrainedForeignId('tenant_id'); });
    }
};
