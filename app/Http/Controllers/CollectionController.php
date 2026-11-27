<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

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

    public function importForm()
    {
        return view('collections.import');
    }

    public function importStore(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:json,txt|max:2048',
        ]);

        $raw = file_get_contents($request->file('file')->getRealPath());
        $data = json_decode($raw, true);

        if (!is_array($data) || empty($data['name']) || !isset($data['cards']) || !is_array($data['cards'])) {
            return back()->withErrors([
                'file' => 'Invalid JSON structure. Expected "name" and "cards" array.',
            ]);
        }

        $name = Str::limit(trim($data['name']), 90, '');
        if (Collection::where('name', $name)->exists()) {
            $name .= ' (' . now()->format('H:i:s') . ')';
        }

        $collection = DB::transaction(function () use ($data, $name) {
            $collection = Collection::create([
                'name' => $name,
                'description' => isset($data['description']) ? Str::limit($data['description'], 255, '') : null,
            ]);

            foreach ($data['cards'] as $item) {
                if (!empty($item['question']) && !empty($item['answer'])) {
                    $question = Str::limit(trim($item['question']), 255, '');

                    if (!$collection->cards()->where('question', $question)->exists()) {
                        $collection->cards()->create([
                            'question' => $question,
                            'answer' => Str::limit(trim($item['answer']), 255, ''),
                        ]);
                    }
                }
            }

            return $collection;
        });

        return redirect()
            ->route('collections.show', $collection)
            ->with('success', "Collection «{$collection->name}» imported ({$collection->cards()->count()} cards)!");
    }

    public function export(Collection $collection)
    {
        $collection->load('cards');

        $data = [
            'name' => $collection->name,
            'description' => $collection->description,
            'cards' => $collection->cards->map(fn ($card) => [
                'question' => $card->question,
                'answer' => $card->answer,
            ])->values()->all(),
        ];

        $filename = Str::slug($collection->name ?: 'collection') . '.json';

        return response()->streamDownload(function () use ($data) {
            echo json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        }, $filename, [
            'Content-Type' => 'application/json',
        ]);
    }
}
