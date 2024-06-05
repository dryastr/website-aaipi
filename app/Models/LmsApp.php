<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class LmsApp extends Model
{
    use HasFactory;

    protected $table = 'lms_apps';

    protected $fillable = [
        'title',
        'subtitle',
        'desc',
        'image',
    ];

    protected $appends = [
        'image_url',
    ];

    public function getImageUrlAttribute()
    {
        return $this->image ? Storage::disk('assets')->url($this->image) : null;
    }
}
