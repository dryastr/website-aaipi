<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmail;
use App\Models\KotaKab;
use App\Models\PembayaranKeanggotaan;
use App\Models\Provinsi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VerifikasiPembayaranController extends Controller
{
    protected $dirView;

    protected $model;

    protected $modelUser;

    public function __construct()
    {
        $this->model = new PembayaranKeanggotaan();
        $this->modelUser = new User();
        $this->dirView = 'admin.pages.verifikasi.pembayaran.';
    }

    public function index(Request $request)
    {
        $type = $request->type ? $request->type : 'verifikasi-pembayaran';

        $status = [
            ['value' => 'verifikasi-pembayaran', 'title' => 'Verifikasi pembayaran', 'icon' => '<i class="fas fa-edit"></i>'],
            ['value' => 'terverifikasi', 'title' => 'Terverifikasi', 'icon' => '<i class="fas fa-check"></i>'],
            ['value' => 'ditolak', 'title' => 'Ditolak', 'icon' => '<i class="fas fa-times"></i>'],
        ];

        $data = [
            'title' => 'Verifikasi Pembayaran',
            'type' => $type,
            'status' => $status,
        ];

        return view($this->dirView.'index', $data);
    }

    public function getView(Request $request, $type)
    {
        $columns = $request->input('columns');
        $query = $this->model->select('*')->latest()
            ->where('user_id', '!=', null)
            ->where('status', $type);
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
            'user' => [
                'role:id,name',
                'registration',
            ],
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
            ->with([
                'user' => [
                    'role:id,name',
                    'registration',
                    'PembayaranKeanggotaan',
                ],
                'attachment',
            ]);
        $data = [
            'title' => 'Verifikasi Pembayaran',
            'item' => $query->first(),
        ];

        return view($this->dirView.'detail', $data);
    }

    public function changeStatus(Request $request, $id)
    {
        $id = security()->decrypt($id);
        $validate = Validator::make($request->only(['status', 'alasan']), [
            'status' => ['required', 'in:terverifikasi,ditolak'],
            'alasan' => ['exclude_if:status,terverifikasi', 'required'],
        ]);

        if ($validate->fails()) {
            return response()->json(['status' => false, 'message' => 'Error Validation', 'errors' => $validate->errors()], 422);
        }

        $type = $request->status;
        $item = $this->model
            ->where('id', $id)
            ->where('user_id', '!=', null)
            ->with([
                'user' => [
                    'PembayaranKeanggotaan',
                ],
                'attachment',
            ])->first();

        $data = $validate->validated();

        if ($item) {
            $userAction = auth()->user();
            if ($type == 'terverifikasi') {
                $user = $item['user']->toArray();
                $pembayaran = $user['pembayaran_keanggotaan'];
                if ($pembayaran) {
                    $tanggal_expired = new Carbon($pembayaran['tanggal_expired']);
                    $data['tanggal_expired'] = $pembayaran['status_active']['status'] ? $tanggal_expired->addYear() : now()->addYear();
                    $data['tamgg'] = $pembayaran;
                } else {
                    $data['tanggal_expired'] = now()->addYear();
                }
                $data['approval_at'] = now();
                $data['approval_by'] = $userAction->id;
                $data['approval_by_name'] = $userAction->fullname;

                if ($user['nomor_anggota'] == null) {
                    $itemProvinsi = Provinsi::find($user['ref_provinsi_id']);
                    $itemKotaKab = KotaKab::find($user['ref_kota_kab_id']);

                    $nomor_anggota = '';

                    if ($itemKotaKab) {
                        $nomor_anggota .= $itemKotaKab['kode'];
                    } else {
                        $nomor_anggota .= $itemProvinsi ? $itemProvinsi['kode'].'00' : '0000';
                    }

                    $nomor_anggota .= '.000.';

                    $nomor_anggota .= str_pad($user['id'], 5, 0, STR_PAD_LEFT);

                    $this->modelUser->find($user['id'])->update(['nomor_anggota' => $nomor_anggota]);
                }
            } else {
                $data['alasan'] = $request->alasan;
                $data['catatan'] = $request->catatan;
                $data['rejected_at'] = now();
                $data['tagihan'] = 0;
                $data['nominal_bayar'] = 0;
                $data['rejected_by'] = $userAction->id;
                $data['rejected_by_name'] = $userAction->fullname;
            }

            $this->model->find($id)->update($data);

            SendEmail::dispatch('notifikasi-verifikasi-pembayaran', [
                'title' => 'Notifikasi Verifikasi Pembayaran Keanggotaan',
                'email' => $item['user']['email'],
                'content' => $data,
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Berhasil Mengubah data',
        ]);
    }
}
