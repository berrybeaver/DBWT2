import './bootstrap.js';
import {pi, round} from 'mathjs';

let r = round(pi, 5); //aufgabe 3 m4
alert(r);

import articlesearch from "./articlesearch.vue";
import newarticle from "./newArticle.vue";
import { createApp } from 'vue';
createApp({
    components: {
        articlesearch,
        newarticle,
    }
}).mount('#app');
