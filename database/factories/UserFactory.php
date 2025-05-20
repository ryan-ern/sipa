<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
  /**
   * The current password being used by the factory.
   */
  protected static ?string $password;

  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'id' => Str::uuid(),
      'nama_lengkap' => fake()->name(),
      'nik' => fake()->unique()->randomDigit(),
      'username' => fake()->unique()->userName(),
      'password' => static::$password ??= Hash::make('Password123#'),
      'no_tel' => fake()->phoneNumber(),
      'alamat' => fake()->address(),
      'jenis_kelamin' => fake()->randomElement(['Laki-laki', 'Perempuan']),
      'status' => fake()->randomElement(['1', '0']),
      'sebagai' => fake()->randomElement(['ortu', 'wali', 'staff']),
      'role' => fake()->randomElement(['admin', 'user']),
    ];
  }
}
