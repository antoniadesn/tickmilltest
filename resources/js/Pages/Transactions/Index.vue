<template>
  <breeze-authenticated-layout>

      <template #header>
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              Transactions
          </h2>
      </template>

      <div class="py-12">
          <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
              <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <button type="button" class="float-right btn btn-primary" @click="addRecord()" >
                    Create Transaction
                </button>
                <table style="margin-top:50px" class="table table-stripped">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Client</th>
                      <th scope="col">Transaction Date</th>
                      <th scope="col">Amount</th>
                      <th class="text-center" align="center" scope="col">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(transaction, index) in transactions" :key="transaction.id">
                      <th scope="row">{{ index + 1 }}</th>
                      <td>{{ transaction.client_name }}</td>
                      <td>{{ transaction.transaction_date}}</td>
                      <td>{{ transaction.amount }}</td>
                      <td align="center">
                <a :href="route('transactions.edit',transaction.id)" class="text-primary"><i class="fa fa-fw fa-edit"></i> Edit</a> | 
                <a href="" class="text-danger" @click="deleteItem(transaction.id, index);"><i class="fa fa-fw fa-trash"></i> Delete</a>
            </td>
                    </tr>
                  </tbody>
                </table>
              </div>
          </div>
      </div>
  </breeze-authenticated-layout>
</template>

<script>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated'

    export default {
        components: {
            BreezeAuthenticatedLayout,
        },

        props: {
            auth: Object,
            errors: Object,
            transactions:[]
        },
       
        methods:{
            addRecord(){
                this.$inertia.visit(this.route("transactions.create"));
            },
            deleteItem(transactionId, index) {
            if (confirm("Are you sure you want to delete this transaction?")) {
                  this.transactions.splice(index, 1);
                this.$inertia.delete(this.route("transactions.destroy", transactionId));
            }
        }
        }
    }
</script>
