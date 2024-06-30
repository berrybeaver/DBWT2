<script>
import axios from "axios";
import { add } from 'mathjs';
import Pagination from "@/components/Pagination.vue";
import impressum from "@/components/impressum.vue";

export default{
    props: ['show-impressum'],
    components: {Pagination, impressum},
    data() {
        return {
            search: '',
            articles: [],
            page: 1,
            totalpages: 0,
            perpage: 5,
            items:[],
            userId: '1',
            currentUserId: 5,
        };
    }
    ,methods: {
        connectEcho(){
            window.Pusher.logToConsole = true;
            window.Echo.channel('wartung')
                .listen('.wartungsevent', (e) => {
                    alert(e.message);
                });

            let userId = 5; //change according to article
            window.Echo.channel(`verkaufsMeldung.${userId}`)
                .listen('.verkaufs-Meldung', (e) => {
                    console.log('Article sold event received');
                    alert(e.message);
                })
                .error((error) => {
                    console.log('Subscription Error: ', error);
                });
            window.Echo.channel(`OffersEvent`)
                .listen('.Offers-Event', (e) => {
                    console.log('Offers event received');
                    alert(e.message);
                })
                .error((error) => {
                    console.log('offer event Error: ', error);
                });
        },
        changePage(newPage) {

            this.page = newPage;
            this.searchArticles();
        },
        changeItemsPerPage(newItemsPerPage) {
            this.perpage = newItemsPerPage;
            this.searchArticles();
        },
        markAsSold(articleId) {

            axios.post(`/api/articles/${articleId}/sold`)
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    console.error(error);
                });
        },
        setOffer(articleId){
            axios.post(`/api/articles/${articleId}/offer/1`) // Replace '1' with the actual user ID
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    console.error(error);
                });
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
    <impressum v-if="showImpressum"></impressum>
    <div v-else>
    <div>
        <h2 style="font-weight: bolder;"> My Basket</h2>
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
            <th >Offer</th>
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
            <td style="text-align:center;" ><button @click=" addProduct(article)">+</button></td>
            <td style="text-align: center; " ><button @click=" markAsSold(article.id)">Sold</button></td>
            <td >
                <button v-if="article.ab_creator_id === currentUserId " @click="setOffer(article.id)">X</button>
            </td>
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
    </div>
</template>

<style scoped lang="scss">

</style>
