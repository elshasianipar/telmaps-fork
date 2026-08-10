<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        if (! auth()->check()) {
            abort(403);
        }

        $articles = Article::with('author')
            ->when(! auth()->user()->isAdmin(), fn ($q) => $q->where('author_id', auth()->id()))
            ->latest()
            ->paginate(15);

        return view('admin.articles', [
            'articles' => $articles,
            'pageTitle' => 'Artikel',
        ]);
    }

    public function create()
    {
        $this->authorizeAdminOrEditor();

        return view('admin.articles-form', ['mode' => 'create']);
    }

    public function edit(Article $article)
    {
        $this->authorizeAdminOrEditor();

        if (! auth()->user()->isAdmin() && auth()->user()->cannot('update', $article)) {
            abort(403, 'Anda tidak dapat mengedit artikel ini.');
        }

        return view('admin.articles-form', [
            'article' => $article,
            'mode' => 'edit',
        ]);
    }

    public function destroy(Article $article)
    {
        $this->authorizeAdminOrEditor();

        if (! auth()->user()->isAdmin() && auth()->user()->id !== $article->author_id) {
            abort(403, 'Anda tidak dapat menghapus artikel ini.');
        }

        if ($article->featured_image) {
            Storage::disk('public')->delete($article->featured_image);
        }

        $article->delete();

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel berhasil dihapus.');
    }

    protected function authorizeAdminOrEditor(): void
    {
        if (! auth()->check() || ! in_array(auth()->user()->role, ['admin', 'editor'])) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengelola artikel.');
        }
    }
}
