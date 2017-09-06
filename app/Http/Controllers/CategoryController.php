<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CategoryRepository;

class CategoryController extends Controller
{
    protected $category;

    public function __construct(CategoryRepository $category)
    {
        $this->category = $category;
    }

    public function index()
    {
        $categories = $this->category->all();

        return view('category.index', compact('categories'));
    }

    public function show($category)
    {
        $category = $this->category->getByName($category);

        $articles = $category->articles;

        return view('category.show', compact('category', 'articles'));
    }
}
