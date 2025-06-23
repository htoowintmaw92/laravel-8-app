<!DOCTYPE html>
<html>
<head>
    <title>Live Messages</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h2>Live Messages</h2>
    <ul id="message-list"></ul>

    <button onclick="sendMessage()">Send Test Message</button>

    <!-- <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo/dist/echo.iife.js"></script> -->


    <script src="https://cdn.jsdelivr.net/npm/pusher-js@7.2.0/dist/web/pusher.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.11.3/dist/echo.iife.js"></script>

    <script>
        // const Echo = new window.Echo({
        //     broadcaster: 'pusher',
        //     key: 'local',
        //     wsHost: window.location.hostname,
        //     wsPort: 6001,
        //     forceTLS: false,
        //     disableStats: true
        // });

        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: "{{ config('broadcasting.connections.pusher.key') }}",
            cluster: 'mt1', // required by Echo even for local
            // wsHost: window.location.hostname,
            wsHost: "{{ config('broadcasting.connections.pusher.options.host', request()->getHost()) }}",
            wsPort: 6001,
            wssPort: "{{ config('broadcasting.connections.pusher.options.port', 6001) }}",
            forceTLS: true,
            disableStats: true,
            enabledTransports: ['ws', 'wss']
        });

        window.Echo.channel('messages')
            .listen('.message.sent', (e) => {
                console.log('received :', e);
                const list = document.getElementById('message-list');
                const item = document.createElement('li');
                item.textContent = e.message;
                list.appendChild(item);
            });

        function sendMessage() {
            fetch('/send-message', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ message: 'Hello WebSocket at ' + new Date().toLocaleTimeString() })
            });
        }

        // let ws = new WebSocket("ws://54.242.215.143:6001/app/localkey?protocol=7&client=js&version=7.2.0&flash=false");
        // ws.onmessage = (e) => console.log("message", e);
        // ws.onerror = (e) => console.log("WebSocket error", e);
    </script>
</body>
</html>
