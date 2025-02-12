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
    Schema::create('riwayats', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('user_id');
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      $table->uuid('anaks_id');
      $table->foreign('anaks_id')->references('id')->on('anaks')->onDelete('cascade');
      $table->longText('keterangan')->nullable();
      $table->string('status')->nullable();
      $table->string('fp_riwayat')->nullable();
      $table->string('fn_riwayat')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('riwayats');
  }
};
