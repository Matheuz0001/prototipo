<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('works', function (Blueprint $table) {
            $table->string('work_type')->nullable()->after('work_type_id');
            $table->foreignId('work_type_id')->nullable()->change();
            $table->string('advisor')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('works', function (Blueprint $table) {
            $table->dropColumn('work_type');
            $table->foreignId('work_type_id')->nullable(false)->change();
            $table->string('advisor')->nullable(false)->change();
        });
    }
};
