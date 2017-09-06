<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TagRepository;

class TagController extends Controller
{
    protected $tag;

    public function __construct(TagRepository $tag)
    {
        $this->tag = $tag;
    }

    public function index()
    {
        $tags = $this->tag->all();

        return view('tag.index', compact('tags'));
    }

    public function show($tag)
    {
        $tag = $this->tag->getByName($tag);

        $articles = $tag->articles;

        return view('tag.show', compact('tag', 'articles'));
    }
}
