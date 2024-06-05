<?php

namespace App\Models;

use App\Traits\ModelBootObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Attachment extends Model
{
    use HasFactory;
    // use ModelBootObserver;

    protected $table = 'trans_attachments';

    protected $fillable = [
        'parent_table',
        'table_id',
        'path',
        'name',
        'size',
        'extension',
        'created_by',
        'created_by_name',
        'updated_by',
        'updated_by_name',
    ];

    protected $appends = [
        'file_url',
    ];

    public function getFileUrlAttribute()
    {
        return $this->path ? Storage::disk('assets')->url($this->path) : null;
    }
}
