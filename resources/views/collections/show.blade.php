@extends('layouts.app')
@section('title', $collection->name)

@if (session('success'))
    @section('flash')
        <div class="rounded-xl border border-moss/20 bg-moss-soft px-4 py-3 text-sm text-moss" role="status">
            {{ session('success') }}
        </div>
    @endsection
@endif

@section('content')
<a href="{{ route('collections.index') }}" class="text-sm text-ink-soft hover:text-shu">← To collections</a>

<div class="mt-3 flex flex-wrap items-start justify-between gap-6">
    <div class="max-w-xl">
        <h1 class="text-3xl font-bold tracking-tight sm:text-4xl">{{ $collection->name }}</h1>

        @if ($collection->description)
            <p class="mt-2 text-ink-soft">{{ $collection->description }}</p>
        @endif

        @php
            $percent = $totalCards > 0 ? round(($learnedCount / $totalCards) * 100) : 0;
        @endphp

        <p class="mt-3 text-sm font-medium">
            {{ $totalCards }} cards, learned {{ $learnedCount }} ({{ $percent }}%)
        </p>
    </div>

    @if ($totalCards > 0)
        <a href="{{ route('collections.learn', $collection) }}" class="inline-flex items-center rounded-xl bg-shu px-6 py-3 font-semibold text-white shadow-lg shadow-shu/20 transition hover:bg-shu-dark">
            Start learning
        </a>
    @endif
</div>

<div class="mt-6 flex flex-wrap gap-2 border-y border-line py-3 text-sm">
    <a href="{{ route('collections.edit', $collection) }}" class="rounded-lg px-3 py-1.5 font-medium hover:bg-paper">Edit</a>
    <a href="#" class="rounded-lg px-3 py-1.5 font-medium hover:bg-paper">Export to JSON</a>
    <form method="POST" action="{{ route('collections.destroy', $collection) }}" onsubmit="return confirm('Delete collection with all cards?')" class="ml-auto">
        @csrf @method('DELETE')
        <button class="rounded-lg px-3 py-1.5 font-medium text-shu hover:bg-shu-soft">Delete collection</button>
    </form>
</div>

<div class="mt-8 flex items-center justify-between">
    <h2 class="text-xl font-semibold">Cards</h2>
    <a href="{{ route('collections.cards.create', $collection) }}" class="rounded-lg border border-line px-4 py-2 text-sm font-medium transition hover:border-shu hover:text-shu">+ Add card</a>
</div>

@if ($cards->isNotEmpty())
    <ul class="mt-4 divide-y divide-line overflow-hidden rounded-2xl border border-line">
        @foreach ($cards as $card)
        <li class="flex items-start gap-4 bg-white p-4 transition hover:bg-paper sm:items-center sm:p-5">
            <div class="grid min-w-0 flex-1 gap-1 sm:grid-cols-2 sm:gap-6">
                <p class="font-semibold">{{ $card->question }}</p>
                <p class="text-ink-soft">{{ $card->answer }}</p>
            </div>
            <div class="flex shrink-0 gap-1 text-sm">
                <a href="{{ route('collections.cards.edit', [$collection, $card]) }}" class="rounded-lg px-3 py-1.5 font-medium hover:bg-white hover:text-shu">Edit</a>
                <form method="POST" action="{{ route('collections.cards.destroy', [$collection, $card]) }}" onsubmit="return confirm('Delete this card?')">
                    @csrf
                    @method('DELETE')
                    <button class="rounded-lg px-3 py-1.5 text-ink-soft hover:bg-shu-soft hover:text-shu">Delete</button>
                </form>
            </div>
        </li>
        @endforeach
    </ul>

    <div class="mt-6">
        {{ $cards->links() }}
    </div>
@else
    <div class="mt-4 rounded-2xl bg-paper px-6 py-12 text-center">
        <h3 class="text-lg font-semibold">There are no cards in the collection yet.</h3>
        <p class="mt-1 text-ink-soft">Add your first card to start studying.</p>
        <a href="{{ route('collections.cards.create', $collection) }}" class="mt-5 inline-block rounded-lg bg-shu px-5 py-2.5 font-semibold text-white hover:bg-shu-dark">Add card</a>
    </div>
@endif
@endsection
