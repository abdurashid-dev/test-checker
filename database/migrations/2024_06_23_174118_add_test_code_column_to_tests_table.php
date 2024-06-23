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
        Schema::table('tests', function (Blueprint $table) {
            $table->string('test_code')->nullable();
        });

        $tests = \App\Models\Test::all();
        $tests->each(function ($test) {
            $test->update([
                'test_code' => rand(100000, 999999),
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tests', function (Blueprint $table) {
            $table->dropColumn('test_code');
        });
    }
};
