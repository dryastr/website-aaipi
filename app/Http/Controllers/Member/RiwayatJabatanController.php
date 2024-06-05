<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\RiwayatJabatan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RiwayatJabatanController extends Controller
{
    protected $model;

    protected $dirView = 'member.pages.riwayat-jabatan.';

    public function __construct()
    {
        $this->model = new RiwayatJabatan();
    }

    public function index()
    {
        $idUser = auth()->user()->id;
        $query = $this->model->select('*')->where('user_id', $idUser)->orderBy('created_at', 'desc');
        $data = [
            'title' => 'Riwayat Jabatan',
            'user' => auth()->user()->getMe(),
            'data' => $query->get(),
        ];

        return view($this->dirView.'index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Riwayat Jabatan',
            'user' => auth()->user()->getMe(),
        ];

        return view($this->dirView.'add', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nip_nrp' => 'required',
            'status_nip_nrp' => 'required|in:nip,nrp',
            'kode_jenjang_jabatan' => 'nullable',
            'kode_jabatan' => 'nullable',
            'nama_jenjang_jabatan' => 'nullable',
            'level_jenjang_jabatan' => 'nullable|integer',
            'nomor_sk' => 'nullable',
            'tanggal_sk' => 'nullable|date',
            'tmt_jabatan' => 'nullable|date',
            'dokumen' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        try {
            $attachmentPath = null;

            // Cek apakah ada file attachment di request
            if ($request->hasFile('dokumen')) {
                $attachment = $request->file('dokumen');
                $attachmentName = Str::random(20).'.'.$attachment->getClientOriginalExtension();
                $attachmentPath = $attachment->storeAs('dokumen', $attachmentName, 'public');
            }

            $this->model->create([
                'user_id' => auth()->user()->id,
                'nip_nrp' => $request->input('nip_nrp'),
                'status_nip_nrp' => $request->input('status_nip_nrp'),
                'kode_jenjang_jabatan' => $request->input('kode_jenjang_jabatan'),
                'kode_jabatan' => $request->input('kode_jabatan'),
                'nama_jenjang_jabatan' => $request->input('nama_jenjang_jabatan'),
                'level_jenjang_jabatan' => $request->input('level_jenjang_jabatan'),
                'nomor_sk' => $request->input('nomor_sk'),
                'tanggal_sk' => $request->input('tanggal_sk'),
                'tmt_jabatan' => $request->input('tmt_jabatan'),
                'dokumen' => $attachmentPath,
            ]);

            return redirect()->route('member.riwayat-jabatan.index');

        } catch (Exception $e) {
            return redirect()->route('member.riwayat-jabatan.create')->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $userId = auth()->user()->id;
        $item = $this->model->where('id', $id)->where('user_id', $userId)->firstOrFail();
        $data = [
            'title' => 'Riwayat Jabatan',
            'user' => auth()->user()->getMe(),
            'item' => $item,
        ];

        return view($this->dirView.'edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nip_nrp' => 'required',
            'status_nip_nrp' => 'required|in:nip,nrp',
            'kode_jenjang_jabatan' => 'nullable',
            'kode_jabatan' => 'nullable',
            'nama_jenjang_jabatan' => 'nullable',
            'level_jenjang_jabatan' => 'nullable|integer',
            'nomor_sk' => 'nullable',
            'tanggal_sk' => 'nullable|date',
            'tmt_jabatan' => 'nullable|date',
            'dokumen' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        try {
            $userId = auth()->user()->id;
            $item = $this->model->where('id', $id)->where('user_id', $userId)->firstOrFail();
            $attachmentPath = $item->documen;

            // Cek apakah ada file attachment di request
            if ($request->hasFile('dokumen')) {
                $attachment = $request->file('dokumen');
                $attachmentName = Str::random(20).'.'.$attachment->getClientOriginalExtension();
                $attachmentPath = $attachment->storeAs('dokumen', $attachmentName, 'public');
            }

            $item->update([
                'user_id' => $userId,
                'nip_nrp' => $request->input('nip_nrp'),
                'status_nip_nrp' => $request->input('status_nip_nrp'),
                'kode_jenjang_jabatan' => $request->input('kode_jenjang_jabatan'),
                'kode_jabatan' => $request->input('kode_jabatan'),
                'nama_jenjang_jabatan' => $request->input('nama_jenjang_jabatan'),
                'level_jenjang_jabatan' => $request->input('level_jenjang_jabatan'),
                'nomor_sk' => $request->input('nomor_sk'),
                'tanggal_sk' => $request->input('tanggal_sk'),
                'tmt_jabatan' => $request->input('tmt_jabatan'),
                'dokumen' => $attachmentPath,
            ]);

            return redirect()->route('member.riwayat-jabatan.index');

        } catch (Exception $e) {
            return redirect()->route('member.riwayat-jabatan.create')->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $this->model->findOrFail($id)->delete();

            return redirect()->route('member.riwayat-jabatan.index');
        } catch (Exception $e) {
            return redirect()->route('member.riwayat-jabatan.index')->withErrors(['error' => $e->getMessage()]);
        }
    }
}
