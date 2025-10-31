@extends('layouts.app')

@section('content')
    <h1>Answer History</h1>

    @if(isset($answers) && $answers->count())
        <div>
            @foreach($answers as $answer)
                <div class="history-item">
                    <strong>{{ $answer->question?->title ?? 'Unknown question' }}</strong>
                    <div class="answer">{{ $answer->answer_text }}</div>
                    <div class="meta">Submitted {{ $answer->created_at->diffForHumans() }}</div>
                </div>
            @endforeach
        </div>
    @else
        <p><em>No answers yet.</em></p>
    @endif

    <p class="mt-14">
        <a class="btn" href="/dash">Back to dashboard</a>
    </p>
@endsection
