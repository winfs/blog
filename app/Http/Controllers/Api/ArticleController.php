<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\Http\Requests\ArticleRequest;
use App\Repositories\ArticleRepository;
use App\Transformers\ArticleTransformer;

class ArticleController extends ApiController
{
    protected $article;

    public function __construct(ArticleRepository $article)
    {
        $this->article = $article;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = $this->article->paginate();

        return $this->response->paginator($articles, new ArticleTransformer());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        $data = array_merge($request->all(), [
            'user_id'      => Auth::id(),
            'last_user_id' => Auth::id(),
            'slug'         => str_slug($request->input('title')),
        ]);

        $data['is_draft'] = isset($data['is_draft']);
        $data['is_original'] = isset($data['is_original']);

        $this->article->store($data);
        $this->article->syncTag(json_decode($request->input('tags')));

        return $this->response->withNoContent();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = $this->article->find($id);

        return $this->response->item($article, new ArticleTransformer());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, $id)
    {
        $data = array_merge($request->all(), [
            'last_user_id' => Auth::id(),
            'slug'         => str_slug($request->input('title')),
        ]);

        $this->article->update($id, $data);
        $this->article->syncTag(json_decode($request->input('tags')));

        return $this->response->withNoContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->article->delete($id);

        return $this->response->withNoContent();
    }
}
