@php
/**
 * Reusable submit modal partial.
 * Exposes window.showSubmitModal() and window.hideSubmitModal()
 */
@endphp


<div id="submit-modal">
    <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="submit-modal-msg">
        <div class="check" aria-hidden="true">
            <svg viewBox="0 0 24 24">
                <path d="M20 6L9 17l-5-5"></path>
            </svg>
        </div>
        <p id="submit-modal-msg" class="modal-title">Thank you for answering the questionnaire!</p>
        <p class="modal-sub">Would you like to go back to the dashboard or answer again?</p>
        <div class="modal-actions">
            <button id="pm-go-dashboard" class="btn primary">Go to Dashboard</button>
            <button id="pm-answer-again" class="btn">Answer Again</button>
        </div>
    </div>
</div>

<script>
    (function(){
        const modal = document.getElementById('submit-modal');
        const goDash = document.getElementById('pm-go-dashboard');
        const answerAgain = document.getElementById('pm-answer-again');

        function show() {
            if (!document.body.contains(modal)) {
                document.body.appendChild(modal);
            }
            requestAnimationFrame(() => {
                modal.style.display = 'flex';
                void modal.offsetWidth;
            });
        }

        function hide() {
            modal.style.display = 'none';
        }


        window.showSubmitModal = show;
        window.hideSubmitModal = hide;

        goDash.addEventListener('click', function(){ window.location.href = '/dash'; });
        answerAgain.addEventListener('click', function(){ hide(); try { const f = document.querySelector('form[action="/questionnaire/answer"]'); if (f) f.reset(); const first = f ? f.querySelector('input, textarea, select') : null; if (first) first.focus(); } catch(e){} });


        document.addEventListener('keydown', function(ev){ if (ev.key === 'Escape') hide(); });
    })();
</script>
