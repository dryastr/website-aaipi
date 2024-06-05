<?php

namespace App\Http\Controllers\Admin\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StrukturOrganisasi\ActionsRequest;
use App\Models\ParamsWebsite;
use Exception;
use Illuminate\Support\Facades\DB;

class StrukturOrganisasiController extends Controller
{
    protected $model;

    protected $module = 'TENTANG_KAMI';

    public function __construct()
    {
        $this->model = new ParamsWebsite();
    }

    public function index()
    {
        $item = $this->model->getSingleData($this->module, 'STRUKTUR_ORGANISASI');
        $dataForm = [
            'title' => $item ? $item['title'] : null,
            'content' => $item ? $item['content'] : null,
            'image_url' => $item ? $item['image_url'] : null,
        ];
        $data = [
            'title' => 'Struktur Organisasi',
            'item' => $dataForm,
        ];

        return view('admin.pages.CMS.struktur-organisasi.form', $data);
    }

    public function actions(ActionsRequest $request)
    {
        try {
            $data = $request->validated();

            if ($request->file('image')) {
                $file = $request['image']->getContent();
                $file_extension = $request['image']->extension();
                $date = now()->toDateString();

                $file = file_helper()->upload(
                    fileContent: $file,
                    ext: $file_extension,
                    path: 'img/content/'.$date
                );

                $data['image'] = $file['filename'];
            } else {
                $data['image'] = null;
            }

            $result = DB::transaction(function () use ($data) {
                $dataInput = [
                    'title' => $data['title'],
                    // 'content' => $data['content'],
                ];

                if ($data['image']) {
                    $dataInput['image'] = $data['image'];
                }

                $this->model->updateOrCreate([
                    'module' => $this->module,
                    'kode' => 'STRUKTUR_ORGANISASI',
                ], $dataInput);

                return $data;
            });

            if (! $result) {
                file_helper()->delete($data['image']);
            }

            return response()->json([
                'status' => true,
                'message' => 'Berhasil Menyimpan Data',
                'data' => $data,
            ]);

        } catch (Exception $e) {
            return response()->json($e, 500);
        }
    }
}
