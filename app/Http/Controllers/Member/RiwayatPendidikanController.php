<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\RiwayatPendidikan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RiwayatPendidikanController extends Controller
{
    protected $model;

    protected $dirView = 'member.pages.riwayat-pendidikan.';

    public function __construct()
    {
        $this->model = new RiwayatPendidikan();
    }

    public function index()
    {
        $idUser = auth()->user()->id;
        $query = $this->model->select('*')->where('user_id', $idUser)->orderBy('created_at', 'desc');
        $data = [
            'title' => 'Riwayat Pendidikan',
            'user' => auth()->user()->getMe(),
            'data' => $query->get(),
        ];

        return view($this->dirView.'index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Riwayat Pendidikan',
            'user' => auth()->user()->getMe(),
        ];

        return view($this->dirView.'add', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'gelar_depan' => 'nullable',
            'gelar_belakang' => 'required',
            'nomor_ijazah' => 'required',
            'tanggal_ijazah' => 'required|date',
            'dokumen' => 'nullable|file|mimes:pdf|max:2048',
            'strata' => 'required|in:sd/mi,smp/mts,sma/smk/ma,di,dii,diii,si/div,sii,siii',
            'perguruan_tinggi' => 'required',
            'program_studi' => 'required',
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
                'gelar_depan' => $request->input('gelar_depan'),
                'gelar_belakang' => $request->input('gelar_belakang'),
                'nomor_ijazah' => $request->input('nomor_ijazah'),
                'tanggal_ijazah' => $request->input('tanggal_ijazah'),
                'dokumen' => $attachmentPath,
                'strata' => $request->input('strata'),
                'perguruan_tinggi' => $request->input('perguruan_tinggi'),
                'program_studi' => $request->input('program_studi'),
            ]);

            return redirect()->route('member.riwayat-pendidikan.index');

        } catch (Exception $e) {
            return redirect()->route('member.riwayat-pendidikan.create')->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $encrypt = decrypt($id);
        $userId = auth()->user()->id;
        $item = $this->model->where('id', $encrypt)->where('user_id', $userId)->firstOrFail();
        // dd($item);
        $data = [
            'title' => 'Riwayat Pendidikan',
            'user' => auth()->user()->getMe(),
            'item' => $item,
        ];

        return view($this->dirView.'edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'gelar_depan' => 'nullable',
            'gelar_belakang' => 'required',
            'nomor_ijazah' => 'required',
            'tanggal_ijazah' => 'required|date',
            'dokumen' => 'nullable|file|mimes:pdf|max:2048',
            'strata' => 'required|in:sd/mi,smp/mts,sma/smk/ma,di,dii,diii,si/div,sii,siii',
            'perguruan_tinggi' => 'required',
            'program_studi' => 'required',
        ]);

        try {
            $userId = auth()->user()->id;
            $item = $this->model->where('id', $id)->where('user_id', $userId)->firstOrFail();
            $attachmentPath = $item->documen;
            $attachmentPath = $item->dokumen;

            if ($request->hasFile('dokumen')) {
                $attachment = $request->file('dokumen');
                $attachmentName = Str::random(20).'.'.$attachment->getClientOriginalExtension();
                $attachmentPath = $attachment->storeAs('dokumen', $attachmentName, 'public');
            }

            $item->update([
                'user_id' => $userId,
                'program_studi' => $request->input('program_studi'),
                'strata' => $request->input('strata'),
                'gelar_depan' => $request->input('gelar_depan'),
                'gelar_belakang' => $request->input('gelar_belakang'),
                'nomor_ijazah' => $request->input('nomor_ijazah'),
                'perguruan_tinggi' => $request->input('perguruan_tinggi'),
                'nomor_ijazah' => $request->input('nomor_ijazah'),
                'tanggal_ijazah' => $request->input('tanggal_ijazah'),
                'tmt_Pendidikan' => $request->input('tmt_Pendidikan'),
                'dokumen' => $attachmentPath,
            ]);

            return redirect()->route('member.riwayat-pendidikan.index');

        } catch (Exception $e) {
            return redirect()->route('member.riwayat-pendidikan.create')->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $this->model->findOrFail($id)->delete();

            return redirect()->route('member.riwayat-pendidikan.index');
        } catch (Exception $e) {
            return redirect()->route('member.riwayat-pendidikan.index')->withErrors(['error' => $e->getMessage()]);
        }
    }
}
