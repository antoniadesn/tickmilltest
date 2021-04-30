<template>
    <breeze-authenticated-layout>
    <h1>Create Client</h1>

    <form @submit.prevent="submit">
        <div class="form-group">
            <label for="exampleInputEmail1">First Name</label>
            <input v-model="first_name" type="text" class="form-control" aria-describedby="emailHelp" placeholder="Enter first name">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Last Name</label>
            <input v-model="last_name" type="textr" class="form-control" id="exampleInputPassword1" placeholder="Enter last name">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" v-model="email" class="form-control" id="exampleInputEmail1"  placeholder="Enter email">
        </div>
        <div class="form-group">
            <label for="description">Picture</label>
            <input type="file" name="avatar" class="form-control-file" id="avatar" @change="onFileChange">
            <img v-bind:src="imagePreview" width="100" height="100" v-show="showPreview"/>
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
                first_name:"",
                last_name:"",
                email:"",
                avatar:"",
                imagePreview: null,
                showPreview: false,
            }
        },
        props: {
            auth: Object,
            errors: Object,
        },
        methods:{
            submit(){
                this.$inertia.post(this.route("clients.store"),
                    {
                        first_name: this.first_name,
                        last_name: this.last_name,
                        avatar:this.avatar,
                        email:this.email
                    }
                )
            },
            onFileChange(event){
                this.avatar = event.target.files[0];

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
                if( this.avatar ){
                    /*
                        Ensure the file is an image file.
                    */
                    if ( /\.(jpe?g|png|gif)$/i.test( this.avatar.name ) ) {

                        console.log("here");
                        /*
                        Fire the readAsDataURL method which will read the file in and
                        upon completion fire a 'load' event which we will listen to and
                        display the image in the preview.
                        */
                        reader.readAsDataURL( this.avatar );
                    }
                }
            }
        }
    }
</script>