<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Pendaftaran extends Model
{
  protected $table = 'pendaftarans';

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
    'user_id',
    'fn_formulir',
    'fn_surat_izin',
    'fn_suket_tidak_mampu',
    'fn_suket_kematian',
    'fn_suket_sehat',
    'fn_ktp',
    'fn_kk',
    'fn_bpjs',
    'fn_akte',
    'fn_foto',
    'fp_formulir',
    'fp_surat_izin',
    'fp_suket_tidak_mampu',
    'fp_suket_kematian',
    'fp_suket_sehat',
    'fp_ktp',
    'fp_kk',
    'fp_bpjs',
    'fp_akte',
    'fp_foto',
    'biodata',
    'keterangan',
    'status',
    'tahap',
  ];

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  public function files()
  {
    return $this->hasMany(PendaftaranFile::class, 'pendaftaran_id');
  }

  public function anak()
  {
    return $this->hasOne(Anak::class, 'pendaftaran_id');
  }
}
