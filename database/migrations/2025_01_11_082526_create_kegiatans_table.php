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
    Schema::create('kegiatans', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->string('kegiatan');
      $table->datetime('waktu_mulai');
      $table->datetime('waktu_selesai');
      $table->longText('keterangan');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('kegiatans');
  }
};
