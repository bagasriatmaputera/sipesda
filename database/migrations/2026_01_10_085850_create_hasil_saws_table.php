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
        Schema::create('hasil_saw', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id');
            $table->foreign('siswa_id')->references('id')->on('siswa');
            $table->unsignedBigInteger('tahap_id');
            $table->foreign('tahap_id')->references('id')->on('tahaps');
            $table->unsignedBigInteger('pelanggaran_id');
            $table->foreign('pelanggaran_id')->references('id')->on('pelanggaran');

            $table->integer('nilai_c1'); // Poin Pelanggaran
            $table->integer('nilai_c2'); // Frekuensi
            $table->integer('nilai_c3'); // Tingkat

            $table->decimal('normalisasi_c1', 5, 4);
            $table->decimal('normalisasi_c2', 5, 4);
            $table->decimal('normalisasi_c3', 5, 4);

            $table->decimal('nilai_preferensi', 5, 4);
            $table->date('periode')->nullable();
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
        Schema::dropIfExists('hasil_saw');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
};
