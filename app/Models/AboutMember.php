<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutMember extends Model
{
    use HasFactory;
    protected $table = 'about_member';

    protected $fillable = [
        'desc_member',
        'user_id',
        'created_at',
        'updated_at'
    ];
}
