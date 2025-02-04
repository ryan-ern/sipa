<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PendaftaranFile extends Model
{
  protected $table = 'pendaftaran_files';

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

  protected $fillable = ['id', 'pendaftaran_id', 'file_name', 'file_path'];

  public function pendaftaran()
  {
    return $this->belongsTo(Pendaftaran::class, 'pendaftaran_id');
  }
}
