<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Kegiatan extends Model
{
  use HasFactory;

  protected $table = 'kegiatans';

  protected $keyType = 'string';
  public $incrementing = false;
  protected static function boot()
  {
    parent::boot();

    static::creating(function ($model) {
      if (!$model->id) {
        $model->id = (string) Str::uuid();
      }
    });
  }
  protected $fillable = [
    'kegiatan',
    'waktu_mulai',
    'waktu_selesai',
    'keterangan',
  ];
}
