<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewsRequest;
use App\Http\Requests\UpdateNewsRequest;
use App\Models\News;
use App\Models\Section;
use App\Models\Status;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(Request $request): View
    {
        $query = News::with(['section', 'user', 'status'])
            ->published()
            ->latest();

        if ($request->filled('section')) {
            $query->bySection($request->section);
        }

        $news = $query->paginate();
        $sections = Section::all();

        return view('news.index', compact('news', 'sections'));
    }

    public function show(Request $request, string $slug): View
    {
        $article = News::with(['section', 'user', 'status'])
            ->where('slug', $slug);

        // Usuarios no autenticados solo ven artículos publicados
        if (!auth()->check()) {
            $article->published();
        }

        $article = $article->firstOrFail();

        // Noticias relacionadas de la misma sección
        $related = News::with(['section', 'user'])
            ->published()
            ->bySection($article->section_id)
            ->where('id', '!=', $article->id)
            ->latest()
            ->take(4)
            ->get();

        return view('news.show', compact('article', 'related'));
    }

    /**
     * @param Request $request
     * @return View
     */
    public function myNews(Request $request): View
    {
        $news = News::with(['section', 'status'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(15);

        return view('news.my-news', compact('news'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $sections = Section::all();
        $statuses = Status::all();

        return view('news.create', compact('sections', 'statuses'));
    }

    /**
     * @param StoreNewsRequest $request
     * @return RedirectResponse
     */
    public function store(StoreNewsRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $data['slug'] = Str::slug($data['title']);
        $data['user_id'] = auth()->id();

        // Almacenamos la imagen enviada
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('news/' . $data['slug'] .'/', 'public');
        }

        // Si el status es "published", registrar fecha
        $status = Status::find($data['status_id']);
        if ($status && $status->slug === 'publicado') {
            $data['published_at'] = now();
        }

        $article = News::create($data);

        return redirect()
            ->route('news.show', $article->slug)
            ->with('success', 'Noticia creada exitosamente.');
    }

    /**
     * @param News $news
     * @return View
     */
    public function edit(News $news): View
    {
        // validamos que la noticia le pertenezca al usuario autenticado
        $this->authorizeOwner($news);

        $sections = Section::all();
        $statuses = Status::all();

        return view('news.edit', compact('news', 'sections', 'statuses'));
    }

    /**
     * @param UpdateNewsRequest $request
     * @param News $news
     * @return RedirectResponse
     */
    public function update(UpdateNewsRequest $request, News $news): RedirectResponse
    {
        $data = $request->validated();

        // Manejo de imagen: reemplazar si viene una nueva
        if ($request->hasFile('image')) {
            // Eliminar imagen antigua
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }
            $data['image'] = $request->file('image')->store('news/' . $news->slug .'/', 'public');
        }

        if (isset($data['status_id'])) {
            $status = Status::find($data['status_id']);
            if ($status && $status->slug == 'publicado' && !$news->published_at) {
                $data['published_at'] = now();
            }
        }

        $news->update($data);

        return redirect()
            ->route('news.show', $news->slug)
            ->with('success', 'Noticia actualizada exitosamente.');
    }

    /**
     * Elimina una noticia.
     */
    public function destroy(News $news): RedirectResponse
    {
        $this->authorizeOwner($news);

        // Eliminar imagen del storage
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }

        $news->delete();

        return redirect()
            ->route('dashboard.my-news')
            ->with('success', 'Noticia eliminada correctamente.');
    }

    private function authorizeOwner(News $news): void
    {
        abort_if(auth()->id() !== $news->user_id, 403, 'No tienes permiso para realizar esta acción.');
    }
}
