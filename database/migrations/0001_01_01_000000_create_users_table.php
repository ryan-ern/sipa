<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('users', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->string('nama_lengkap');
      $table->string('username')->unique();
      $table->enum('role', ['admin', 'user'])->default('user');
      $table->string('password');
      $table->string('no_tel');
      $table->text('alamat');
      $table->string('jenis_kelamin');
      $table->enum('status', ['1', '0'])->default('0');
      $table->enum('sebagai', ['ortu', 'wali', 'staff'])->default('ortu');
      $table->enum('forgot', ['1', '0'])->default('0');
      $table->timestamps();
    });

    Schema::create('sessions', function (Blueprint $table) {
      $table->string('id')->primary();
      $table->foreignUuid('user_id')->nullable()->index('sessions_user_id_foreign');
      $table->string('ip_address', 45)->nullable();
      $table->text('user_agent')->nullable();
      $table->longText('payload');
      $table->integer('last_activity')->index();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('users');
    Schema::dropIfExists('sessions');
  }
};
