<?php

namespace App\Models;

use App\Traits\ModelBootObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class News extends Model
{
    use HasFactory;
    use ModelBootObserver;

    protected $table = 'cms_news';

    protected $fillable = [
        'title',
        'slug',
        'image',
        'content',
        'tags',
        'kategori',
        'status',
        'enabled_comments',
        'created_by',
        'created_by_name',
        'updated_by',
        'updated_by_name',
    ];

    protected $appends = [
        'pid',
        'image_url',
        'sort_content',
        'publish_date',
        'list_tags',
    ];

    public function getPidAttribute()
    {
        return security()->encrypt($this->id);
    }

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            if (Storage::disk('assets')->exists($this->image)) {
                return asset('storage/assets/'.$this->image);
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    public function getSortContentAttribute()
    {
        $string = strip_tags($this->content);
        if (strlen($string) > 200) {
            $string = substr($string, 0, 200).'...';
        }

        return $string;
    }

    public function getPublishDateAttribute()
    {
        $publish_date = Carbon::parse($this->created_at)->locale('id');
        $publish_date->settings(['formatFunction' => 'translatedFormat']);

        return $publish_date->format('d, M Y');
    }

    public function getListTagsAttribute()
    {
        return $this->tags ? explode(',', $this->tags) : [];
    }

    public function newsHomePage()
    {
        $query = $this->select('*')
            ->where('kategori', 'like', '%Berita%')
            ->where('status', 'publish')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        return $query;
    }

    public function getListArchives()
    {
        $query = $this->select(DB::raw('YEAR(`created_at`) AS tahun, MONTH(`updated_at`) as bulan, COUNT(*) as jumlah'))
            ->groupBy('tahun')
            ->groupBy('bulan')
            ->orderBy('tahun', 'DESC')
            ->orderBy('bulan', 'DESC')
            ->get();
        $data = collect();

        foreach ($query as $item) {
            $bulan = Carbon::create(month: $item['bulan'])->locale('id')->settings(['formatFunction' => 'translatedFormat'])->format('F');
            $data->push([
                'tahun' => $item['tahun'],
                'bulan' => $item['bulan'],
                'jumlah' => $item['jumlah'],
                'nama_bulan' => $bulan,
            ]);
        }

        return $data;
    }
}
