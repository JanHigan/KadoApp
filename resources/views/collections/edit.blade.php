@extends('layouts.app')
@section('title', 'Edit ' . $collection->name)

@section('content')
<div class="mx-auto max-w-xl">
    <a href="{{ route('collections.show', $collection) }}" class="text-sm text-ink-soft hover:text-shu">
        ← {{ $collection->name }}
    </a>
    <h1 class="mt-3 text-3xl font-bold tracking-tight">Edit collection</h1>

    <form method="POST" action="{{ route('collections.update', $collection) }}" class="mt-8 space-y-6 rounded-2xl border border-line p-6 sm:p-8" novalidate>
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="mb-1.5 block text-sm font-semibold">Name</label>
            <input type="text" id="name" name="name" value="{{ old('name', $collection->name) }}" maxlength="100" required
                   class="w-full rounded-lg border border-line px-4 py-2.5 placeholder:text-ink-soft/60 focus:border-shu focus:ring-2 focus:ring-shu/20 focus:outline-none">
            @error('name')<p class="mt-1.5 text-sm text-shu">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="description" class="mb-1.5 block text-sm font-semibold">Description (optional)</label>
            <textarea id="description" name="description" rows="3" maxlength="255"
                      class="w-full resize-y rounded-lg border border-line px-4 py-2.5 placeholder:text-ink-soft/60 focus:border-shu focus:ring-2 focus:ring-shu/20 focus:outline-none">{{ old('description', $collection->description) }}</textarea>
            @error('description')<p class="mt-1.5 text-sm text-shu">{{ $message }}</p>@enderror
        </div>

        <div class="flex flex-col-reverse gap-3 border-t border-line pt-6 sm:flex-row sm:justify-end">
            <a href="{{ route('collections.show', $collection) }}" class="rounded-lg px-5 py-2.5 text-center font-medium text-ink-soft hover:bg-paper">Cancel</a>
            <button type="submit" class="rounded-lg bg-shu px-5 py-2.5 font-semibold text-white transition hover:bg-shu-dark">Save changes</button>
        </div>
    </form>
</div>
@endsection
