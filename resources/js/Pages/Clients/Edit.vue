<template>
    <breeze-authenticated-layout>
    <h1>Edit Client {{first_name}} {{last_name}}</h1>
    <div v-if="errorMessage" class="alert alert-danger" role="alert">
        {{ errorMessage }}
    </div>
    <form @submit.prevent="submit">
        <div class="form-group">
            <label for="firstName">First Name</label>
            <input id="firstName" v-model="client.first_name" type="text" class="form-control" aria-describedby="emailHelp" placeholder="Enter first name">
             <div v-if="errors.first_name" class="invalid-feedback" :style="styleObject">
                {{errors.first_name}}
            </div>
        </div>
        <div class="form-group">
            <label for="lastName">Last Name</label>
            <input v-model="client.last_name" type="textr" class="form-control" id="lastName" placeholder="Enter last name">
             <div v-if="errors.last_name" class="invalid-feedback" :style="styleObject">
                {{errors.last_name}}
            </div>
        </div>
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" v-model="client.email" class="form-control" id="email"  placeholder="Enter email">
            <div v-if="errors.email" class="invalid-feedback" :style="styleObject">
                {{errors.email}}
            </div>       
        </div>
        <div class="form-group">
            <label for="avatar">Picture</label>
            <input type="file" name="picture" class="form-control-file" id="avatar" @change="onFileChange">
            <img v-bind:src="imagePreview" width="100" height="100" v-show="showPreview"/>
            <div v-if="errors.avatar" class="invalid-feedback" :style="styleObject">
                {{errors.avatar}}
            </div> 
        </div>
       <button @click="submit" class="btn btn-primary">Submit</button>
    </form>

    </breeze-authenticated-layout>
</template>

<script>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated'

    export default {
        components: {
            BreezeAuthenticatedLayout,
        },

        data: function() {
            return {
                id: this.client.id,
                first_name: this.client.first_name,
                last_name: this.client.last_name,
                email: this.client.email,
                imagePreview : this.client.avatar,
                showPreview : true,
                picture:"",
                errorMessage:""
            }
        },
        props: {
            auth: Object,
            errors: Object,
            client: Object,
        },
        methods:{
            submit(){
                this.errorMessage = ""
                this.$inertia.put(this.route("clients.update", this.client.id),{
                    id:this.client.id,
                    first_name:this.client.first_name,
                    last_name:this.client.last_name,
                    email:this.client.email,
                    avatar:this.client.avatar,
                    picture:this.picture
                })
            },
            onFileChange(event){
                this.picture = event.target.files[0];

                /*
                Initialize a File Reader object
                */
                let reader  = new FileReader();

                /*
                Add an event listener to the reader that when the file
                has been loaded, we flag the show preview as true and set the
                image to be what was read from the reader.
                */
                reader.addEventListener("load", function () {
                    this.showPreview = true;
                    this.imagePreview = reader.result;
                }.bind(this), false);

                /*
                Check to see if the file is not empty.
                */
                if( this.picture ){
                    /*
                        Ensure the file is an image file.
                    */
                    if ( /\.(jpe?g|png|gif)$/i.test( this.picture.name ) ) {

                        console.log("here");
                        /*
                        Fire the readAsDataURL method which will read the file in and
                        upon completion fire a 'load' event which we will listen to and
                        display the image in the preview.
                        */
                        reader.readAsDataURL( this.picture );
                    }
                }
            }
        }
    }
</script>