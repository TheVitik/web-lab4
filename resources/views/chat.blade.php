<!DOCTYPE html>
<html>
<head>
    <title>Chat App</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div id="messages" style="height:300px; overflow-y: auto;">
                        <!-- Messages will be displayed here -->
                    </div>
                </div>
                <div class="card-footer">
                    <input type="text" id="nameInput" class="form-control mb-2" placeholder="Your name">
                    <textarea id="messageInput" class="form-control" placeholder="Message" rows="3"></textarea>
                    <button onclick="sendMessage()" class="btn btn-primary mt-2">Send</button>
                </div>
            </div>
        </div>
    </div>
</div>

@vite('resources/js/app.js')
<script>
    window.Laravel = {csrfToken: '{{ csrf_token() }}'};
    const messagesContainer = document.getElementById('messages');
    const nameInput = document.getElementById('nameInput');
    const messageInput = document.getElementById('messageInput');

    document.addEventListener('DOMContentLoaded', () => {
        window.Echo.channel('chat')
            .listen('.new-message', (e) => {
                if (e.name === nameInput.value) return;
                addMessageToChat(e.name, e.message);
            })

        messageInput.addEventListener('keypress', function (event) {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                sendMessage();
            }
        });
    });

    function sendMessage() {
        const name = nameInput.value;
        const message = messageInput.value;
        if (!name || !message) return;

        fetch('/send-message', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({name: name, message: message})
        })
            .then(response => response.json())
            .then(() => addMessageToChat(name, message, true))
            .catch(error => console.error('Error:', error));

        messageInput.value = '';
    }

    function addMessageToChat(name, message, mine = false) {
        const messageElement = document.createElement('div');
        if (mine) {
            messageElement.classList.add('alert', 'alert-success', 'text-right');
        } else {
            messageElement.classList.add('alert', 'alert-primary');
        }
        messageElement.innerHTML = `<strong>${name}</strong>: ${message}`;
        messagesContainer.appendChild(messageElement);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }
</script>
</body>
</html>
