<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Collection;
use Illuminate\Http\Request;

class LearnController extends Controller
{
    public function show(Collection $collection)
    {
        $totalCards = $collection->cards()->count();

        $unlearnedQuery = $collection->cards()
            ->whereDoesntHave('reviews', fn ($q) => $q->where('result', true));

        $remainingCount = $unlearnedQuery->count();
        $card = $unlearnedQuery->inRandomOrder()->first();

        return view('collections.learn', compact(
            'collection',
            'card',
            'totalCards',
            'remainingCount'
        ));
    }

    public function review(Request $request, Collection $collection, Card $card)
    {
        $validated = $request->validate([
            'result' => 'required|boolean',
        ]);

        $card->reviews()->create([
            'result' => $validated['result'],
            'reviewed_at' => now(),
        ]);

        return redirect()->route('collections.learn', $collection);
    }

    public function reset(Collection $collection)
    {
        $collection->cards()->each(function ($card) {
            $card->reviews()->delete();
        });

        return redirect()->route('collections.learn', $collection);
    }
}
