<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        $this->authorizeAdminOrEditor();

        $scoped = Article::when(! auth()->user()->isAdmin(), fn ($q) => $q->where('author_id', auth()->id()));

        $articles = $scoped->clone()->with('author')->latest('published_at')->paginate(15);

        $counts = [
            'total' => $scoped->clone()->count(),
            'live' => $scoped->clone()->where('status', 'published')->count(),
            'draft' => $scoped->clone()->where('status', 'draft')->count(),
            'arsip' => $scoped->clone()->where('status', 'archived')->count(),
        ];

        return view('admin.articles', [
            'articles' => $articles,
            'counts' => $counts,
            'pageTitle' => 'Artikel',
        ]);
    }

    public function create(): View
    {
        $this->authorizeAdminOrEditor();

        return view('admin.articles-form', ['mode' => 'create']);
    }

    public function store(StoreArticleRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['author_id'] = auth()->id();
        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('article-images', 'public');
        }

        if (($data['status'] ?? null) === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        Article::create($data);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel dibuat.');
    }

    public function edit(Article $article): View
    {
        $this->authorizeAdminOrEditor();
        $this->authorizeOwnership($article);

        return view('admin.articles-form', [
            'article' => $article,
            'mode' => 'edit',
        ]);
    }

    public function update(UpdateArticleRequest $request, Article $article): RedirectResponse
    {
        $this->authorizeAdminOrEditor();
        $this->authorizeOwnership($article);

        $data = $request->validated();
        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);

        if ($request->hasFile('featured_image')) {
            if ($article->featured_image) {
                Storage::disk('public')->delete($article->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('article-images', 'public');
        }

        if (($data['status'] ?? null) === 'published' && empty($data['published_at'])) {
            $data['published_at'] = $article->published_at ?? now();
        }

        $article->update($data);

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel diperbarui.');
    }

    public function destroy(Article $article): RedirectResponse
    {
        $this->authorizeAdminOrEditor();
        $this->authorizeOwnership($article);

        if ($article->featured_image) {
            Storage::disk('public')->delete($article->featured_image);
        }

        $article->delete();

        return redirect()->route('admin.articles.index')
            ->with('success', 'Artikel dihapus.');
    }

    protected function authorizeAdminOrEditor(): void
    {
        if (! auth()->check() || ! in_array(auth()->user()->role, ['admin', 'editor'], true)) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin untuk mengelola artikel.');
        }
    }

    protected function authorizeOwnership(Article $article): void
    {
        if (auth()->user()->isAdmin()) {
            return;
        }

        if (auth()->user()->id !== $article->author_id) {
            abort(403, 'Anda tidak dapat mengubah artikel ini.');
        }
    }
}
