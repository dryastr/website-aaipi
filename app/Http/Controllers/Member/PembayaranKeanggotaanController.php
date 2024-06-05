<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Attachment;
use App\Models\BiayaKeanggotaan;
use App\Models\PembayaranKeanggotaan;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class PembayaranKeanggotaanController extends Controller
{
    protected $dirView;

    public function __construct()
    {
        $this->dirView = 'member.pages.tagihan.';
    }

    public function index()
    {
        $user = auth()->user()->getMe();

        // Ambil informasi biaya keanggotaan yang aktif
        $biayaKeanggotaanAktif = BiayaKeanggotaan::where('tahun', date('Y'))
            ->where('status', 'active')
            ->where('jenis_keanggotaan', $user['role']['id'] == 2 ? 'anggota-biasa' : 'anggota-luar-biasa')
            ->first();

        $pembayaran = PembayaranKeanggotaan::where('user_id', $user['id'])
            ->get();

        // Ambil informasi tagihan keanggotaan user untuk tahun ini
        $tagihanBelumDibayar = $biayaKeanggotaanAktif ? $this->getTagihanBelumDibayar($user['id'], $biayaKeanggotaanAktif->id) : [];

        $data = [
            'title' => 'Tagihan dan Pembayaran',
            'user' => $user,
            'pembayaran' => $pembayaran,
            'tagihans' => $tagihanBelumDibayar,
        ];
        session()->flash('success', 'Pembayaran keanggotaan berhasil diedit.');

        return view($this->dirView . 'index', $data);
    }

    public function datatables()
    {
        $user = auth()->user()->getMe();
        $pembayaran = PembayaranKeanggotaan::select("*")->where('user_id', $user['id'])->orderBy('id', 'desc')->get();
        $no = 1;
        return DataTables::of($pembayaran)
            ->addColumn('no', function ($row) use ($no) {
                static $no = 0;
                return $no++;
            })
            ->addColumn('tagihan', function ($row) {
                return Str::ucfirst(Str::replace('-', ' ', $row->refTagihan->jenis_keanggotaan)) . ' - ' . $row->refTagihan->tahun;
            })
            ->addColumn('nominal', function ($row) {
                return $row->nominal_bayar_rupiah;
            })
            ->addColumn('status', function ($row) {
                return $row->status_description;
            })
            ->editColumn('alasan', function($row){
                return $row->alasan ?? '-';
            })
            ->addColumn('aksi', function ($row) {
                $encryptedId = encrypt($row->id); 
               $x = route('tagihan.edit', ['id' => $encryptedId]); 
                if ($row->status == "verifikasi-pembayaran") {
                    return '<div class="d-flex">
                            <a href="' . $x . '" class="btn btn-warning"><i class="fa fa-edit"></i> Edit</a>
                            <button class="btn btn-danger btn-delete" data-payment-id="' . $row->id . '">
                                <i class="fa fa-trash"></i> Hapus
                            </button>
                        </div>';
                }
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    private function getTagihanBelumDibayar($userId, $biayaKeanggotaanId)
    {
        // Ambil informasi tagihan yang belum dibayar
        $tagihanBelumDibayar = BiayaKeanggotaan::where('id', $biayaKeanggotaanId)
            ->whereDoesntHave('pembayaran', function ($query) use ($userId) {
                $query->where('user_id', $userId)->whereNotIn('status', ['ditolak']);
            })
            ->get();

        return $tagihanBelumDibayar;
    }

    public function create(Request $request)
    {
        $user = auth()->user()->getMe();
        // Ambil informasi biaya keanggotaan yang aktif
        $biayaKeanggotaanAktif = BiayaKeanggotaan::where('id', $request['tagihan_id'])
            ->where('status', 'active')
            ->first();

        $data = [
            'title' => 'Pembayaran Keanggotaan',
            'user' => $user,
            'biayaKeanggotaan' => $biayaKeanggotaanAktif,
        ];

        return view($this->dirView . 'create', $data);
    }

    public function store(Request $request)
    {
        $user = auth()->user()->getMe();
        $request->validate([
            'tagihan_id' => 'required|exists:ref_biaya_keanggotaan,id',
            'nominal_bayar' => 'required|numeric|min:0',
            'catatan' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        try {

            $biayaKeanggotaanAktif = BiayaKeanggotaan::findOrFail($request->input('tagihan_id'));


            $tanggalExpired = Carbon::now()->addYear();


            $attachmentPath = null;


            if ($request->hasFile('attachment')) {
                $attachment = $request->file('attachment');
                $attachmentName = Str::random(20) . '.' . $attachment->getClientOriginalExtension();
                $attachmentPath = $attachment->storeAs('attachments', $attachmentName, 'public');
            }


            $pembayaranKeanggotaan = PembayaranKeanggotaan::create([
                'user_id' => $user['id'],
                'tagihan_id' => $biayaKeanggotaanAktif->id,
                'tagihan' => $biayaKeanggotaanAktif->biaya,
                'nominal_bayar' => $request->input('nominal_bayar'),
                'status' => 'verifikasi-pembayaran',
                'catatan' => $request->input('catatan'),
                'tanggal_bayar' => Carbon::now('Asia/Jakarta'),
                'tanggal_expired' => $tanggalExpired,
                'attachment' => $attachmentPath,

            ]);

            if ($request->hasFile('attachment')) {
                $file = $request['attachment'];
                $attachmentData = [
                    'parent_table' => 'trans_pembayaran_keanggotaan',
                    'table_id' => $pembayaranKeanggotaan->id,
                    'path' => $attachmentPath,
                    'name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'extension' => $file->extension(),
                ];
                Attachment::create($attachmentData);
            }

            Session::flash('sukses', 'Berhasil Melakukan Pembayaran');

            return redirect()->route('member.tagihan')->with('success', 'Pembayaran berhasil disimpan');
        } catch (Exception $e) {
            return redirect()->route('tagihan.create')->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        // dd(decrypt($id));
        $user = auth()->user()->getMe();
        
        $encryptdata = decrypt($id);
        $pembayaranKeanggotaan = PembayaranKeanggotaan::findOrFail($encryptdata);


        if ($pembayaranKeanggotaan->user_id != $user->id) {

            return redirect()->route('tagihan.edit')->withErrors(['error' => 'Anda tidak memiliki izin untuk mengedit pembayaran ini.']);
        }

        $data = [
            'title' => 'Edit Pembayaran Keanggotaan',
            'user' => $user,
            'pembayaranKeanggotaan' => $pembayaranKeanggotaan,
        ];

        return view($this->dirView . 'edit', $data);
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user()->getMe();
        $request->validate([
            'nominal_bayar' => 'required|numeric|min:0',
            'catatan' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        try {

            $pembayaranKeanggotaan = PembayaranKeanggotaan::findOrFail($id);


            if ($pembayaranKeanggotaan->user_id != $user->id) {

                return redirect()->route('pembayaran.index')->withErrors(['error' => 'Anda tidak memiliki izin untuk memperbarui pembayaran ini.']);
            }


            $tanggalExpired = Carbon::now()->addYear();


            $attachmentPath = $pembayaranKeanggotaan->attachment ? $pembayaranKeanggotaan->attachment->path : null;


            if ($request->hasFile('attachment')) {
                $attachment = $request->file('attachment');
                $attachmentName = Str::random(20) . '.' . $attachment->getClientOriginalExtension();
                $attachmentPath = $attachment->storeAs('attachments', $attachmentName, 'public');


                if ($pembayaranKeanggotaan->attachment) {
                    $pembayaranKeanggotaan->attachment->update([
                        'path' => $attachmentPath,
                        'name' => $attachment->getClientOriginalName(),
                        'size' => $attachment->getSize(),
                        'extension' => $attachment->extension(),
                    ]);
                } else {
                    $attachmentData = [
                        'parent_table' => 'trans_pembayaran_keanggotaan',
                        'table_id' => $pembayaranKeanggotaan->id,
                        'path' => $attachmentPath,
                        'name' => $attachment->getClientOriginalName(),
                        'size' => $attachment->getSize(),
                        'extension' => $attachment->extension(),
                    ];
                    Attachment::create($attachmentData);
                }
            } elseif ($pembayaranKeanggotaan->attachment) {

                $attachmentPath = $pembayaranKeanggotaan->attachment->path;
            }


            $pembayaranKeanggotaan->update([
                'nominal_bayar' => $request->input('nominal_bayar'),
                'catatan' => $request->input('catatan'),
                'tanggal_expired' => $tanggalExpired,
            ]);

            Session::flash('sukses', 'Berhasil Edit Pembayaran');

            return redirect()->route('member.tagihan');
        } catch (Exception $e) {
            return redirect()->route('tagihan.edit', $id)->withErrors(['error' => $e->getMessage()]);
        }
    }
    public function destroy($id)
    {
        try {

            $payment = PembayaranKeanggotaan::findOrFail($id);


            if ($payment->attachment) {

                Storage::disk('public')->delete($payment->attachment->path);

                $payment->attachment->delete();
            }


            $payment->delete();

            return response()->json([
                'status' => true,
                'message' => 'Berhasil Menghapus Pembayaran Keanggotaan beserta attachment yang terkait',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal Menghapus Pembayaran Keanggotaan: ' . $e->getMessage(),
            ]);
        }
    }
}
