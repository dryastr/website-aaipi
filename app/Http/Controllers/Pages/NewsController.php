<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Pages\Comment\CommentRequest;
use App\Models\Comment;
use App\Models\News;
use Exception;

class NewsController extends Controller
{
    protected $model;

    protected $modelComment;

    public function __construct()
    {
        $this->model = new News();
        $this->modelComment = new Comment();
    }

    public function show($slug)
    {
        $query = $this->model->where('slug', $slug)->where('status', 'publish')->first();
        if ($query) {
            $data = [
                'title' => 'Berita',
                'item' => $query,
                'recent_post' => $this->model->newsHomePage(),
                'list_archives' => $this->model->getListArchives(),
            ];

            return view('pages.news.show', $data);
        } else {
            abort(404);
        }
    }

    public function comment($id)
    {
        $query = $this->modelComment->select('*');
        $query->where('parent_id', null);
        $query->orderBy('created_at', 'ASC');
        $query->with(['children']);

        return response()->json([
            'status' => true,
            'message' => 'Berhasil Menampilkan Data',
            'data' => $query->get(),
        ]);
    }

    public function postComment(CommentRequest $request)
    {
        try {
            $data = $request->validated();
            $data['news_id'] = security()->decrypt($data['news_id']);
            $data = $this->modelComment->create($data);

            return response()->json([
                'status' => true,
                'messsage' => 'Berhasil Comment',
            ]);
        } catch (Exception $e) {
            return response()->json($e, 500);
        }
    }
}
