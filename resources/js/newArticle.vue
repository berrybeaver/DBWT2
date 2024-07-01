<script>
    export default {
        data(){
            return{
                title: 'Create new article',
                article:{
                    name: '',
                    price: '',
                    description: '',
                    file: null
                },
                isLoading: false
            }
        },mounted() {

        },
        methods:{
            handleFileUpload(event){
                this.article.file = event.target.files[0]; //save file in article
            },
            async submitForm(){
                this.isLoading = true;
                let formData = new FormData();
                formData.append('name', this.article.name);
                formData.append('price', this.article.price);
                formData.append('description', this.article.description);
                if(this.article.file){formData.append('image', this.article.file);}

                try{
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', '/api/articles', true);
                    xhr.onload = function (){
                        if(xhr.status === 200){
                            const response = JSON.parse(xhr.responseText);
                            if(response.id){
                                window.alert('Article created with ID: ' + response.id);
                            } else{
                                window.alert('Error: unexpected response from the server');
                            }
                        }else{
                            window.alert('Error: ' + xhr.responseText);
                        }
                    };
                    xhr.onerror = function() {
                        displayMessage('Fehler: Die Anfrage konnte nicht verarbeitet werden.');
                    };
                    xhr.send(formData);

                    //clear inputs
                    this.article ={
                        name: '',
                        price: '',
                        description: '',
                        file: null
                    }
                } catch(error){
                    console.error(error)
                }
            },

        }

    }
</script>

<template>
    <h1 style="text-align: center;">{{ title }}</h1>
    <form class="form" @submit.prevent="submitForm">
        <div class="form__group">
            <label for="name" class="form__label">Name</label>
            <input type="text" id="name" class="form__input" v-model="article.name" placeholder="Name" />
        </div>
        <div class="form__group">
            <label for="price" class="form__label">Price</label>
            <input type="number" id="price" class="form__input" v-model="article.price" placeholder="Price" />
        </div>
        <div class="form__group">
            <label for="description" class="form__label">Description</label>
            <textarea id="description" class="form__textarea" v-model="article.description" placeholder="Description"></textarea>
        </div>
        <div class="form__group">
            <label for="images" class="form__label">Images</label>
            <input type="file" id="image" class="form__file-input" ref="image" accept="image/*" @change="handleFileUpload">
        </div>
        <button type="submit" class="form__button" :disabled="isLoading">Submit</button>
    </form>


</template>

<style scoped lang="scss">
// Variables
$primary-color: #3498db;
$secondary-color: #2ecc71;
$error-color: #e74c3c;
$input-border-color: #ccc;
$input-focus-border-color: $primary-color;
$button-bg-color: $primary-color;
$button-hover-bg-color: darken($primary-color, 10%);
$button-disabled-bg-color: lighten($primary-color, 30%);
$font-stack: 'Helvetica, Arial, sans-serif';
$border-radius: 4px;
$form-bg-color: #f9f9f9;

// Mixins
@mixin transition($property, $duration) {
    transition: $property $duration ease-in-out;
}

@mixin input-style {
    width: 100%;
    padding: 10px;
    border: 1px solid $input-border-color;
    border-radius: $border-radius;
    font-family: $font-stack;
    @include transition(border-color, 0.3s);

    &:focus {
        border-color: $input-focus-border-color;
        outline: none;
    }
}

// Functions
@function px-to-rem($px) {
    @return $px / 16 * 1rem;
}

// Inheritance
%hidden {
    display: none;
}

// Styling using Sass features
.form {
    background-color: $form-bg-color;
    padding: 20px;
    border-radius: $border-radius;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    max-width: 600px;
    margin: 0 auto;

    &__group {
        margin-bottom: 15px;
    }

    &__label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    &__input,
    &__textarea,
    &__file-input {
        @include input-style;
    }

    &__textarea {
        resize: vertical;
    }

    &__button {
        background-color: $button-bg-color;
        color: #fff;
        border: none;
        border-radius: $border-radius;
        padding: 10px 20px;
        font-family: $font-stack;
        cursor: pointer;
        @include transition(background-color, 0.3s);

        &:hover:not(:disabled) {
            background-color: $button-hover-bg-color;
        }

        &:disabled {
            background-color: $button-disabled-bg-color;
            cursor: not-allowed;
        }
    }
}

</style>
