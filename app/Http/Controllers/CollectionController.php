<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CollectionController extends Controller
{
    public function index()
    {
        $collections = Collection::withCount('cards')->latest()->get();

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
        $collection->load('cards');

        return view('collections.show', compact('collection'));
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
