<script>
    import impressum from "./impressum.vue";
    export default {
        components: {impressum},
        data(){
            return{
                impressumVisible: false,
            };
        },
        methods: {
            showImpressum() {
                this.impressumVisible = !this.impressumVisible;
            }
        },
    }
</script>

<template>
    <div class="footer">
        <a @click="showImpressum">Impressum</a>
        <impressum v-if="impressumVisible" />
    </div>
</template>

<style scoped lang="scss">
$fonts: Helvetica, sans-serif;
$backcolor: #606C5D;
$hovercolor: #263A29;

.footer{
    list-style-type: none;
    top: 0;
    width: 100%;
    margin-top: 0;
    display: grid;
    font-family: $fonts;
    background-color: $backcolor;
    padding: 0;
    color: white;
    text-align: center;
}
</style>
