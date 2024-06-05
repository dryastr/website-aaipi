<?php

namespace App\Http\Controllers\Admin\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ProgramKerja\ActionsRequest;
use App\Models\ParamsWebsite;
use Exception;
use Illuminate\Support\Facades\DB;

class ProgramKerjaNewController extends Controller
{
    protected $dirView = 'admin.pages.CMS.program-kerja.index';

    protected $model;

    protected $module = 'PROGRAM_KERJA';

    public function __construct()
    {
        $this->model = new ParamsWebsite();
    }

    public function indexNew()
    {
        $item = $this->model->getSingleData($this->module, 'DATA_PROGRAM');

        $dataForm = [
            'title' => $item ? $item['title'] : null,
            'content' => $item ? $item['content'] : null,
            'image_url' => $item ? $item['image_url'] : null,
        ];

        $data = [
            'title' => 'Setting Program Kerja',
            'item' => $dataForm,

        ];

        return view($this->dirView, $data);
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
                $existingParamsWebsite = ParamsWebsite::where('module', $this->module)
                    ->where('kode', 'DATA_PROGRAM')
                    ->first();

                if ($existingParamsWebsite) {
                    $existingParamsWebsite->update([
                        'title' => $data['title'],
                        'content' => $data['content'],
                        'image' => $data['image'],
                    ]);

                    return $existingParamsWebsite;
                } else {
                    return ParamsWebsite::create([
                        'module' => $this->module,
                        'kode' => 'DATA_PROGRAM',
                        'title' => $data['title'],
                        'content' => $data['content'],
                        'image' => $data['image'],
                    ]);
                }
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
