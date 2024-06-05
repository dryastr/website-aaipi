<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmail;
use App\Models\SyaratPendaftaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class VerifikasiKeanggotaanController extends Controller
{
    protected $dirView;

    protected $model;

    protected $modelSyaratPendaftaran;

    public function __construct()
    {
        // $this->middleware('can:user-management.user.view')->only(['index', 'getView']);
        // $this->middleware('can:user-management.user.create')->only(['create', 'store']);
        // $this->middleware('can:user-management.user.edit')->only(['edit', 'update']);
        // $this->middleware('can:user-management.user.delete')->only(['delete']);

        $this->model = new User();
        $this->modelSyaratPendaftaran = new SyaratPendaftaran();
        $this->dirView = 'admin.pages.verifikasi.keanggotaan.';
    }

    public function index(Request $request)
    {
        $type = $request->type ? $request->type : 'dalam-antrian';

        $status = [
            ['value' => 'dalam-antrian', 'title' => 'Dalam Antrian', 'icon' => '<i class="fas fa-users"></i>'],
            ['value' => 'disetujui', 'title' => 'DiSetujui', 'icon' => '<i class="fas fa-user-check"></i>'],
            ['value' => 'ditolak', 'title' => 'Ditolak', 'icon' => '<i class="fas fa-user-times"></i>'],
        ];

        $data = [
            'title' => 'Verifikasi Keanggotaan',
            'type' => $type,
            'status' => $status,
        ];

        return view($this->dirView.'index', $data);
    }

    public function getView(Request $request, $type)
    {
        $columns = $request->input('columns');
        $query = $this->model->select('*')->latest()
            ->where('role_id', '!=', 1)
            // ->where('status', 'active')
            ->whereHas('registration', function ($q) use ($type) {
                $q->where('status_approval', $type);
            });
        if ($request->filled('search.value')) {
            $query->where(function ($query) use ($columns, $request) {
                foreach ($columns as $column) {
                    if ($column['searchable'] == 'true') {
                        $query->orWhere($column['data'], 'like', '%'.$request->input('search.value').'%');
                    }
                }
            });
        }

        // Order by specific columns
        if ($request->input('order')) {
            foreach ($request->input('order') as $order) {
                $query->orderBy($request->input('columns')[$order['column']]['data'], $order['dir']);
            }
        }

        // relation
        $query->with([
            'role:id,name',
            'registration',
        ]);

        // Paginate the results
        $data = $query->paginate($request->input('length'));

        return response()->json([
            'status' => true,
            'message' => 'Berhasil Menampilkan data',
            'data' => $data->items(),
            'recordsTotal' => $data->total(),
            'recordsFiltered' => $data->total(),
        ]);
    }

    public function show($id)
    {
        $id = security()->decrypt($id);
        $query = $this->model->select('*')
            ->where('id', $id)
            ->where('role_id', '!=', 1)
            // ->where('status', 'active')
            ->whereHas('registration', function ($q) {
                $q->where('status_approval', 'dalam-antrian');
            })
            ->with([
                'role:id,name',
                'registration',
                'attachment_register',
            ]);
        $data_params = $query->firstOrFail();
        $item_persyaratan = [];
        if ($data_params['attachment_register']) {
            $persyaratan = json_decode($data_params['attachment_register']['value']);
            $result_persyaratan = [];
            foreach ($persyaratan->persyaratan as $p) {
                $findDataPersyaratan = $this->modelSyaratPendaftaran->where('id', $p->ref_id)->first();
                if ($findDataPersyaratan) {
                    $url_file = null;
                    if ($findDataPersyaratan['type'] == 'file') {
                        $url_file = $p->value ? Storage::disk('assets')->url($p->value) : null;
                    }
                    $result_persyaratan[] = [
                        'data' => $findDataPersyaratan,
                        'id' => $findDataPersyaratan['id'],
                        'title' => $findDataPersyaratan['title'],
                        'label' => $findDataPersyaratan['label'],
                        'type' => $findDataPersyaratan['type'],
                        'url_file' => $url_file,
                        'value' => $p->value,
                    ];
                }
            }
            $persyaratan->persyaratan = $result_persyaratan;
            $item_persyaratan['persetujuan'] = $persyaratan->persetujuan;
            $item_persyaratan['data'] = $result_persyaratan;
        }

        $data = [
            'title' => 'Verifikasi Keanggotaan',
            'item' => $data_params,
            'item_persyaratan' => $item_persyaratan,
        ];

        return view($this->dirView.'detail', $data);
    }
    

    public function changeStatusRegistrasi(Request $request, $id)
    {
        $id = security()->decrypt($id);
    
        $validate = Validator::make($request->only(['status_approval', 'catatan']), [
            'status_approval' => ['required', 'in:disetujui,ditolak'],
            'catatan' => ['exclude_if:status_approval,disetujui', 'required'],
        ]);
    
        if ($validate->fails()) {
            return response()->json(['status' => false, 'message' => 'Error Validation', 'errors' => $validate->errors()], 422);
        }
    
        $data = $validate->validated();
        $userAction = auth()->user();
        $user = $this->model->find($id);
        $user->email_verify_key = Str::random(20);
    
        if ($data['status_approval'] == 'disetujui') {
            $data['approval_at'] = now();
            $data['approval_by'] = $userAction->id;
            $data['approval_by_name'] = $userAction->fullname;
            $user->status = 'active';
        } else {
            $data['rejected_at'] = now();
            $data['rejected_by'] = $userAction->id;
            $data['rejected_by_name'] = $userAction->fullname;
            $data['set_daftar_ulang'] = true;
    
            SendEmail::dispatch('notifikasi-penolakan-keanggotaan', [
                'title' => 'Notifikasi Penolakan Keanggotaan',
                'email' => $user['email'],
                'content' => [
                    'status_approval' => $data['status_approval'],
                    'catatan' => $data['catatan'] ?? '',
                    'link' => route('memberArea.index'),
                ],
            ]);
    
            $user->delete();
    
            return response()->json([
                'status' => true,
                'message' => 'Pengguna telah ditolak dan email pemberitahuan penolakan telah dikirim.',
            ]);
        }
    
        $user->save();
    
        $user->registration()->update($data);
    
        SendEmail::dispatch('notifikasi-verifikasi-keanggotaan', [
            'title' => 'Verifikasi Keanggotaan Anda di AAIPI',
            'email' => $user['email'],
            'content' => [
                'status_approval' => $data['status_approval'],
                'catatan' => $data['catatan'] ?? '',
                'link' => route('memberArea.verification').'?kode='.security()->encrypt($user->email_verify_key),
            ],
    
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Berhasil Mengubah data',
        ]);
    }
    
}
