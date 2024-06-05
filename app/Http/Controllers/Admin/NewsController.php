<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\News\CreateRequest;
use App\Http\Requests\Dashboard\News\UpdateRequest;
use App\Models\News;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    protected $dirView = 'admin.pages.CMS.news.';

    protected $model;

    public function __construct()
    {
        $this->middleware('can:cms.news.view')->only(['index', 'getView']);
        $this->middleware('can:cms.news.create')->only(['create', 'store']);
        $this->middleware('can:cms.news.edit')->only(['edit', 'update']);
        $this->middleware('can:cms.news.delete')->only(['delete']);
        $this->model = new News();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title' => 'Berita',
        ];

        return view($this->dirView.'index', $data);
    }

    public function getView(Request $request)
    {
        $columns = $request->input('columns');
        $query = $this->model->select('*')->latest();
        if ($request->filled('search.value')) {
            $query->where(function ($query) use ($columns, $request) {
                foreach ($columns as $column) {
                    if ($column['searchable'] == 'true') {
                        $query->orWhere($column['data'], 'like', '%'.$request->input('search.value').'%');
                    }
                }
            });
        }

        // Order by specific columns
        if ($request->input('order')) {
            foreach ($request->input('order') as $order) {
                $query->orderBy($request->input('columns')[$order['column']]['data'], $order['dir']);
            }
        }

        // Paginate the results
        $data = $query->paginate($request->input('length'));

        return response()->json([
            'status' => true,
            'message' => 'Berhasil Menampilkan data',
            'data' => $data->items(),
            'recordsTotal' => $data->total(),
            'recordsFiltered' => $data->total(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'title' => 'Tambah Berita',
        ];

        return view($this->dirView.'add', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
        try {

            $data = $request->validated();
            $slug = Str::slug($data['title']);
            $news = $this->model->where('slug', 'like', $slug.'%')->get();

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
            $data['slug'] = count($news) > 0 ? $slug.'-'.count($news) + 1 : $slug;
            $data['status'] = $data['status'] ? 'publish' : 'draft';

            $result = DB::transaction(function () use ($data) {
                $this->model->create($data);

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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $id = security()->decrypt($id);
        $data = [
            'title' => 'Ubah Berita',
            'item' => $this->model->find($id),
        ];

        return view($this->dirView.'edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, $id)
    {
        try {
            $id = security()->decrypt($id);
            $news = $this->model->find($id);
            $data = $request->validated();
            // $slug = Str::slug($data['title']);
            // $news_slug = $this->model
            //         ->where('id', '!=', $id)
            //         ->where('slug', 'like', $slug . '%')
            //         ->get();

            $image = $news->image;
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

            // $data['slug'] = count($news_slug) > 0 ? $slug . '-' . count($news_slug) + 1 : $slug;
            $data['status'] = $data['status'] ? 'publish' : 'draft';

            $result = DB::transaction(function () use ($data, $news) {
                if ($data['image'] == null) {
                    unset($data['image']);
                }
                $news->update($data);

                return $data;
            });

            if (! $result) {
                if ($data['image']) {
                    file_helper()->delete($data['image']);
                }
            }

            if ($result) {
                if ($data['image']) {
                    if ($image) {
                        file_helper()->delete($image);
                    }
                }
            }

            return response()->json([
                'status' => true,
                'message' => 'Berhasil Mengubah Data',
                'data' => $data,
            ]);

        } catch (Exception $e) {
            return response()->json($e, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $id = security()->decrypt($id);
            $data = $this->model->find($id);

            if ($data['image']) {
                file_helper()->delete($data['image']);
            }

            $data->delete();

            return response()->json([
                'status' => true,
                'message' => 'Berhasil Menghapus data',
            ]);
        } catch (Exception $e) {
            return $this->response($e);
        }
    }

    public function create_slug(Request $request)
    {
        $title = $request->title;
        $slug = Str::slug($title);

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'slug' => $slug,
        ]);
    }
}
