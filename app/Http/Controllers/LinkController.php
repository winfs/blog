<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\LinkRepository;

class LinkController extends Controller
{
    protected $link;

    public function __construct(LinkRepository $link)
    {
        $this->link = $link;
    }

    public function index()
    {
        $links = $this->link->paginate();

        return view('link.index', compact('links'));
    }
}
