<template>
  <breeze-authenticated-layout>

      <template #header>
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              Clients
          </h2>
      </template>

      <div class="py-12">
          <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
              <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <button type="button" class="float-right btn btn-primary" @click="addRecord()" >
                    Create Client
                </button>
                <table style="margin-top:50px" class="table table-stripped">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">First Name</th>
                      <th scope="col">Last Name</th>
                      <th scope="col">Email</th>
                      <th class="text-center" align="center" scope="col">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(client, index) in clients" :key="client.id">
                      <th scope="row">{{ index + 1 }}</th>
                      <td>{{ client.first_name }}</td>
                      <td>{{ client.last_name}}</td>
                      <td>{{ client.email }}</td>
                      <td align="center">
                <a :href="route('clients.edit',client.id)" class="text-primary"><i class="fa fa-fw fa-edit"></i> Edit</a> | 
                <a href="" class="text-danger" @click="deleteItem(client.id, index);"><i class="fa fa-fw fa-trash"></i> Delete</a>
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
            clients:[]
        },
       
        methods:{
            addRecord(){
                this.$inertia.visit(this.route("clients.create"));
            },
            deleteItem(clientId, index) {
            if (confirm("Are you sure you want to delete this client?")) {
                this.clients.splice(index, 1);
                this.$inertia.delete(this.route("clients.destroy", clientId));
                
            }
        }
        }
    }
</script>
