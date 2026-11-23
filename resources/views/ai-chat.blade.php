<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AI Assistant</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f0f2f5; margin: 0; padding: 20px; }
        .box { max-width: 700px; margin: 0 auto; background: #fff; border-radius: 10px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,.1); }
        h1 { margin-top: 0; font-size: 22px; }
        #chat { min-height: 300px; max-height: 450px; overflow-y: auto; border: 1px solid #e5e7eb; border-radius: 8px; padding: 10px; }
        .msg { padding: 10px 14px; margin: 8px 0; border-radius: 10px; white-space: pre-wrap; max-width: 85%; }
        .user { background: #d1e7ff; margin-left: auto; }
        .ai { background: #eee; }
        .err { background: #fee2e2; color: #991b1b; }
        .row { display: flex; gap: 8px; margin-top: 12px; }
        input { flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 8px; font-size: 15px; }
        button { padding: 10px 18px; border: 0; border-radius: 8px; background: #2563eb; color: #fff; cursor: pointer; font-size: 15px; }
        button:disabled { background: #94a3b8; }
    </style>
</head>
<body>
<div class="box">
    <h1>AI Assistant</h1>
    <div id="chat"></div>
    <div class="row">
        <input id="msg" type="text" placeholder="Type imong pangutana..." autocomplete="off">
        <button id="send">Send</button>
    </div>
</div>

<script>
const chat = document.getElementById('chat');
const input = document.getElementById('msg');
const btn = document.getElementById('send');

function add(text, cls) {
    const d = document.createElement('div');
    d.className = 'msg ' + cls;
    d.textContent = text;
    chat.appendChild(d);
    chat.scrollTop = chat.scrollHeight;
    return d;
}

async function send() {
    const message = input.value.trim();
    if (!message) return;
    add(message, 'user');
    input.value = '';
    btn.disabled = true;
    const wait = add('Nagpaabot...', 'ai');

    try {
        const res = await fetch('/ai-chat', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ message }),
        });
        const data = await res.json();
        if (data.reply) { wait.textContent = data.reply; }
        else { wait.className = 'msg err'; wait.textContent = data.error || data.message || 'Naay error.'; }
    } catch (e) {
        wait.className = 'msg err';
        wait.textContent = 'Connection error.';
    }
    btn.disabled = false;
    input.focus();
}

btn.addEventListener('click', send);
input.addEventListener('keydown', e => { if (e.key === 'Enter') send(); });
</script>
</body>
</html>