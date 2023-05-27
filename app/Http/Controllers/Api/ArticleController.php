<?php
namespace App\Http\Controllers\Api;

use App\Models\Article;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;

class ArticleController extends Controller
{
    public function index()
    {
        return ArticleCollection::make(Article::all());
    }

    public function show(Article $article)
    {
        return ArticleResource::make($article);
    }
}