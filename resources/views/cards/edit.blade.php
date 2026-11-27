@extends('layouts.app')
@section('title', 'Edit card')

@section('content')
<div class="mx-auto max-w-xl">
    <a href="{{ route('collections.show', $card->collection) }}" class="text-sm text-ink-soft hover:text-shu">
        ← {{ $card->collection->name }}
    </a>
    <h1 class="mt-3 text-3xl font-bold tracking-tight">Edit card</h1>

    <form method="POST" action="{{ route('collections.cards.update', [$collection, $card]) }}" class="mt-8 space-y-6 rounded-2xl border border-line p-6 sm:p-8" novalidate>
        @csrf
        @method('PUT')

        <div>
            <label for="question" class="mb-1.5 block text-sm font-semibold">Question</label>
            <textarea id="question" name="question" rows="3"
                      class="w-full resize-y rounded-lg border border-line px-4 py-2.5 placeholder:text-ink-soft/60 focus:border-shu focus:ring-2 focus:ring-shu/20 focus:outline-none">{{ old('question', $card->question) }}</textarea>
            @error('question')<p class="mt-1.5 text-sm text-shu">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="answer" class="mb-1.5 block text-sm font-semibold">Answer</label>
            <textarea id="answer" name="answer" rows="4"
                      class="w-full resize-y rounded-lg border border-line px-4 py-2.5 placeholder:text-ink-soft/60 focus:border-shu focus:ring-2 focus:ring-shu/20 focus:outline-none">{{ old('answer', $card->answer) }}</textarea>
            @error('answer')<p class="mt-1.5 text-sm text-shu">{{ $message }}</p>@enderror
        </div>

        <div class="flex flex-col-reverse gap-3 border-t border-line pt-6 sm:flex-row sm:justify-end">
            <a href="{{ route('collections.show', $card->collection) }}" class="rounded-lg px-5 py-2.5 text-center font-medium text-ink-soft hover:bg-paper">Cancel</a>
            <button type="submit" class="rounded-lg bg-shu px-5 py-2.5 font-semibold text-white transition hover:bg-shu-dark">Save changes</button>
        </div>
    </form>
</div>
@endsection
