<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Banner extends Model
{
    use HasFactory;

    protected $table = 'banners';

    protected $fillable = ['title', 'desc', 'image', 'image_banner', 'link', 'kode', 'type', 'color'];

    public const TYPE_STANDARD = 'standar';
    public const TYPE_QUOTE = 'quote';

    public static function getTypeOptions()
    {
        return [
            self::TYPE_STANDARD => 'Standar',
            self::TYPE_QUOTE => 'Quote',
        ];
    }

    protected $appends = [
        'image_url',
    ];

    public function getImageUrlAttribute()
    {
        return $this->image ? Storage::disk('assets')->url($this->image) : null;
    }

    public function getImageBannerUrlAttribute()
    {
        return $this->image_banner ? Storage::disk('assets')->url($this->image) : null;
    }
}
