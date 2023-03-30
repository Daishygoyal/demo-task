import Vue, {createApp} from 'vue';
import FirstComponent from './components/FirstComponent.vue';

const app = createApp({
    el: '#app',
    components: {
        FirstComponent
    },
    template: '<FirstComponent />'
});

app.mount('#app');