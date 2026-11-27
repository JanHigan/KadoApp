<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'KadoApp') }} | @yield('title')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Onest:wght@100..900&display=swap" rel="stylesheet">
    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :focus-visible { outline: 2px solid #D7351F; outline-offset: 2px; }
        @media (prefers-reduced-motion: reduce) { * { transition: none !important; animation: none !important; } }
    </style>
</head>
<body class="min-h-screen bg-white font-sans text-ink antialiased flex flex-col">
    <header class="border-b border-line bg-white/90 backdrop-blur sticky top-0 z-20">
        <div class="mx-auto flex max-w-5xl items-center justify-between px-4 py-3 sm:px-6">
            <a href="{{ route('collections.index') }}" class="flex items-center gap-2.5">
                @include('partials.logo')
                <span class="text-xl font-bold tracking-tight">Kado<span class="text-shu">App</span></span>
            </a>
            <nav class="flex items-center gap-2">
                <a href="{{ route('collections.import') }}" class="hidden rounded-lg px-3 py-2 text-sm font-medium text-ink-soft hover:bg-paper hover:text-ink sm:block">Import</a>
                <a href="{{ route('collections.create') }}" class="rounded-lg bg-shu px-4 py-2 text-sm font-semibold text-white transition hover:bg-shu-dark">New collection</a>
            </nav>
        </div>
    </header>

    <main class="mx-auto w-full max-w-5xl flex-1 px-4 py-8 sm:px-6 sm:py-12">
        @hasSection('flash')
            <div class="mb-6">@yield('flash')</div>
        @endif
        @yield('content')
    </main>

    <footer class="border-t border-line">
        <div class="mx-auto flex max-w-5xl items-center justify-between px-4 py-5 text-sm text-ink-soft sm:px-6">
            <span class="flex items-center gap-2">@include('partials.logo', ['size' => 'h-5 w-5']) KadoApp</span>
            <span>Learn one flashcard at a time</span>
        </div>
    </footer>
</body>
</html>
