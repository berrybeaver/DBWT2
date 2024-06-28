<script>
import axios from "axios";
import { add } from 'mathjs';
import Pagination from "@/components/Pagination.vue";
import impressum from "@/components/impressum.vue";

export default{
    components: {Pagination},
    data() {
        return {
            search: '',
            //searchedarticles: [],
            articles: [],
            page: 1,
            totalpages: 0,
            perpage: 5,
            items:[],
        };
    }
    ,methods: {
        connectEcho(){
            window.Pusher.logToConsole = true;
            window.Echo.channel('wartung')
                .listen('.wartungsevent', (e) => {
                    alert(e.message);
            })

            let userId = 1;
            window.Echo.channel('verkaufsMeldung')
                .listen('.verkaufs-Meldung', (e) => {
                    alert(e.message);
                })
        },
        changePage(newPage) {

            this.page = newPage;
            this.searchArticles();
        },
        changeItemsPerPage(newItemsPerPage) {
            this.perpage = newItemsPerPage;
            this.searchArticles();
        },
        async searchArticles() {

            if (this.search.length >= 3) {
                try {
                    const response = await axios.get(`/api/articles?search=${this.search}&page=${this.page}&perpage=${this.perpage}`);
                    let data = response.data;
                    this.articles = data.data;
                    this.totalpages = Math.ceil(response.data.total / this.perpage);
                } catch (error) {
                    console.error(error.message);
                }
            } else if(this.search.length == 0) {
                try {
                    const response = await axios.get(`/api/articles?page=${this.page}&perpage=${this.perpage}`);
                    this.articles = response.data.data;
                    this.totalpages = Math.ceil(response.data.total / this.perpage);
                } catch (error) {
                    console.error(error);
                }
            }
        },
        updateArticle(id) {
            window.updateCart(id);
        },
        //addbasket function
        loadCart() {
            fetch('/api/shoppingcart', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            })
                .then(response => response.json())
                .then(data => {
                    this.items = data;
                })
                .catch(error => console.error('Error loading cart:', error));
        },
        addProduct(article) {
            if (!this.items.find(item => item.id === article.id)) {
                this.items.push(article);
                console.log(items);
            }
        },
        removeProduct(article) {
            this.items = this.items.filter(item => item.id !== article.id);
            this.removeItem(1, article.id);
        },
        removeAll() {
            this.items.forEach(item => {
                this.removeItem(1, item.id);
            });
            this.items = [];
        },
        removeItem(shoppingCartId, articleId) {
            fetch(`/api/shoppingcart/${shoppingCartId}/articles/${articleId}`, {
                method: 'DELETE',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
                .then(response => response.json())
                .then(data => {
                    console.log('Item removed:', data);
                })
                .catch(error => console.error('Error removing item:', error));
        },

    },
    mounted() {
        this.searchArticles();
        this.loadCart();
        this.connectEcho();
    },
    computed:{
        totalPrice() {
            return this.items.reduce((sum, item) => add(sum, item.ab_price / 100), 0);
        },
    }

}
</script>

<template>
    <div class="footer">
        <impressum v-if="impressumVisible" />
    </div>
    <h2 style="font-weight: bolder;"> My Basket</h2>
    <div>
        <table style="width: 100%;" ref="basketTable">
            <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in items" :key="item.id">
                <td>{{ item.ab_name }}</td>
                <td>{{ (item.ab_price / 100).toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) }} €</td>
                <td style="text-align: center; background-color: darkred;">
                    <button @click="removeProduct(item)">Remove</button>
                </td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <td>Total</td>
                <td>{{ totalPrice.toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) }} €</td>
                <td style="text-align: center; background-color: darkred;">
                    <button @click="removeAll">Remove All</button>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
    <h2>Article Search</h2>
    <input type="text" v-model="search" @input="searchArticles">
    <table style="width: 100%;">
        <thead>
        <tr>
            <th >No</th>
            <th >Article</th>
            <th >Description</th>
            <th >Price</th>
            <th >Images</th>
            <th >created at</th>
            <th >Add to Basket</th>
            <th >Mark as sold</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="article in articles" :key = "article.id" id="items" > <!-- article.id statt index-->
            <th>{{article.id}}</th>
            <th>{{ article.ab_name }}</th>
            <td>{{ article.ab_description }}</td>
            <td>{{ (article.ab_price / 100).toLocaleString('de-DE', { style: 'currency', currency: 'EUR' }) }} </td>
            <td ><img :src="article.image_url" :alt="article.ab_name" style="width: 100px;"></td>
            <td>{{ article.ab_createdate }}</td>
            <td style="text-align:center;" @click=" addProduct(article)"><button>+</button></td>
            <td style="text-align: center; "><button>Sold</button></td>
        </tr>
        </tbody>
    </table>
    <div id="app">
        <table>
            <tbody>
                <tr>
                    <pagination :page="page" :totalPages="totalpages" :itemsPerPage="perpage" @page-changed="changePage"
                                @items-per-page-changed="changeItemsPerPage"></pagination>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<style scoped lang="scss">

</style>
