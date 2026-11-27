<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CardController extends Controller
{
    public function create(Collection $collection)
    {
        return view('cards.create', compact('collection'));
    }

    public function store(Request $request, Collection $collection)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255|unique:cards,question',
            'answer' => 'required|string|max:255',
        ]);

        $collection->cards()->create($validated);

        return redirect()
            ->route('collections.show', $collection)
            ->with('success', 'Card added successfully!');
    }

    public function edit(Collection $collection, Card $card)
    {
        return view('cards.edit', compact('collection', 'card'));
    }

    public function update(Request $request, Collection $collection, Card $card)
    {
        $validated = $request->validate([
            'question' => [
                'required',
                'string',
                'max:255',
                Rule::unique('cards', 'question')->ignore($card->id),
            ],
            'answer' => 'required|string|max:255',
        ]);

        $card->update($validated);

        return redirect()
            ->route('collections.show', $collection)
            ->with('success', 'Card updated successfully!');
    }

    public function destroy(Collection $collection, Card $card)
    {
        $card->delete();

        return redirect()
            ->route('collections.show', $collection)
            ->with('success', 'Card deleted.');
    }
}
