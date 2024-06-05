<?php

namespace App\Models;

use App\Helpers\Constants\Queue;
use App\Jobs\Sync\User as UserSync;
use App\Traits\ModelBootObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, ModelBootObserver, Notifiable;
    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fullname',
        'email',
        'mobile',
        'role_id',
        'avatar',
        'password',
        'email_verify_key',
        'email_verified_at',
        'status',
        'nama_gelar',
        'gelar_depan',
        'gelar_belakang',
        'ref_provinsi_id',
        'ref_kota_kab_id',
        'nip',
        'nrp',
        'golongan_kode',
        'nama_pangkat',
        'kode_jenjang_jabatan',
        'kode_jabatan',
        'nama_jenjang_jabatan',
        'kelompok_jabatan',
        'kode_unit_kerja',
        'nama_unit',
        'kode_instansi',
        'nama_instansi',
        'nomor_anggota',
        'created_by',
        'created_by_name',
        'updated_by',
        'updated_by_name',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'pid',
        'is_admin',
        'avatar_url',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::created(function ($model) {
            $data = $model->toArray();
            $data['action'] = 'created';
            $data['password'] = $model->password;
            UserSync::dispatch($data)->onQueue(Queue::SYNC_USER_LMS);
            UserSync::dispatch($data)->onQueue(Queue::SYNC_USER_TS);
        });

        static::updated(function ($model) {
            $data = $model->toArray();
            $data['action'] = 'updated';
            $data['password'] = $model->password;
            UserSync::dispatch($data)->onQueue(Queue::SYNC_USER_LMS);
            UserSync::dispatch($data)->onQueue(Queue::SYNC_USER_TS);
        });

        static::deleting(function ($model) {
            $data = $model->toArray();
            $data['action'] = 'deleted';
            $data['password'] = $model->password;
            UserSync::dispatch($data)->onQueue(Queue::SYNC_USER_LMS);
            UserSync::dispatch($data)->onQueue(Queue::SYNC_USER_TS);
        });
    }

     public function sendPasswordResetNotification($token)
    {
        $resetLink = route('password.reset', $token);

        $this->notify(new ResetPasswordNotification($resetLink));
    }


    public function getIsAdminAttribute()
    {
        return $this->role_id == 1;
    }

    public function getPidAttribute()
    {
        return security()->encrypt($this->id);
    }

    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            if (Storage::disk('assets')->exists($this->avatar)) {
                return asset('storage/assets/' . $this->avatar);
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    public function registration()
    {
        return $this->hasOne(Registration::class, 'user_id', 'id');
    }

    public function permission()
    {
        return $this->hasManyThrough(Permission::class, RoleHasPermission::class, 'user_id', 'role_id', 'id', 'role_id');
    }

    public function hasPermission()
    {
        return $this->hasOne(RoleHasPermission::class, 'role_id', 'role_id');
    }

    public function PembayaranKeanggotaan()
    {
        return $this->hasOne(PembayaranKeanggotaan::class, 'user_id', 'id')->ofMany([
            'tanggal_expired' => 'MAX',
            'id' => 'MAX',
        ], function (Builder $query) {
            $query->where('status', 'terverifikasi');
        });
    }

    public function attachment()
    {
        return $this->hasOne(Attachment::class, 'created_by', 'id')
            ->where('parent_table', 'ref_syarat_pendaftaran');
    }

    public function attachment_register()
    {
        return $this->hasOne(TransSyaratPendaftaran::class, 'user_id', 'id');
        // return $this->hasManyThrough(SyaratPendaftaran::class, Attachment::class, 'created_by', 'id', 'id', 'table_id');
    }

    public function getMe()
    {
        if (Auth::check()) {
            $user = $this->with(['role', 'registration'])->where('id', Auth::user()->id)->first();
        } else {
            $user = null;
        }

        return $user;
    }

    public function status_keanggotaan($id = null)
    {
        $query = $this->where('id', $id)->where('role_id', '!=', 1)
            ->with(['PembayaranKeanggotaan'])
            ->first();

        if ($query) {
            $query = $query->toArray();
            $pembayaran = $query['pembayaran_keanggotaan'];
            if ($pembayaran) {
                $status_active = $pembayaran['status_active'];
                if ($status_active['status']) {
                    return [
                        'status' => $status_active['selisih'] < 5 ? 'mendekati-kadaluwarsa' : 'masa-tenggang',
                        'sisa' => $status_active['selisih'],
                    ];
                } else {
                    return [
                        'status' => 'kadaluwarsa',
                        'sisa' => $status_active['selisih'],
                    ];
                }
            } else {
                return [
                    'status' => 'belum-aktif',
                    'sisa' => 0,
                ];
            }
        } else {
            return null;
        }

    }

    public function countUserByRole($role = 1)
    {
        $query = $this->where('role_id', $role)->where('status', 'active')->count();

        return $query;
    }
}
