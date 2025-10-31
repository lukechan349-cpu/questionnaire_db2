@extends('layouts.app')

@section('content')
    <h1>Dashboard</h1>
    <p class="lead">Welcome to the dashboard. Click the button below to open the questionnaire.</p>

    <div class="button-row">
        <a class="btn" href="/questionnaire">Open Questionnaire</a>
        <button id="open-history" class="btn" type="button">Answer History</button>
    </div>

    <div id="history-modal">
        <div class="modal-overlay"></div>
        <div class="modal-inner">
            <div class="modal-content-box">
                <div class="modal-row">
                    <h2 class="modal-title">Answer History</h2>
                    <div class="modal-actions-inline">
                        <button id="clear-history" class="small-btn" disabled>Clear History</button>
                        <button id="close-history" class="icon-btn" title="Close">✕</button>
                    </div>
                </div>
                <div id="history-content">
                    <p class="loading">Loading...</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function(){
            const btn = document.getElementById('open-history');
            const modal = document.getElementById('history-modal');
            const closeBtn = document.getElementById('close-history');
            const content = document.getElementById('history-content');

            function renderAnswers(list){
                if(!list || !list.length){
                    content.innerHTML = '<p><em>No answers yet.</em></p>';
                    return;
                }

                const html = list.map(a=>{
                    return `<div class="history-item">
                        <strong>${escapeHtml(a.question || 'Unknown question')}</strong>
                        <div class="answer">${escapeHtml(a.answer_text)}</div>
                        <div class="meta">Answered ${escapeHtml(a.created_human)}</div>
                    </div>`;
                }).join('');

                content.innerHTML = html;
            }

            function escapeHtml(s){
                if(!s) return '';
                return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
            }

            btn.addEventListener('click', function(){
                modal.style.display = 'flex';
                content.innerHTML = '<p>Loading...</p>';
                fetch('/questionnaire/history-data')
                    .then(r=>r.json())
                    .then(js=>{
                        renderAnswers(js.data || []);

                        const clearBtn = document.getElementById('clear-history');
                        if(clearBtn) clearBtn.disabled = !(js.data && js.data.length);
                    })
                    .catch(err=>{
                        content.innerHTML = '<p class="error">Failed to load history.</p>';
                        console.error(err);
                    });
            });


            const clearBtn = document.getElementById('clear-history');
            if(clearBtn){
                clearBtn.addEventListener('click', function(){
                    if(!confirm('Clear all answer history? This cannot be undone.')) return;
                    clearBtn.disabled = true;
                    clearBtn.textContent = 'Clearing...';
                    fetch('/questionnaire/history-clear', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({})
                    }).then(r=>r.json()).then(js=>{
                        renderAnswers([]);
                        clearBtn.textContent = 'Clear History';
                        clearBtn.disabled = true;
                    }).catch(err=>{
                        alert('Failed to clear history');
                        console.error(err);
                        clearBtn.textContent = 'Clear History';
                        clearBtn.disabled = false;
                    });
                });
            }

            closeBtn.addEventListener('click', function(){ modal.style.display = 'none'; });
            modal.addEventListener('click', function(e){ if(e.target === modal) modal.style.display='none'; });
        })();
    </script>
@endsection
