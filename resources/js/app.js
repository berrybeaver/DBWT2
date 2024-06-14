import './bootstrap.js';
import {pi, round} from 'mathjs';

let r = round(pi, 3);
alert(r);

import articlesearch from "./articlesearch.vue";
import { createApp } from 'vue';
createApp({
    components: {
        articlesearch
    }
}).mount('#app');
