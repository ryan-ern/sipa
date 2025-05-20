<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Artikel extends Model
{
  protected $table = 'artikels';

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
    'user_id',
    'judul',
    'jenis',
    'isi',
    'fp_cover',
    'fn_cover',
    'tgl_berlaku'
  ];

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }
}
