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
    <h1>{{ title }}</h1>
    <form @submit.prevent="submitForm"> <!-- prevent default form submission-->
        <div>
            <label for="name">Name</label>
            <input type="text" id="name" v-model="article.name" placeholder="Name" />
        </div>
        <div>
            <label for="price">Price</label>
            <input type="number" id="price" v-model="article.price" placeholder="Price" />
        </div>
        <div>
            <label for="description">Description</label>
            <textarea id="description" v-model="article.description" placeholder="Description" />
        </div>
        <div>
            <label for="images">Images</label>
            <input type="file" id="image" ref="image" accept="image/*" @change="handleFileUpload">
        </div>
        <button type="submit" :disabled="isLoading">Submit</button>
    </form>

</template>

<style scoped>

</style>
