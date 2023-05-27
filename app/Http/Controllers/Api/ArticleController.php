<?php
namespace App\Http\Controllers\Api;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\ArticleCollection;

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

    public function create(Request $request)
    {
        // Con asiganación masiva
        // $article = Article::create($request->input('data.attributes'));

        //Sin asiganción masiva
        $article = Article::create([
            'title' => $request->input('data.attributes.title'),
            'slug' => $request->input('data.attributes.slug'),
            'content' => $request->input('data.attributes.content'),
        ]);
        
        return ArticleResource::make($article);
    }
}