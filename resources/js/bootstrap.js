import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Echo from 'laravel-echo'
import Pusher from "pusher-js"

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'a7b379dd02f15b78f86e',
    cluster: 'eu',
    forceTLS: true
});