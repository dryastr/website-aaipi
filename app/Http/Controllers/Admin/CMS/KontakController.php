<?php

namespace App\Http\Controllers\Admin\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Kontak\ActionsRequest;
use App\Models\ParamsWebsite;
use Exception;
use Illuminate\Support\Facades\DB;

class KontakController extends Controller
{
    protected $dirView = 'admin.pages.CMS.kontak.index';

    protected $model;

    protected $module = 'KONTAK';

    public function __construct()
    {
        $this->model = new ParamsWebsite();
    }

    public function index()
    {
        $item = $this->model->getSingleData($this->module, 'KONTAK_DESCRIPTION');
        $itemAlamatKantor = $this->model->getSingleData($this->module, 'KONTAK_ALAMAT_KANTOR');
        $itemHubungiKami = $this->model->getSingleData($this->module, 'KONTAK_HUBUNGI_KAMI');
        $itemEmailKami = $this->model->getSingleData($this->module, 'KONTAK_EMAIL_KAMI');
        $itemJamKerja = $this->model->getSingleData($this->module, 'KONTAK_JAM_KERJA');

        $dataForm = [
            'title' => $item ? $item['title'] : null,
            'content' => $item ? $item['content'] : null,
            'image_url' => $item ? $item['image_url'] : null,
            'alamat_kantor' => $itemAlamatKantor ? $itemAlamatKantor['content'] : null,
            'hubungi_kami' => $itemHubungiKami ? $itemHubungiKami['content'] : null,
            'email_kami' => $itemEmailKami ? $itemEmailKami['content'] : null,
            'jam_kerja' => $itemJamKerja ? $itemJamKerja['content'] : null,
        ];

        $data = [
            'title' => 'Setting Kontak',
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
                $dataInput = [
                    'title' => $data['title'],
                    'content' => $data['content'],
                ];

                if ($data['image']) {
                    $dataInput['image'] = $data['image'];
                }

                $this->model->updateOrCreate([
                    'module' => $this->module,
                    'kode' => 'KONTAK_DESCRIPTION',
                ], $dataInput);

                $this->model->updateOrCreate([
                    'module' => $this->module,
                    'kode' => 'KONTAK_ALAMAT_KANTOR',
                ], [
                    'title' => 'Alamat Kantor',
                    'content' => $data['alamat_kantor'],
                ]);

                $this->model->updateOrCreate([
                    'module' => $this->module,
                    'kode' => 'KONTAK_HUBUNGI_KAMI',
                ], [
                    'title' => 'Hubungi Kami',
                    'content' => $data['hubungi_kami'],
                ]);

                $this->model->updateOrCreate([
                    'module' => $this->module,
                    'kode' => 'KONTAK_EMAIL_KAMI',
                ], [
                    'title' => 'Email Kami',
                    'content' => $data['email_kami'],
                ]);

                $this->model->updateOrCreate([
                    'module' => $this->module,
                    'kode' => 'KONTAK_JAM_KERJA',
                ], [
                    'title' => 'Jam Kerja',
                    'content' => $data['jam_kerja'],
                ]);

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
