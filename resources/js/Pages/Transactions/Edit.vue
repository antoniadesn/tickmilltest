<template>
    <breeze-authenticated-layout>
    <h1>Create Transaction</h1>

    <form @submit.prevent="submit">
        <div class="form-group">
            <label for="client">Client</label>
            <select  class="form-control selectpicker" v-model="transaction.client_id" >
                    <option v-for="client in clients" :key="client.id" v-bind:value="client.id">
                        {{client.first_name}} {{client.last_name}}
                    </option>
                </select>  
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Transaction Amount</label>
            <input class="form-control" v-model="transaction.amount" placeholder="Enter amount" @keypress="onlyForCurrency">
         </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Transaction Date</label>
            <input type="date" v-model="transaction.transaction_date" class="form-control" id="exampleInputEmail1"  placeholder="Enter transaction date">
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
                amount:this.transaction.amount,
                selectedClient: this.transaction.client_id,
                transation_date: this.transaction.transaction_date
            }
        },
        props: {
            auth: Object,
            errors: Object,
            clients:[],
            transaction: Object
        },
        methods:{
            submit(){
                this.$inertia.put(this.route("transactions.update", this.transaction.id),
                    {
                        amount: this.transaction.amount,
                        transaction_date: this.transaction.transaction_date,
                        client_id : this.transaction.client_id,
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