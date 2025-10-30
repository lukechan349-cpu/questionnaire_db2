@extends('layouts.app')

@section('content')
    <h1>Questionnaire</h1>

    @if(isset($questions) && $questions->count())
        <form method="POST" action="/questionnaire/answer">
            @csrf

            @foreach($questions as $question)
                <section class="question">
                    <h3>{{ $question->title }}</h3>
                    @if($question->body)
                        <p>{{ $question->body }}</p>
                    @endif



                    <div class="field-wrap">
                        @php
                            // detect allowed choices in parentheses, e.g. "Which city (Paris, Tokyo, Rome)"
                            $choices = [];
                            if (preg_match('/\(([^)]+)\)/', $question->title, $m)) {
                                $raw = $m[1];
                                $parts = array_map('trim', explode(',', $raw));
                                $choices = array_values(array_filter($parts, function($v){ return $v !== ''; }));
                            }
                        @endphp

                        <textarea name="answers[{{ $question->id }}]" rows="3" placeholder="Your answer" data-choices='@json($choices)'></textarea>
                    </div>
                </section>
            @endforeach

            <div class="submit-wrap">
                <button type="submit" class="btn" id="submit-answers">Submit Answers</button>
            </div>
        </form>
    @else
        <p><em>No questions found. You can create questions with a seeder or via the admin panel.</em></p>
    @endif
    
    <script>
        (function(){
            const form = document.querySelector('form[action="/questionnaire/answer"]');
            const submitBtn = document.getElementById('submit-answers');

            if (!form) return;

            form.addEventListener('submit', function(e){
                e.preventDefault();
                
                // Check for unanswered questions
                const questions = form.querySelectorAll('.question');
                let unansweredCount = 0;
                
                let invalidCount = 0;

                questions.forEach(questionDiv => {
                    const textarea = questionDiv.querySelector('textarea');
                    questionDiv.classList.remove('unanswered', 'invalid');
                    // remove any previous inline error message
                    const prevErr = questionDiv.querySelector('.error-msg');
                    if (prevErr) prevErr.remove();

                    const val = textarea ? textarea.value.trim() : '';
                    const choices = textarea && textarea.dataset.choices ? JSON.parse(textarea.dataset.choices) : [];

                    if (!val) {
                        unansweredCount++;
                        questionDiv.classList.add('unanswered');
                    } else if (choices && choices.length) {
                        // enforce exact-match against allowed choices (case-insensitive)
                        const matched = choices.some(c => String(c).toLowerCase() === val.toLowerCase());
                        if (!matched) {
                            invalidCount++;
                            questionDiv.classList.add('invalid');
                            const err = document.createElement('div');
                            err.className = 'error-msg';
                            err.textContent = 'Invalid answer — allowed: ' + choices.join(', ');
                            questionDiv.appendChild(err);
                        }
                    }
                });

                if (invalidCount > 0) {
                    submitBtn.textContent = invalidCount === 1 ? '1 invalid answer' : invalidCount + ' invalid answers';
                    setTimeout(() => { submitBtn.textContent = 'Submit Answers'; }, 2500);
                    return;
                }

                if (unansweredCount > 0) {
                    submitBtn.textContent = `Please answer ${unansweredCount === questions.length ? 'the' : 'all'} questions`;
                    setTimeout(() => {
                        submitBtn.textContent = 'Submit Answers';
                    }, 2000);
                    return;
                }

                submitBtn.disabled = true;
                const origText = submitBtn.textContent;
                submitBtn.textContent = 'Submitting...';

                const formData = new FormData(form);

                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }).then(r => r.json()).then(data => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = origText;

                    // show the shared submit modal (partial)
                    if (typeof window.showSubmitModal === 'function') {
                        window.showSubmitModal();
                    } else {
                        // fallback: simple alert
                        alert('Thank You for answering the questionnaire!');
                    }
                }).catch(err => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = origText;
                    alert('There was an error submitting your answers. Please try again.');
                    console.error(err);
                });
            });
        })();
    </script>
@endsection
