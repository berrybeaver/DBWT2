import './bootstrap.js';
import { createApp } from 'vue';

// import {pi, round} from 'mathjs';
//
// let r = round(pi, 5); //aufgabe 3 m4
// alert(r);
import VueScrollUp from "vue-scroll-up";
import navbar from './components/navbar.vue';
import siteheader from "./components/siteheader.vue"
import sitebody from "./components/sitebody.vue"
import sitefooter from "./components/sitefooter.vue"
import articlesearch from "./articlesearch.vue";
import newarticle from "./newArticle.vue";
import pagination from "./components/Pagination.vue";


createApp({
    components: {
        articlesearch,
        newarticle,
        pagination,
        VueScrollUp,
    }
}).mount('#app');

createApp({
    components: {
        siteheader,
        navbar,
    }
}).mount('#header')

createApp({
    components: {
        sitebody,
    }
}).mount('#body')

createApp({
    components: {
        sitefooter
    },
    data(){
        return{
            showImpressum: false,
        };
    },
    methods:{
        async toggleImpressum(){
            this.showImpressum = !this.showImpressum;
        }
    }
}).mount('#footer')
