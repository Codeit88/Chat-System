import { createApp } from 'vue';
import axios from 'axios';
import ChatMessages from './components/ChatMessages.vue';
import ChatForm from './components/ChatForm.vue';
import './bootstrap';
import './echo'

const app = createApp({
    data() {
        return {
            messages: []
        };
    },
    created() {
        this.fetchMessages();
        // resources/assets/js/app.js

        Echo.channel('chat')
            .listen('MessageSent', (e) => {
                console.log(e.message.content);
                this.messages.push({
                    message: e.message.content,
                    user: e.user
                });
            });

    },
    methods: {
        fetchMessages() {
            axios.get('/messages').then(response => {
                this.messages = response.data;
            });
        },
        addMessage(message) {
            this.messages.push(message);

            axios.post('/messages', message).then(response => {
                console.log(response.data);
            });
        }
    }
});

app.component('chat-messages', ChatMessages);
app.component('chat-form', ChatForm);

app.mount('#app');
