<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\=Kegiatan>
 */
class KegiatanFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'id' => Str::uuid(),
      'kegiatan' => $this->faker->sentence(),
      'waktu_mulai' => $this->faker->dateTimeBetween('-1 day', 'now'),
      'waktu_selesai' => $this->faker->dateTimeBetween('-2 day', 'now'),
      'keterangan' => $this->faker->text(),
    ];
  }
}
