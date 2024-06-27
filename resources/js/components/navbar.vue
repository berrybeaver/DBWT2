<script>
    export default {
        data(){
            return {
                menu: [
                    ["Home"],
                    ["Kategorien"],
                    ["Verkaufen"],
                    ["Unternehmen", "Philosophie", "Karriere"],
                ],
                isDropdownVisible: false,
                link: {"Home":"/newsite",
                    "Verkaufen":"/newarticle",
                    "Kategorien":""},
            };
        },
        methods:{
            toggleDropdown() {
                this.isDropdownVisible = !this.isDropdownVisible;
            },
            closeDropdown(event) {
                if (!event.target.matches('.Dropdown-button') && !event.target.matches('.dropList > li')) {
                    this.isDropdownVisible = false;
                }
            }
        },
        mounted() {
            window.addEventListener('click', this.closeDropdown);
        },
    }
</script>

<template>
    <nav>
        <ul class="navbar" id="navBar">
            <li v-for="item in menu" :key="item[0]" >
                <button v-if="item.length > 1" class="Dropdown-button navbar__Drop__Button" @click="toggleDropdown">
                    {{ item[0] }}
                </button>
                <a v-else v-bind:href="link[item[0]]"><button >{{ item[0] }}</button></a>
                <ul v-if="item.length > 1" class="dropList navbar__Drop__List" v-show="isDropdownVisible">
                    <li v-for="(subItem, index) in item.slice(1)" :key="index">
                        <button>{{ subItem }}</button>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</template>

<style scoped lang="scss">
$fonts: Helvetica, sans-serif;
$backcolor: #606C5D;
$hovercolor: #263A29;

@mixin hovercolor($properties){
    :hover{
        background-color: $properties;
    }
}
@mixin buttonstyle(){
    width: 100%;
    color: white;
    margin-top: auto;
    background-color: $backcolor;
    border: none;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
}
.navbar {
    list-style-type: none;
    position: fixed;
    top: 0;
    width: 100%;
    margin-top: 0;
    display: grid;
    grid-template-columns: auto auto auto auto;
    grid-template-rows: auto auto;
    font-family: $fonts;
    background-color: $backcolor;
    padding: 0;
    @include hovercolor($hovercolor);
    li {
        background-color: $backcolor;
        margin-top: auto;
        height: 100%;
        text-align: center;
        button {
            @include buttonstyle();
        }
    }
    &__Drop {
        &__List {
            width: 100%;
            position: absolute;
            padding: 0;
            color: white;
            grid-column-start: 4;
            grid-template-rows: auto auto;
            background-color: $backcolor;
            list-style-type: none;
            li {
                height: 30px;
                color: white;
                @include hovercolor($hovercolor);
            }
        }
    }
}
</style>
