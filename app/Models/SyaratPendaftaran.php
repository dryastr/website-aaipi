<?php

namespace App\Models;

use App\Traits\ModelBootObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyaratPendaftaran extends Model
{
    use HasFactory;
    use ModelBootObserver;

    protected $table = 'ref_syarat_pendaftaran';

    protected $fillable = [
        'parent_id',
        'title',
        'label',
        'type',
        'status',
        'order_position',
        'requirment_filed',
        'created_by',
        'created_by_name',
        'updated_by',
        'updated_by_name',
    ];

    protected $appends = [
        'requirment_field_data',
        'validation_file',
        'enctype_file',
    ];

    public function getRequirmentFieldDataAttribute()
    {
        return $this->requirment_filed ? json_decode($this->requirment_filed) : null;
    }

    public function getValidationFileAttribute()
    {
        if ($this->type != 'text') {
            $validation = '';
            if ($this->type == 'file') {
                if ($this->requirment_field_data) {
                    $params = $this->requirment_field_data;
                    $validation .= $params->required ? 'required' : 'nullable';
                    $validation .= '|file'.($params->mimes ? '|mimes:'.$params->mimes : '');
                    $size_params = $params->max;
                    $size = ($size_params->size) * ($size_params->type == 'mb' ? 1024 : 1);
                    $validation .= '|max:'.$size;
                } else {
                    $validation = 'required|file|max:2048';
                }

            } else {
                $validation = 'nullable';
            }

            return $validation;
        } else {
            return null;
        }
    }

    public function getEnctypeFileAttribute()
    {
        if ($this->type == 'file') {
            if ($this->requirment_field_data) {
                $params = $this->requirment_field_data;
                if ($params->mimes) {
                    return $params->mimes == 'pdf' ? 'application/pdf' : 'image/jpeg, image/png';
                } else {
                    return null;
                }
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    public function childrens()
    {
        return $this->hasMany(SyaratPendaftaran::class, 'parent_id', 'id');
    }

    public function attachment()
    {
        return $this->hasOne(Attachment::class, 'table_id', 'id')->where('parent_table', 'ref_syarat_pendaftaran');
    }

    public function getAll()
    {
        $query = $this->select('*')
            ->where('status', 'active')
            ->where('parent_id', null)
            ->orderBy('order_position', 'ASC')
            ->with(['childrens' => function ($q) {
                $q->orderBy('order_position', 'ASC');
            }]);

        return $query->get();
    }

    public function getTypeFile()
    {
        $query = $this->select('*')
            ->where('status', 'active')
            ->whereIn('type', ['file', 'checklist'])
            ->orderBy('order_position', 'ASC')
            ->get();

        return $query;
    }
}
