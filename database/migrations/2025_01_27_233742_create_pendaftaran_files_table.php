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
    Schema::create('pendaftaran_files', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('pendaftaran_id');
      $table->string('file_name');
      $table->string('file_path');
      $table->timestamps();
      $table->foreign('pendaftaran_id')->references('id')->on('pendaftarans')->onDelete('cascade');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('pendaftaran_files');
  }
};
