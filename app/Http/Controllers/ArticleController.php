<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
class ArticleController extends Controller implements HasMiddleware
{
    public static function middleware() :array
    {
        return [
            new Middleware('permission:view articles', ['only' => ['index', 'show']]),
            new Middleware('permission:create articles', ['only' => ['create', 'store']]),
            new Middleware('permission:edit articles', ['only' => ['edit', 'update']]),
            new Middleware('permission:delete articles', ['only' => ['destroy']])

        ];
        // return ['auth'];
    }
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::orderBy('created_at', 'desc')->paginate(10);
        return view('articles.index', ['articles' => $articles]);
    }
    public function create()
    {
        return view('articles.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'text' => 'required|string',
            'author' => 'required|string|max:255',
        ]);
        $article = new Article();
        $article->title = $validated['title'];
        $article->text = $validated['text'];
        $article->author = $validated['author'];
        $article->save();
        // Here you would typically save the article to the database
        // Article::create($validated);
        return redirect()->route('articles.index')->with('success', 'Article created successfully!');   
    }
    public function show($id)
    {
        $article = Article::findOrFail($id);
        return view('articles.show', compact('article'));
    }
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        return view('articles.edit', compact('article'));
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'text' => 'required|string',
            'author' => 'required|string|max:255',
        ]);
        $article = Article::findOrFail($id);
        $article->title = $validated['title'];
        $article->text = $validated['text'];
        $article->author = $validated['author'];
        $article->save();
        return redirect()->route('articles.index')->with('success', 'Article updated successfully!');   
    }
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Article deleted successfully!');
    }

}
