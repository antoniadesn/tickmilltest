<template>
    <breeze-authenticated-layout>
    <h1>Create Transaction</h1>

    <form @submit.prevent="submit">
        <div class="form-group">
            <label for="client">Client</label>
            <select  class="form-control selectpicker" v-model="selectedClient" >
                <option v-for="client in clients" :key="client.id" v-bind:value="client.id">
                    {{client.first_name}} {{client.last_name}}
                </option>
            </select>  
            <div v-if="errors.client_id" class="invalid-feedback" :style="styleObject">
                {{errors.client_id}}
            </div> 
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Transaction Amount</label>
            <input class="form-control" v-model="amount" placeholder="Enter amount" @keypress="onlyForCurrency">
             <div v-if="errors.amount" class="invalid-feedback" :style="styleObject">
                {{errors.amount}}
            </div>
         </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Transaction Date</label>
            <input type="date" v-model="transaction_date" class="form-control" id="exampleInputEmail1"  placeholder="Enter transaction date">
             <div v-if="errors.transaction_amount" class="invalid-feedback" :style="styleObject">
                {{errors.transaction_amount}}
            </div>
        </div>
        
    </form>
        <button @click="submit" class="btn btn-primary">Submit</button>
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
                amount:0,
                imagePreview: null,
                showPreview: false,
                selectedClient: Object,
                transation_date: Date
            }
        },
        props: {
            auth: Object,
            errors: Object,
            clients:[]
        },
        methods:{
            submit(){
                this.$inertia.post(this.route("transactions.store"),
                    {
                        amount: this.amount,
                        transaction_date: this.transaction_date,
                        client_id : this.selectedClient,
                    }
                )
            },
            onlyForCurrency ($event) {
                // console.log($event.keyCode); //keyCodes value
                let keyCode = ($event.keyCode ? $event.keyCode : $event.which);

                // only allow number and one dot
                if ((keyCode < 48 || keyCode > 57) && (keyCode !== 46 || this.price.indexOf('.') != -1)) { // 46 is dot
                $event.preventDefault();
                }

                // restrict to 2 decimal places
                if(this.price!=null && this.price.indexOf(".")>-1 && (this.price.split('.')[1].length > 1)){
                $event.preventDefault();
                }
            }
        }
    }
</script>