<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'news_id',
        'parent_id',
        'nama',
        'email',
        'komentar',
        'status',
    ];

    protected $appends = [
        'pid',
        'publish_date',
    ];

    public function getPidAttribute()
    {
        return security()->encrypt($this->id);
    }

    public function getPublishDateAttribute()
    {
        $publish_date = Carbon::parse($this->created_at)->locale('id');
        $publish_date->settings(['formatFunction' => 'translatedFormat']);

        return $publish_date->format('d, M Y');
    }

    public function children()
    {
        return $this->hasMany(Comment::class, 'parent_id', 'id');
    }
}
