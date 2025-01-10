<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Saran extends Model
{

  use HasFactory;
  protected $table = 'sarans';

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
    'id',
    'nama',
    'no_tel',
    'keterangan',
  ];
}
