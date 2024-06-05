<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\RefTiketJenis;
use App\Models\TransTiket;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class TransTiketController extends Controller
{
    protected $dirView;

    public function __construct()
    {
        $this->dirView = 'member.pages.tiket.';
    }

    public function index()
    {
        $user = auth()->user()->getMe();
        $tikets = TransTiket::where('user_id', $user['id'])->get();

        $data = [
            'title' => 'Daftar Tiket',
            'user' => $user,
            'name' => 'Henry Rooney',
            'role' => 'Creative Designer',
            'tikets' => $tikets,
        ];

        return view($this->dirView.'index', $data);
    }

    public function datatables(){
        $user = auth()->user()->getMe();
        $tikets = TransTiket::select("*")->where('user_id', $user['id'])->orderBy('id', 'desc')->get();
        $no = 1;
        return DataTables::of($tikets)
        ->addColumn('no', function($row) use ($no){
            static $no = 0;
            return $no++;
        })
        ->addColumn('judul', function($row){
            return $row->judul;
        })
        ->addColumn('prioritas', function($row){
            return $row->prioritas;
        })
         ->addColumn('attachment', function($row){
            return $row->attachment;
        })
        ->addColumn('aksi', function($row){
            $encryptedId = encrypt($row->id); 
            $x = route('tiket.edit', ['id' => $encryptedId]); 
            // $x = route('tiket.edit', $row->id);
            return '<div class="d-flex">
                        <a href="'. $x .'" class="btn btn-warning"><i class="fa fa-edit"></i> Edit</a>
                        <button class="btn btn-danger btn-delete" data-payment-id="'. $row->id .'">
                            <i class="fa fa-trash"></i> Hapus
                        </button>
                   </div>';
        })
        ->rawColumns(['aksi'])
        ->make(true);
    }

    public function getView(Request $request)
    {
        $columns = $request->input('columns');
        $query = TransTiket::select('trans_tiket.*', 'ref_tiket_jenis.nama as jenis_tiket')
            ->leftJoin('ref_tiket_jenis', 'trans_tiket.ref_tiket_jenis_id', '=', 'ref_tiket_jenis.id');

        if ($request->filled('search.value')) {
            $query->where(function ($query) use ($columns, $request) {
                foreach ($columns as $column) {
                    if ($column['searchable'] == 'true') {
                        $query->orWhere($column['data'], 'like', '%'.$request->input('search.value').'%');
                    }
                }
            });
        }

        if ($request->input('order')) {
            foreach ($request->input('order') as $order) {
                $query->orderBy($request->input('columns')[$order['column']]['data'], $order['dir']);
            }
        }

        $data = $query->paginate($request->input('length'));

        return response()->json([
            'status' => true,
            'message' => 'Berhasil Menampilkan data',
            'data' => $data->items(),
            'recordsTotal' => $data->total(),
            'recordsFiltered' => $data->total(),
        ]);
    }

    public function create()
    {
        $jenisTikets = RefTiketJenis::all();

        $data = [
            'title' => 'Tambah Tiket',
            'user' => auth()->user()->getMe(),
            'role' => 'Creative Designer',
            'jenisTikets' => $jenisTikets,
        ];

        return view($this->dirView.'create', $data);
    }

    public function store(Request $request)
    {
        $user = auth()->user()->getMe();

        $request->validate([
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
            'ref_tiket_jenis_id' => 'required|exists:ref_tiket_jenis,id',
            'prioritas' => 'nullable|integer',
            'attachment' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        try {
            $attachmentPath = null;
            if ($request->hasFile('attachment')) {
                $attachment = $request->file('attachment');
                $attachmentName = Str::random(20).'.'.$attachment->getClientOriginalExtension();
                $attachmentPath = $attachment->storeAs('attachments', $attachmentName, 'public');
            }

            $data = TransTiket::create([
                'judul' => $request->input('judul'),
                'deskripsi' => $request->input('deskripsi'),
                'ref_tiket_jenis_id' => $request->input('ref_tiket_jenis_id'),
                'prioritas' => $request->input('prioritas'),
                'attachment' => $attachmentPath,
                'user_id' => $user['id'],
            ]);

            // Setelah berhasil menyimpan, kirimkan pesan ke view
            return redirect()->route('member.tiket')->with('status', 'Tiket berhasil disimpan');

        } catch (Exception $e) {
            // Jika terjadi exception, tampilkan pesan error ke view
            return redirect()->route('tiket.create')->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        // Implement as needed
    }

    public function edit($id)
    {
        $encryptdata = decrypt($id);
        $tiket = TransTiket::findOrFail($encryptdata);
        $jenisTikets = RefTiketJenis::all();

        $data = [
            'title' => 'Ubah Tiket',
            'user' => auth()->user()->getMe(),
            'role' => 'Creative Designer',
            'tiket' => $tiket,
            'jenisTikets' => $jenisTikets,
        ];

        return view($this->dirView.'edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string',
            'deskripsi' => 'required|string',
            'ref_tiket_jenis_id' => 'required|exists:ref_tiket_jenis,id',
            'prioritas' => 'nullable|integer',
            'attachment' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        try {
            $tiket = TransTiket::findOrFail($id);

            // Proses attachment
            if ($request->hasFile('attachment')) {
                // Hapus attachment lama jika ada
                if ($tiket->attachment) {
                    Storage::disk('public')->delete($tiket->attachment);
                }

                // Upload attachment baru
                $attachment = $request->file('attachment');
                $attachmentName = Str::random(20).'.'.$attachment->getClientOriginalExtension();
                $attachmentPath = $attachment->storeAs('attachments', $attachmentName, 'public');
                $tiket->attachment = $attachmentPath;
            }

            // Update data tiket
            $tiket->update([
                'judul' => $request->input('judul'),
                'deskripsi' => $request->input('deskripsi'),
                'ref_tiket_jenis_id' => $request->input('ref_tiket_jenis_id'),
                'prioritas' => $request->input('prioritas'),
                'user_id' => auth()->user()->id,
            ]);

            return redirect()->route('member.tiket')->with('status', 'Tiket berhasil diperbarui');
        } catch (Exception $e) {
            return redirect()->route('tiket.edit', $id)->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            TransTiket::findOrFail($id)->delete();

            return response()->json([
                'status' => true,
                'message' => 'Berhasil Menghapus Tiket',
            ]);
        } catch (Exception $e) {
            return $this->response($e);
        }
    }

    private function response(Exception $e)
    {
        return response()->json([
            'status' => false,
            'message' => $e->getMessage(),
        ], 500);
    }
}
