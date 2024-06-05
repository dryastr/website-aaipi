<?php

namespace App\Models;

use App\Traits\ModelBootObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Sponsor extends Model
{
    use HasFactory;
    use ModelBootObserver;

    protected $table = 'sponsor';

    protected $fillable = [
        'title',
        'link',
        'image',
        'expired_at',
        'created_by',
        'created_by_name',
        'updated_by',
        'updated_by_name',
    ];

    protected $appends = [
        'pid',
        'image_url',
    ];

    public function getPidAttribute()
    {
        return security()->encrypt($this->id);
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? Storage::disk('assets')->url($this->image) : null;
    }
}
