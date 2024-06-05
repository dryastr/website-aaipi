<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryOnGaleri extends Model
{
    use HasFactory;

    protected $table = 'category_on_galeri';

    protected $fillable = [
        'kode',
        'title',
        'date',
        'location',
        'created_by',
        'created_by_name',
        'updated_by',
        'updated_by_name',
    ];

    public function galeryCategori()
    {
        return $this->belongsToMany(GaleriKategori::class);
    }
}
