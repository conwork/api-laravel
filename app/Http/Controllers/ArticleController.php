<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['message' => __('article.index.success'),ArticleResource::collection(Article::all())]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $request)
    {

        try {
            $article = Auth::user()->articles()->create($request->validated());
            return response()->json(new ArticleResource($article), 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $article = Article::findOrFail($id);
            if (auth()->user()->id !== $article->user_id) {
               return response()->json([
                   'message' => 'No tienes permisos para ver este articulo'
               ], 403);
           }
            return response()->json(new ArticleResource($article));
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $article = Article::findOrFail($id);
            if (auth()->user()->id !== $article->user_id) {
                return response()->json([
                    'message' => 'No tienes permisos para eliminar este articulo'
                ], 403);
            }
            $article->delete();
            return response()->json([
                'message' => 'Articulo eliminado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 404);
        }

    }
}
