@extends('layouts.app')
@section('title', 'New collection')

@section('content')
<div class="mx-auto max-w-xl">
    <a href="{{ route('collections.index') }}" class="text-sm text-ink-soft hover:text-shu">← To collections</a>
    <h1 class="mt-3 text-3xl font-bold tracking-tight">New collection</h1>

    <form method="POST" action="{{ route('collections.store') }}" class="mt-8 space-y-6 rounded-2xl border border-line p-6 sm:p-8" novalidate>
        @csrf

        <div>
            <label for="name" class="mb-1.5 block text-sm font-semibold">Name</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" placeholder="For example, English phrasal verbs"
                   class="w-full rounded-lg border border-line px-4 py-2.5 placeholder:text-ink-soft/60 focus:border-shu focus:ring-2 focus:ring-shu/20 focus:outline-none">
            @error('name')<p class="mt-1.5 text-sm text-shu">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="description" class="mb-1.5 block text-sm font-semibold">Description <span class="font-normal text-ink-soft">- optional</span></label>
            <textarea id="description" name="description" rows="4" placeholder="What about this collection?"
                      class="w-full resize-y rounded-lg border border-line px-4 py-2.5 placeholder:text-ink-soft/60 focus:border-shu focus:ring-2 focus:ring-shu/20 focus:outline-none">{{ old('description') }}</textarea>
            @error('description')<p class="mt-1.5 text-sm text-shu">{{ $message }}</p>@enderror
        </div>

        <div class="flex flex-col-reverse gap-3 border-t border-line pt-6 sm:flex-row sm:justify-end">
            <a href="{{ url()->previous() }}" class="rounded-lg px-5 py-2.5 text-center font-medium text-ink-soft hover:bg-paper">Cancel</a>
            <button type="submit" class="rounded-lg bg-shu px-5 py-2.5 font-semibold text-white transition hover:bg-shu-dark">Create collection</button>
        </div>
    </form>
</div>
@endsection
