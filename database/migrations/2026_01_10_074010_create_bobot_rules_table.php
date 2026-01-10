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
         DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // my table definitions go here
        Schema::create('bobot_rules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kriteria_id');
            $table->foreign('kriteria_id')->references('id')->on('kriteria');
            $table->unsignedBigInteger('tahap_id');
            $table->foreign('tahap_id')->references('id')->on('tahaps');
            $table->decimal('bobot', 3, 2);
            $table->timestamps();
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // my table definitions go here
        Schema::dropIfExists('bobot_rules');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
};
