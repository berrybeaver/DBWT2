<script>
import axios from "axios";
export default{
    data() {
        return {
            search: '',
            articles: [],

        };
    },methods: {
        async searchArticles() {
            if (this.search.length >= 3) {
                try {
                    const response = await axios.get(`/api/articles?search=${this.search}`);
                    this.articles = response.data.slice(0,5);
                } catch (error) {
                    console.error(error);
                }
            } else if(this.search.length == 0) {
                try {
                    const response = await axios.get(`/api/articles`);
                    this.articles = response.data;
                } catch (error) {
                    console.error(error);
                }
            }else {
                return;
            }
        },
        updateArticle(id) {
            window.updateCart(id);
        }
    },
    mounted() {
        this.searchArticles();
    }
}

</script>

<template>
    <h2>Article Search</h2>
    <input type="text" v-model="search" @input="searchArticles">
    <table>
        <thead>
        <tr>
            <th >Article</th>
            <th >Description</th>
            <th >Price</th>
            <th >Images</th>
            <th >created at</th>
            <th >Add to Basket</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(article, index) in articles" :key = "index" id="items" >
            <th>{{ article.ab_name }}</th>
            <td>{{ article.ab_description }}</td>
            <td>{{ (article.ab_price / 100).toLocaleString('de-DE', { style: 'currency', currency: 'EUR' }) }} </td>
            <td class="border px-2 py-1"><img :src="article.image_url" :alt="article.ab_name" class="w-6" style="width: 100px;"></td>
            <td>{{ article.ab_createdate }}</td>
            <td style="text-align:center; background-color: black;" @click=" updateArticle(article.id)"><button>+</button></td>
        </tr>
        </tbody>
    </table>
</template>

<style scoped>

</style>
