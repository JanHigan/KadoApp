@extends('layouts.app')
@section('title', 'My collections')

@if (session('success'))
    @section('flash')
        <div class="rounded-xl border border-moss/20 bg-moss-soft px-4 py-3 text-sm text-moss" role="status">
            {{ session('success') }}
        </div>
    @endsection
@endif

@section('content')
<div class="flex flex-wrap items-end justify-between gap-4">
    <div>
        <h1 class="text-3xl font-bold tracking-tight sm:text-4xl">My collections</h1>
        <p class="mt-2 text-ink-soft">Select a collection to review flashcards or add new ones.</p>
    </div>
    <a href="#" class="rounded-lg border border-line px-4 py-2 text-sm font-medium transition hover:border-shu hover:text-shu">Import from JSON</a>
</div>

@if ($collections->isNotEmpty())
    <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($collections as $collection)
            @php
                $total = $collection->cards_count;
                $learned = $collection->learned_cards_count;
                $percent = $total > 0 ? round(($learned / $total) * 100) : 0;
            @endphp

            <a href="{{ route('collections.show', $collection) }}" class="group relative flex flex-col overflow-hidden rounded-2xl border border-line bg-white p-5 transition hover:border-shu/40 hover:shadow-lg hover:shadow-shu/5">
                <span class="absolute inset-y-0 left-0 w-1 bg-shu opacity-0 transition group-hover:opacity-100"></span>
                <h2 class="text-lg font-semibold leading-snug">{{ $collection->name }}</h2>
                <p class="mt-1.5 line-clamp-2 min-h-10 text-sm text-ink-soft">{{ $collection->description ?? 'Without description' }}</p>

                <div class="mt-5 flex items-center justify-between text-sm">
                    <span class="font-medium">{{ $total }} cards</span>
                    <span class="text-ink-soft">{{ $percent }}%</span>
                </div>
                <div class="mt-2 h-1.5 overflow-hidden rounded-full bg-paper">
                    <div class="h-full rounded-full bg-shu transition-all duration-300" style="width: {{ $percent }}%"></div>
                </div>
            </a>
        @endforeach

        <a href="{{ route('collections.create') }}" class="flex min-h-40 flex-col items-center justify-center gap-2 rounded-2xl border-2 border-dashed border-line text-ink-soft transition hover:border-shu hover:bg-shu-soft hover:text-shu">
            <span class="text-3xl leading-none">+</span>
            <span class="text-sm font-medium">Create collection</span>
        </a>
    </div>

    <div class="mt-8">
        {{ $collections->links() }}
    </div>
@else
    <div class="mt-12 rounded-3xl bg-paper px-6 py-14 text-center">
        @include('partials.logo', ['size' => 'mx-auto h-16 w-16'])
        <h2 class="mt-5 text-xl font-semibold">There are no collections yet.</h2>
        <p class="mx-auto mt-2 max-w-sm text-ink-soft">Create your first collection and add cards to it, or load a ready-made one from a JSON file.</p>
        <a href="{{ route('collections.create') }}" class="mt-6 inline-block rounded-lg bg-shu px-5 py-2.5 font-semibold text-white hover:bg-shu-dark">Create collection</a>
    </div>
@endif
@endsection
