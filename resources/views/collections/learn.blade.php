@extends('layouts.app')
@section('title', 'Learning: ' . $collection->name)

@section('content')
<div class="mx-auto max-w-xl">
    <div class="flex items-center justify-between text-sm text-ink-soft">
        <a href="{{ route('collections.show', $collection) }}" class="hover:text-shu">
            ← Exit to {{ $collection->name }}
        </a>
        @if ($card)
            <span>Remaining: <strong class="text-ink">{{ $remainingCount }}</strong> / {{ $totalCards }}</span>
        @endif
    </div>

    @if ($card)
        @php
            $learned = $totalCards - $remainingCount;
            $percent = $totalCards > 0 ? round(($learned / $totalCards) * 100) : 0;
        @endphp

        {{-- Прогресс-бар --}}
        <div class="mt-3 h-2 overflow-hidden rounded-full bg-paper">
            <div class="h-full rounded-full bg-shu transition-all duration-300" style="width: {{ $percent }}%"></div>
        </div>

        {{-- Карточка --}}
        <div class="mt-8 rounded-3xl border border-line bg-white p-8 shadow-sm sm:p-10">
            <span class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Question</span>
            <p class="mt-3 text-2xl font-bold leading-snug">{{ $card->question }}</p>

            {{-- Блок ответа (изначально скрыт) --}}
            <div id="answer-box" class="mt-8 hidden border-t border-line pt-6">
                <span class="text-xs font-semibold uppercase tracking-wider text-ink-soft">Answer</span>
                <p class="mt-2 text-xl text-ink-soft">{{ $card->answer }}</p>
            </div>
        </div>

        {{-- Кнопка показа ответа --}}
        <div id="show-btn-box" class="mt-6">
            <button type="button" onclick="revealAnswer()"
                    class="w-full rounded-xl bg-shu py-3.5 font-semibold text-white shadow-lg shadow-shu/20 transition hover:bg-shu-dark">
                Show answer
            </button>
        </div>

        {{-- Кнопки оценки (появляются после открытия ответа) --}}
        <div id="rate-btns-box" class="mt-6 hidden grid-cols-2 gap-3">
            <form method="POST" action="{{ route('collections.cards.review', [$collection, $card]) }}">
                @csrf
                <input type="hidden" name="result" value="0">
                <button type="submit" class="w-full rounded-xl border border-line bg-white py-3.5 font-semibold text-shu transition hover:bg-shu-soft">
                    Still learning
                </button>
            </form>

            <form method="POST" action="{{ route('collections.cards.review', [$collection, $card]) }}">
                @csrf
                <input type="hidden" name="result" value="1">
                <button type="submit" class="w-full rounded-xl bg-moss py-3.5 font-semibold text-white transition hover:opacity-90">
                    I know this
                </button>
            </form>
        </div>

        <script>
            function revealAnswer() {
                document.getElementById('answer-box').classList.remove('hidden');
                document.getElementById('show-btn-box').classList.add('hidden');
                const rateBox = document.getElementById('rate-btns-box');
                rateBox.classList.remove('hidden');
                rateBox.classList.add('grid');
            }
        </script>
    @else
        {{-- Экран завершения --}}
        <div class="mt-10 rounded-3xl bg-paper px-6 py-14 text-center">
            @include('partials.logo', ['size' => 'mx-auto h-16 w-16'])
            <h1 class="mt-5 text-2xl font-bold">All cards learned!</h1>
            <p class="mx-auto mt-2 max-w-sm text-ink-soft">
                You've reviewed all {{ $totalCards }} cards in «{{ $collection->name }}».
            </p>
            <div class="mt-6 flex flex-wrap justify-center gap-3">
                <a href="{{ route('collections.show', $collection) }}" class="rounded-xl bg-shu px-6 py-3 font-semibold text-white hover:bg-shu-dark">
                    Back to collection
                </a>
                <form method="POST" action="{{ route('collections.learn.reset', $collection) }}">
                    @csrf
                    <button type="submit" class="rounded-xl border border-line bg-white px-6 py-3 font-medium transition hover:border-shu hover:text-shu">
                        Practice again
                    </button>
                </form>
            </div>
        </div>
    @endif
</div>
@endsection
