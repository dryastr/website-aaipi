<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\RiwayatPekerjaan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RiwayatPekerjaanController extends Controller
{
    protected $model;

    protected $dirView = 'member.pages.riwayat-pekerjaan.';

    public function __construct()
    {
        $this->model = new RiwayatPekerjaan();
    }

    public function index()
    {
        $idUser = auth()->user()->id;
        $query = $this->model->select('*')->where('user_id', $idUser)->orderBy('created_at', 'desc');
        $data = [
            'title' => 'Riwayat Pekerjaan',
            'user' => auth()->user()->getMe(),
            'data' => $query->get(),
        ];

        return view($this->dirView.'index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Riwayat Pekerjaan',
            'user' => auth()->user()->getMe(),
        ];

        return view($this->dirView.'add', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_perusahaan' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'jabatan' => 'required',
            'deskripsi' => 'nullable',
        ]);

        try {
            $this->model->create([
                'user_id' => auth()->user()->id,
                'nama_perusahaan' => $request->input('nama_perusahaan'),
                'tanggal_mulai' => $request->input('tanggal_mulai'),
                'tanggal_selesai' => $request->input('tanggal_selesai'),
                'jabatan' => $request->input('jabatan'),
                'deskripsi' => $request->input('deskripsi'),
            ]);

            return redirect()->route('member.riwayat-pekerjaan.index');

        } catch (Exception $e) {
            return redirect()->route('member.riwayat-pekerjaan.create')->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $encrypt = decrypt($id);
        $userId = auth()->user()->id;
        $item = $this->model->where('id', $encrypt)->where('user_id', $userId)->firstOrFail();
        $data = [
            'title' => 'Riwayat Pekerjaan',
            'user' => auth()->user()->getMe(),
            'item' => $item,
        ];

        return view($this->dirView.'edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_perusahaan' => 'required',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'jabatan' => 'required',
            'deskripsi' => 'nullable',
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
                'nama_perusahaan' => $request->input('nama_perusahaan'),
                'tanggal_mulai' => $request->input('tanggal_mulai'),
                'tanggal_selesai' => $request->input('tanggal_selesai'),
                'jabatan' => $request->input('jabatan'),
                'deskripsi' => $request->input('deskripsi'),
            ]);

            return redirect()->route('member.riwayat-pekerjaan.index');

        } catch (Exception $e) {
            return redirect()->route('member.riwayat-pekerjaan.create')->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $this->model->findOrFail($id)->delete();

            return redirect()->route('member.riwayat-pekerjaan.index');
        } catch (Exception $e) {
            return redirect()->route('member.riwayat-pekerjaan.index')->withErrors(['error' => $e->getMessage()]);
        }
    }
}
