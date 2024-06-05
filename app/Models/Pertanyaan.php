<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Pertanyaan extends Model
{
    use HasFactory;

    protected $table = 'pertanyaan';

    protected $fillable = [
        'pertanyaan',
        'jawaban',
        'is_displayed',
    ];

    //     protected $appends = [
    //         'image_url',
    //     ];

    //     public function getImageUrlAttribute()
    // {
    //     // Check apakah nilai image tidak null
    //     if ($this->image) {
    //         return Storage::disk('assets')->exists($this->image) ? asset('assets/' . $this->image) : null;
    //     } else {
    //         return null; // Jika image null, kembalikan null
    //     }
    // }

}
