<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\RiwayatJabatan;
use App\Models\RiwayatPangkat;
use Exception;
use Illuminate\Http\Request;

class RiwayatPangkatController extends Controller
{
    protected $model;

    protected $modelJabatan;

    protected $dirView = 'member.pages.riwayat-pangkat.';

    public function __construct()
    {
        $this->model = new RiwayatPangkat();
        $this->modelJabatan = new RiwayatJabatan();
    }

    public function index()
    {
        $idUser = auth()->user()->id;
        $query = $this->model->select('*')->where('user_id', $idUser)->with(['jabatan'])->orderBy('created_at', 'desc');

        $data = [
            'title' => 'Riwayat Pangkat',
            'user' => auth()->user()->getMe(),
            'data' => $query->get(),
        ];

        return view($this->dirView.'index', $data);
    }

    public function create()
    {
        $idUser = auth()->user()->id;
        $itemJabatan = $this->modelJabatan->select('*')->where('user_id', $idUser)->orderBy('created_at', 'desc');
        $data = [
            'title' => 'Riwayat Pangkat',
            'user' => auth()->user()->getMe(),
            'dataJabatan' => $itemJabatan->get(),
        ];

        return view($this->dirView.'add', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'jabatan_id' => 'required',
            'nama_pangkat' => 'required',
        ]);

        try {

            $this->model->create([
                'user_id' => auth()->user()->id,
                'jabatan_id' => $request->input('jabatan_id'),
                'nama_pangkat' => $request->input('nama_pangkat'),
            ]);

            return redirect()->route('member.riwayat-pangkat.index');

        } catch (Exception $e) {
            return redirect()->route('member.riwayat-pangkat.create')->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $userId = auth()->user()->id;
        $item = $this->model->where('id', $id)->where('user_id', $userId)->firstOrFail();
        $itemJabatan = $this->modelJabatan->select('*')->where('user_id', $userId)->orderBy('created_at', 'desc');
        $data = [
            'title' => 'Riwayat Pangkat',
            'user' => auth()->user()->getMe(),
            'item' => $item,
            'dataJabatan' => $itemJabatan->get(),
        ];

        return view($this->dirView.'edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jabatan_id' => 'required',
            'nama_pangkat' => 'required',
        ]);

        try {
            $userId = auth()->user()->id;
            $item = $this->model->where('id', $id)->where('user_id', $userId)->firstOrFail();

            $item->update([
                'user_id' => $userId,
                'jabatan_id' => $request->input('jabatan_id'),
                'nama_pangkat' => $request->input('nama_pangkat'),
            ]);

            return redirect()->route('member.riwayat-pangkat.index');

        } catch (Exception $e) {
            return redirect()->route('member.riwayat-pangkat.create')->withErrors(['error' => $e->getMessage()]);
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
