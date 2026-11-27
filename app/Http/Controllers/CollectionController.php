<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CollectionController extends Controller
{
    public function index()
    {
        $collections = Collection::withCount([
            'cards',
            'cards as learned_cards_count' => fn ($q) => $q->whereHas('reviews', fn ($r) => $r->where('result', true)),
        ])->latest()->paginate(8);

        return view('collections.index', compact('collections'));
    }

    public function create()
    {
        return view('collections.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:collections,name',
            'description' => 'nullable|string|max:255'
        ]);

        $collection = Collection::create($validated);

        return redirect()
            ->route('collections.index');
    }

    public function show(Collection $collection)
    {
        $totalCards = $collection->cards()->count();

        $learnedCount = $collection->cards()
            ->whereHas('reviews', fn ($q) => $q->where('result', true))
            ->count();

        $cards = $collection->cards()->latest()->paginate(15);

        return view('collections.show', compact(
            'collection',
            'cards',
            'totalCards',
            'learnedCount'
        ));
    }

    public function edit(Collection $collection)
    {
        return view('collections.edit', compact('collection'));
    }

    public function update(Request $request, Collection $collection)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('collections', 'name')->ignore($collection->id),
            ],
            'description' => 'nullable|string|max:255',
        ]);

        $collection->update($validated);

        return redirect()
            ->route('collections.show', $collection)
            ->with('success', 'Collection updated!');
    }

    public function destroy(Collection $collection)
    {
        $name = $collection->name;
        $collection->delete();

        return redirect()
            ->route('collections.index')
            ->with('success', "Collection «{$name}» deleted.");
    }
}
