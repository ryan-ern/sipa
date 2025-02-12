<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Riwayat extends Model
{
  protected $table = 'riwayats';

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
    'anaks_id',
    'user_id',
    'keterangan',
    'status',
    'fp_riwayat',
    'fn_riwayat'
  ];

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  public function anak()
  {
    return $this->belongsTo(Anak::class, 'anaks_id', 'id');
  }
}
