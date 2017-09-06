<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ArticleRepository;

class HomeController extends Controller
{
    protected $articles;

    public function __construct(ArticleRepository $articles)
    {
        $this->articles = $articles;
    }

    public function search(Request $request)
    {
        $key = trim($request->input('q'));

        $articles = $this->articles->search($key);

        return view('search', compact('articles'));
    }
}
