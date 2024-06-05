<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProgramKerja extends Model
{
    use HasFactory;

    protected $table = 'programkerja';

    protected $fillable = [
        // 'title_content',
        'title',
        'description',
        'image',
        // 'status_image',
        // 'banner',
        // 'status_banner',
        // 'icon',
    ];

    protected $appends = [
        'image_url',
    ];

    public function getImageUrlAttribute()
    {
        return $this->image ? Storage::disk('assets')->url($this->image) : null;
    }
}
