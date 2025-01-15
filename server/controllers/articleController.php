<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller
{
    public function getAllArticles()
    {
        $articles = Article::with(['author', 'category'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'results' => $articles->count(),
            'data' => ['articles' => $articles]
        ], Response::HTTP_OK);
    }

    public function getArticle($id)
    {
        $article = Article::find($id);

        if (!$article) {
            return response()->json([
                'status' => 'error',
                'message' => 'No article found with that ID'
            ], Response::HTTP_NOT_FOUND);
        }

        // Increment views count
        $article->views_count += 1;
        $article->save();

        return response()->json([
            'status' => 'success',
            'data' => ['article' => $article]
        ], Response::HTTP_OK);
    }

    public function createArticle(Request $request)
    {
        $article = Article::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'author_id' => Auth::id(),
            'category_id' => $request->input('category_id'),
        ]);

        return response()->json([
            'status' => 'success',
            'data' => ['article' => $article]
        ], Response::HTTP_CREATED);
    }

    public function updateArticle(Request $request, $id)
    {
        $article = Article::find($id);

        if (!$article) {
            return response()->json([
                'status' => 'error',
                'message' => 'No article found with that ID'
            ], Response::HTTP_NOT_FOUND);
        }

        if ($article->author_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return response()->json([
                'status' => 'error',
                'message' => 'You do not have permission to perform this action'
            ], Response::HTTP_FORBIDDEN);
        }

        $article->update($request->all());

        return response()->json([
            'status' => 'success',
            'data' => ['article' => $article]
        ], Response::HTTP_OK);
    }

    public function deleteArticle($id)
    {
        $article = Article::find($id);

        if (!$article) {
            return response()->json([
                'status' => 'error',
                'message' => 'No article found with that ID'
            ], Response::HTTP_NOT_FOUND);
        }

        if ($article->author_id !== Auth::id() && Auth::user()->role !== 'admin') {
            return response()->json([
                'status' => 'error',
                'message' => 'You do not have permission to perform this action'
            ], Response::HTTP_FORBIDDEN);
        }

        $article->delete();

        return response()->json([
            'status' => 'success',
            'data' => null
        ], Response::HTTP_NO_CONTENT);
    }
}
