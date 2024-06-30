<script>
    export default {
        name: 'Impressum',
    }
</script>

<template>
    <div class="impressum-container">
        <p><strong>Impressum</strong></p>
        <p>Anbieter:<br />Max Mustermann<br />Musterstraße 1<br />80999 München</p>
        <p>Kontakt:<br />Telefon: 089/1234567-8<br />Telefax: 089/1234567-9<br />E-Mail: mail@mustermann.de<br />Website: www.mustermann.de</p>
        <p> </p>
        <p>Bei redaktionellen Inhalten:</p>
        <p>Verantwortlich nach § 55 Abs.2 RStV<br />Moritz Schreiberling<br />Musterstraße 2<br />80999 München</p>
    </div>
</template>

<style scoped lang="scss">
    .impressum-container {
        $backcolor: #606C5D;
        width: 100%;
        text-align: center;
        background-color: $backcolor;
        color: white;
    }
</style>
