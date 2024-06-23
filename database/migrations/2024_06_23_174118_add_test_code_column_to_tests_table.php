<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
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
            do {
                $randomNumber = rand(100000, 999999);
            } while (\App\Models\Test::where('test_code', $randomNumber)->exists());

            $test->update([
                'test_code' => $randomNumber
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
