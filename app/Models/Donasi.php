<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Donasi extends Model
{
  protected $table = 'donasis';

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
    'nama',
    'alamat',
    'jenis',
    'kegunaan',
    'fp_donasi',
    'fn_donasi',
    'keterangan',
  ];
}
