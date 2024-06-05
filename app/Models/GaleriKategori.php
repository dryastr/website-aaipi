<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class GaleriKategori extends Model
{
    use HasFactory;

    protected $table = 'cms_galeri_kategori';

    protected $fillable = [
        'category',
        'image',
        'title',
        'sub_title',
        'created_by',
        'created_by_name',
        'updated_by',
        'updated_by_name',
    ];

    protected $appends = [
        'image_url',
        'categories',
        'date',
        'location',
    ];


    public function getCategoriesAttribute()
    {
        $ids = explode(',', $this->category);
        $query = CategoryOnGaleri::whereIn('id', $ids);

        return $query->get();
    }

    public function getDateAttribute()
    {
        $categories = $this->categories;
        return $categories->isEmpty() ? null : $categories[0]->date;
    }

    public function getLocationAttribute()
    {
        $categories = $this->categories;
        return $categories->isEmpty() ? null : $categories[0]->location;
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? Storage::disk('assets')->url($this->image) : null;
    }
}
