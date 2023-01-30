<template>
<div>
    <div class="row p-0" style="background-image: url('/storage/settings/credit.png');background-position:top;background-size: cover; background-repeat: no-repeat;min-height: 50vh;"> 
        <div class="container-fluid m-0 d-flex align-items-center" style="background-color: #011b48b8">
            <div class="row m-5">
                <div class="container">
                    <div class="col-md-4">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mb-5" style="margin-top:-15vh">
        <div class="row">
            <div class="col-md-4 mt-4" style="cursor:pointer">
                <div @click="addModal()" class="bg-white rounded-2 shadow-sm " style="height:25vh">
                    <div class="row" style="height:100%">
                        <div class="col-md-12 text-center align-self-center">
                            <span class="fa fa-plus fs-3"></span>
                            <h5>Add Project</h5>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div v-for="client,index in clients" :key="index" class="col-md-4 mt-4 ">
                <div class="bg-white rounded-2 shadow-sm p-3" style="height:25vh">
                    <h4>
                        <strong>{{ client.name }}</strong> 
                        <router-link :to="`/app/`+client.id"><span class="fa fa-external-link-alt float-end fs-6"></span></router-link>
                    </h4>
                    <h6>
                        <strong>Client ID:</strong> {{ client.id }}
                    </h6>
                    <h6>
                        <strong>Client Secret: </strong><span class="fa fa-eye-slash" @click="showSecret(client)"></span>
                    </h6>
                    <h6>
                        <strong>Redirect URL: </strong><br>
                        {{ client.redirect }}
                    </h6>
                </div>
            </div>
            
        </div>
    </div>   
</div>
</template>
<script>
import addModalVue from './addModal.vue'
import showSecretVue from './showSecret.vue'
    export default {
        data(){
            return{
                clients:{},
                user:{}
            }
        },
        beforeMount(){
            this.getUser();
        },
        mounted() {
            this.getClients()
        },
        methods:{
            showSecret(secret){
                this.$modal.show(
                    showSecretVue,
                    {secret:secret},
                    {height:'auto', width:'800px'}
                )
            },
            async logout(){
                await axios.post('/logout')
                .then( response =>{
                    window.location.replace('/')
                })
            },
            async getUser(){
                await axios.get('/user')
                .then( response =>{
                    this.user = response.data
                })
                .catch( error =>{
                    if(error.response.status == 401){
                        window.location.replace('/login')
                    }
                })
            },
            async getClients(){
                await axios.get('/getClients')
                .then( response =>{
                    this.clients = response.data
                })
            },
            addModal(){
                this.$modal.show(
                    addModalVue,
                    {},
                    {height:'auto',width:'500px'},
                    {'closed':this.getClients}
                )
            }
        }
    }
</script>