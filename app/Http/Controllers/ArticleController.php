<?php

namespace App\Http\Controllers;

use App\Article;
use App\User;
use Illuminate\Http\Request;
use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\UserResource;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::with('user')->paginate(3);
        return ArticleResource::collection($articles)->additional(['meta'=>[
            'version' => '1.0.0',
            'API_base_url' => url('/'),
        ]]);
        // $articles = (new ArticleCollection(Article::paginate(3)))->additional(['meta'=>[
        //     'version' => '1.0.0',
        //     'API_base_url' => url('/'),
        // ]]);
        // return $articles;
    }

    /**
     * Search
     */
    public function search(Request $request) {
        $articles = Article::with('user')->paginate(3);
        if($request->searchTitle !== null){
            $articles = Article::where('title', 'like', '%' . $request->searchTitle . '%')->with('user')->paginate(3);
        }
        return ArticleResource::collection($articles)->additional(['meta'=>[
            'version' => '1.0.0',
            'API_base_url' => url('/'),
        ]]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = UserResource::collection(User::all())->additional(['meta'=>[
            'version' => '1.0.0',
            'API_base_url' => url('/'),
        ]]);
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'content' => 'required',
        ]);
        Article::create($request->all());
        return response()->json(null, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        $data[0] = $article->load('user');
        $data[1] = UserResource::collection(User::all())->additional(['meta'=>[
            'version' => '1.0.0',
            'API_base_url' => url('/'),
        ]]);
        return $article;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        $data[0] = $article->load('user');
        $data[1] = UserResource::collection(User::all())->additional(['meta'=>[
            'version' => '1.0.0',
            'API_base_url' => url('/'),
        ]]);
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {
        $article->update($request->all());
        return $article;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return '';
    }
}
