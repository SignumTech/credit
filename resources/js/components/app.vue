<template>
    <div class="container-fluid">
        <div class="row">
            <nav class="navbar navbar-expand-lg px-5 navbar-light bg-light" style="background-color: #011b48b8 !important; border: 0px !important">
                <div class="container-fluid">
                    <a class="navbar-brand text-white" href="#"><strong>Buy2Go Credit</strong></a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item px-3">
                                <router-link class="a-admin text-white" to="/profile">
                                    <span class="fa fa-user-cog pr-2" style="font-size: 20px"></span><strong> {{ user.name }}</strong>
                                </router-link>
                            </li>
                            <li class="nav-item px-3">
                                <a @click="logout()" class="text-white" style="cursor:pointer">
                                <span class="fa fa-power-off" style="font-size: 20px"></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>   
        </div>
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
        <div class="container" style="margin-top:-15vh">
            <div class="row">
                <div class="col-md-4 mt-2" style="cursor:pointer">
                    <div @click="addModal()" class="bg-white rounded-2 shadow-sm " style="height:25vh">
                        <div class="row" style="height:100%">
                            <div class="col-md-12 text-center align-self-center">
                                <span class="fa fa-plus fs-3"></span>
                                <h5>Add Project</h5>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div v-for="client,index in clients" :key="index" class="col-md-4 mt-2 ">
                    <div class="bg-white rounded-2 shadow-sm p-3" style="height:25vh">
                        <h4>
                           <strong>{{ client.name }}</strong> 
                        </h4>
                        <h6>
                            Client ID: {{ client.id }}
                        </h6>
                    <h6>
                        Client Secret: {{ client.secret }}
                    </h6>
                    <h6>
                        Redirect URL: {{ client.redirect }}
                    </h6>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

</template>

<script>
import addModalVue from './addModal.vue'
    export default {
        data(){
            return{
                clients:{},
                user:{}
            }
        },
        mounted() {
            this.getClients()
            this.getUser()
        },
        methods:{
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
