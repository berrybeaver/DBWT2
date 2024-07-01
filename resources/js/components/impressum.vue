<script>
    export default {
        name: 'Impressum',
    }
</script>

<template>
    <div class="impressum">
        <p class="impressum__container"><strong>Impressum</strong></p>
        <p class="impressum__container">Anbieter:<br />Max Mustermann<br />Musterstraße 1<br />80999 München</p>
        <p class="impressum__container">Kontakt:<br />Telefon: 089/1234567-8<br />Telefax: 089/1234567-9<br />E-Mail: mail@mustermann.de<br />Website: www.mustermann.de</p>
        <p class="impressum__container"> </p>
        <p class="impressum__container">Bei redaktionellen Inhalten:</p>
        <p class="impressum__container">Verantwortlich nach § 55 Abs.2 RStV<br />Moritz Schreiberling<br />Musterstraße 2<br />80999 München</p>
    </div>
</template>

<style scoped lang="scss">
    .impressum{
        $backcolor: #606C5D;
        background-color: $backcolor;
        &__container {
            width: 100%;
            color: white;
            text-align: center;
        }

    }
</style>
