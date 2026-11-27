@extends('layouts.app')
@section('title', 'Import collection from JSON')

@section('content')
<div class="mx-auto max-w-xl">
    <a href="{{ route('collections.index') }}" class="text-sm text-ink-soft hover:text-shu">
        ← To collections
    </a>
    <h1 class="mt-3 text-3xl font-bold tracking-tight">Import from JSON</h1>
    <p class="mt-2 text-sm text-ink-soft">Upload a JSON file exported from KadoApp or formatted according to the schema below.</p>

    <form method="POST" action="{{ route('collections.import.store') }}" enctype="multipart/form-data"
          class="mt-8 space-y-6 rounded-2xl border border-line p-6 sm:p-8">
        @csrf

        <div>
            <label for="file" class="mb-1.5 block text-sm font-semibold">JSON file</label>
            <input type="file" id="file" name="file" accept=".json,application/json" required
                   class="w-full rounded-lg border border-line bg-white px-4 py-2.5 text-sm file:mr-4 file:rounded-lg file:border-0 file:bg-shu-soft file:px-4 file:py-2 file:text-sm file:font-semibold file:text-shu hover:file:bg-shu/15">
            @error('file')<p class="mt-1.5 text-sm text-shu">{{ $message }}</p>@enderror
        </div>

        <div class="rounded-xl bg-paper p-4 text-xs text-ink-soft">
            <p class="font-semibold text-ink">Expected JSON format:</p>
            <pre class="mt-2 overflow-x-auto font-mono leading-relaxed">{
  "name": "Japanese N5",
  "description": "Basic vocabulary",
  "cards": [
    { "question": "水 (みず)", "answer": "Water" },
    { "question": "火 (ひ)", "answer": "Fire" }
  ]
}</pre>
        </div>

        <div class="flex flex-col-reverse gap-3 border-t border-line pt-6 sm:flex-row sm:justify-end">
            <a href="{{ route('collections.index') }}" class="rounded-lg px-5 py-2.5 text-center font-medium text-ink-soft hover:bg-paper">Cancel</a>
            <button type="submit" class="rounded-lg bg-shu px-5 py-2.5 font-semibold text-white transition hover:bg-shu-dark">Import collection</button>
        </div>
    </form>
</div>
@endsection
