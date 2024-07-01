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
            axios.post(`/api/articles/${articleId}/offer`) // Replace '1' with the actual user ID
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
        <div class="basket">
            <h2 class="basket__title">My Basket</h2>
            <table class="basket__table" ref="basketTable">
                <thead class="basket__table-head">
                <tr class="basket__table-row">
                    <th class="basket__table-header">Name</th>
                    <th class="basket__table-header">Price</th>
                    <th class="basket__table-header">Action</th>
                </tr>
                </thead>
                <tbody class="basket__table-body">
                <tr class="basket__table-row" v-for="item in items" :key="item.id">
                    <td class="basket__table-cell basket__table-cell--name">{{ item.ab_name }}</td>
                    <td class="basket__table-cell basket__table-cell--price">{{ (item.ab_price / 100).toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) }} €</td>
                    <td class="basket__table-cell basket__table-cell--action">
                        <button class="basket__remove-button" @click="removeProduct(item)">Remove</button>
                    </td>
                </tr>
                </tbody>
                <tfoot class="basket__table-foot">
                <tr class="basket__table-row">
                    <td class="basket__table-cell basket__table-cell--total-label">Total</td>
                    <td class="basket__table-cell basket__table-cell--total">{{ totalPrice.toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) }} €</td>
                    <td class="basket__table-cell basket__table-cell--action">
                        <button class="basket__remove-all-button" @click="removeAll">Remove All</button>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>

        <h2>Article Search</h2>
        <div class="search">
            <input type="text" class="search__input" v-model="search" @input="searchArticles">
        </div>

        <br>

        <div class="list-table">
            <table class="list-table__table">
                <thead class="list-table__head">
                <tr class="list-table__row">
                    <th class="list-table__header">No</th>
                    <th class="list-table__header">Article</th>
                    <th class="list-table__header">Description</th>
                    <th class="list-table__header">Price</th>
                    <th class="list-table__header">Images</th>
                    <th class="list-table__header">Created at</th>
                    <th class="list-table__header">Add to Basket</th>
                    <th class="list-table__header">Mark as Sold</th>
                    <th class="list-table__header">Offer</th>
                </tr>
                </thead>
                <tbody class="list-table__body">
                <tr class="list-table__row" v-for="article in articles" :key="article.id" id="items">
                    <td class=" list-table__cell--id">{{ article.id }}</td>
                    <td class=" list-table__cell--name">{{ article.ab_name }}</td>
                    <td class=" list-table__cell--description">{{ article.ab_description }}</td>
                    <td class=" list-table__cell--price">{{ (article.ab_price / 100).toLocaleString('de-DE', { style: 'currency', currency: 'EUR' }) }}</td>
                    <td class=" list-table__cell--image"><img :src="article.image_url" :alt="article.ab_name" style="width: 200px"></td>
                    <td class=" list-table__cell--createdate">{{ article.ab_createdate }}</td>
                    <td class=" list-table__cell--add" style="text-align:center;"><button class="list-table__button list-table__button--add" @click="addProduct(article)">+</button></td>
                    <td class=" list-table__cell--sold" style="text-align:center;"><button class="list-table__button list-table__button--sold" @click="markAsSold(article.id)">Sold</button></td>
                    <td class=" list-table__cell--offer">
                        <button v-if="article.ab_creator_id === currentUserId" class="list-table__button list-table__button--offer" @click="setOffer(article.id)">X</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>



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
@import "../../css/app.scss";
//mybasket scss
// Variables
$primary-color: #606C5D;
$secondary-color: #fff;
$font-stack: Arial, sans-serif;
$border-radius: 4px;

// Mixins
@mixin button-style {
    background-color: $primary-color;
    color: $secondary-color;
    border: none;
    border-radius: $border-radius;
    padding: 10px 20px;
    cursor: pointer;

    &:hover {
        background-color: lighten($primary-color, 10%);
    }
}

// Functions
@function px-to-rem($px) {
    @return $px / 16 * 1rem;
}

// Inheritance
%center-text {
    text-align: center;
    font-weight: bold;
}

// Styling using Sass features
.basket {
    &__title {
        font-family: $font-stack;
        font-size: px-to-rem(24);
        font-weight: bolder;
    }

    &__table {
        width: 100%;
        border-collapse: collapse;

        &-head, &-body, &-foot {
            & .basket__table-row {
                th, td {
                    padding: 10px;
                }
            }
        }
    }

    &__table-header {
        @extend %center-text;
        background-color: $primary-color;
        color: $secondary-color;
    }

    &__table-cell {
        &--name, &--price, &--total {
            text-align: left;
        }
        &--action {
            text-align: center;
            background-color: $primary-color;
        }

        &--total-label {
            font-weight: bold;
        }
    }

    &__remove-button, &__remove-all-button {
        @include button-style;
    }
}

</style>
