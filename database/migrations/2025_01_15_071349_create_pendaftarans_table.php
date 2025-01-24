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
    Schema::create('pendaftarans', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('user_id');
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
      $table->string('fn_surat_izin')->nullable();
      $table->string('fp_surat_izin')->nullable();
      $table->string('fn_suket_tidak_mampu')->nullable();
      $table->string('fp_suket_tidak_mampu')->nullable();
      $table->string('fn_suket_kematian')->nullable();
      $table->string('fp_suket_kematian')->nullable();
      $table->string('fn_suket_sehat')->nullable();
      $table->string('fp_suket_sehat')->nullable();
      $table->string('fn_ktp')->nullable();
      $table->string('fp_ktp')->nullable();
      $table->string('fn_kk')->nullable();
      $table->string('fp_kk')->nullable();
      $table->string('fn_bpjs')->nullable();
      $table->string('fp_bpjs')->nullable();
      $table->string('fn_akte')->nullable();
      $table->string('fp_akte')->nullable();
      $table->string('fn_foto')->nullable();
      $table->string('fp_foto')->nullable();
      $table->longText('biodata');
      $table->longText('keterangan')->nullable();
      $table->enum('tahap', [1, 2, 3])->default(1);
      $table->enum('status', ['lulus', 'tidak', 'perbaikan', 'berlangsung'])->default('berlangsung');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('pendaftarans');
  }
};
