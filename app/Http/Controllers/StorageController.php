<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class StorageController extends Controller
{
  public function serve($path)
  {
    $filePath = "private/{$path}";

    if (!Storage::exists($filePath)) {
      return redirect()->route('not-found')->with('error', 'Data tidak ditemukan!');
    }

    return Storage::response($filePath);
  }
}
