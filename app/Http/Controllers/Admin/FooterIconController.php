<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\IconFooter\CreateRequest;
use App\Http\Requests\Dashboard\IconFooter\UpdateRequest;
use App\Http\Requests\Dashboard\MediaSocial\ActionsRequest;
use App\Models\FooterIcon;
use App\Models\ParamsWebsite;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FooterIconController extends Controller
{
    protected $dirView = 'admin.pages.CMS.media-social.index';

    protected $model;

    protected $module = 'MEDIA_SOCIAL';

    public function __construct()
    {
        $this->model = new ParamsWebsite();

    }

    // public function index() {

    //     $icons = FooterIcon::all();

    //     $data = [
    //         'title' => 'Icon footer',
    //         'icons' => $icons
    //     ];

    //     return view($this->dirView . 'index', $data);
    // }

    // public function getView(Request $request)
    // {
    //     $columns = $request->input('columns');
    //     $query = $this->model->select('*');
    //     if($request->filled('search.value')){
    //         $query->where(function($query) use ($columns, $request){
    //             foreach($columns as $column){
    //                 if($column['searchable'] == 'true'){
    //                     $query->orWhere($column['data'], 'like', '%' . $request->input('search.value') . '%');
    //                 }
    //             }
    //         });
    //     }

    //     // Order by specific columns
    //     if($request->input('order')){
    //         foreach ($request->input('order') as $order) {
    //             $query->orderBy($request->input('columns')[$order['column']]['data'], $order['dir']);
    //         }
    //     }

    //     // Paginate the results
    //     $data = $query->paginate($request->input('length'));

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Berhasil Menampilkan data',
    //         'data' => $data->items(),
    //         'recordsTotal' => $data->total(),
    //         'recordsFiltered' => $data->total(),
    //     ]);
    // }

    // public function create()
    // {
    //     $data = [
    //         'title' => 'Tambah icon footer'
    //     ];

    //     return view($this->dirView . 'add', $data);
    // }

    // public function store(CreateRequest $request)
    // {

    //     try {
    //         $validatedData = $request->validated();

    //         $data = FooterIcon::create($validatedData);

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Berhasil Menyimpan data',
    //             'data' => $data,
    //         ]);
    //     } catch (\Throwable $th) {
    //         return $this->response($th);
    //     }
    // }

    // public function edit(string $id)
    // {
    //     $data = FooterIcon::findOrFail($id);
    //     $data = [
    //         'title' => "Edit Icon",
    //         'item' => $data,
    //     ];

    //     return view($this->dirView . 'edit', $data);
    // }

    // public function update(UpdateRequest $request, string $id)
    // {
    //     try {
    //         $data = FooterIcon::find($id)->update($request->validated());
    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Berhasil Mengubah data',
    //             'data' => $data,
    //         ]);
    //     } catch (Exception $e) {
    //         return $this->response($e);
    //     }
    // }

    // public function destroy(string $id)
    // {
    //     try {
    //         FooterIcon::find($id)->delete();
    //         return response()->json([
    //             'status' => true,
    //             'message' => 'Berhasil Menghapus data',
    //         ]);
    //     } catch (Exception $e) {
    //         return $this->response($e);
    //     }
    // }

    public function iconFooterHome()
    {
        $icons = FooterIcon::all();

        $data = [
            'icons' => $icons,
        ];

        return view('layouts.master', $data);
    }

    public function indexNew()
    {
        $item = $this->model->getSingleData($this->module, 'KONTAK_DESCRIPTION');
        $facebook = $this->model->getSingleData($this->module, 'SOCIAL_FACEBOOK');
        $twitter = $this->model->getSingleData($this->module, 'SOCIAL_TWITTER');
        $linkedin = $this->model->getSingleData($this->module, 'SOCIAL_LINKEDIN');
        $youtube = $this->model->getSingleData($this->module, 'SOCIAL_YOUTUBE');
        $instagram = $this->model->getSingleData($this->module, 'SOCIAL_INSTAGRAM');

        $dataForm = [
            'title' => $item ? $item['title'] : null,
            'content' => $item ? $item['content'] : null,
            'image_url' => $item ? $item['image_url'] : null,
            'facebook' => $facebook ? $facebook['content'] : null,
            'twitter' => $twitter ? $twitter['content'] : null,
            'linkedin' => $linkedin ? $linkedin['content'] : null,
            'youtube' => $youtube ? $youtube['content'] : null,
            'instagram' => $instagram ? $instagram['content'] : null,
        ];

        $data = [
            'title_form' => 'Masukan Url',
            'title' => 'Setting Kontak',
            'item' => $dataForm,

        ];

        return view($this->dirView, $data);
    }

    public function actions(ActionsRequest $request)
    {
        try {
            $data = $request->validated();
            // if ($request->file('image')) {
            //     $file = $request['image']->getContent();
            //     $file_extension = $request['image']->extension();
            //     $date = now()->toDateString();

            //     $file = file_helper()->upload(
            //         fileContent: $file,
            //         ext: $file_extension,
            //         path: 'img/content/' . $date
            //     );

            //     $data['image'] = $file['filename'];
            // }else{
            //     $data['image'] = null;
            // }

            $result = DB::transaction(function () use ($data) {
                // $dataInput = [
                //     'title' => $data['title'],
                //     'content' => $data['content'],
                // ];

                // if($data['image']){
                //     $dataInput['image'] = $data['image'];
                // }

                // $this->model->updateOrCreate([
                //     'module' => $this->module,
                //     'kode' => 'KONTAK_DESCRIPTION'
                // ],$dataInput);

                $this->model->updateOrCreate([
                    'module' => $this->module,
                    'kode' => 'SOCIAL_FACEBOOK',
                ], [
                    'title' => 'Facebook',
                    'icon' => 'fab fa-facebook',
                    'content' => $data['facebook'],
                ]);

                $this->model->updateOrCreate([
                    'module' => $this->module,
                    'kode' => 'SOCIAL_TWITTER',
                ], [
                    'title' => 'Twitter',
                    'icon' => 'fab fa-twitter',
                    'content' => $data['twitter'],
                ]);

                $this->model->updateOrCreate([
                    'module' => $this->module,
                    'kode' => 'SOCIAL_LINKEDIN',
                ], [
                    'title' => 'Linkedin',
                    'icon' => 'fab fa-linkedin',
                    'content' => $data['linkedin'],
                ]);

                $this->model->updateOrCreate([
                    'module' => $this->module,
                    'kode' => 'SOCIAL_YOUTUBE',
                ], [
                    'title' => 'Youtube',
                    'icon' => 'fab fa-youtube',
                    'content' => $data['youtube'],
                ]);

                $this->model->updateOrCreate([
                    'module' => $this->module,
                    'kode' => 'SOCIAL_INSTAGRAM',
                ], [
                    'title' => 'Instagram',
                    'icon' => 'fab fa-instagram',
                    'content' => $data['instagram'],
                ]);

                return $data;
            });

            // if (!$result) {
            //     file_helper()->delete($data['image']);
            // }

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
