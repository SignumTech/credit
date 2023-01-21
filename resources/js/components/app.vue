<template>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Dropdown
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
                </li>
                <li class="nav-item">
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </li>
            </ul>
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
            </div>
        </div>
        </nav>     
        <div class="row mt-3">
            <div class="col-md-12">
                <h4>Here are a list of your clients</h4>
                <div v-for="client,index in clients" :key="index">
                    <h5>
                        Client Name: {{ client.name }}
                    </h5>
                    <h5>
                        Client ID: {{ client.id }}
                    </h5>
                    <h5>
                        Client Secret: {{ client.secret }}
                    </h5>
                    <h5>
                        Redirect URL: {{ client.redirect }}
                    </h5>
                </div>

                
            </div>
            <form action="#" @submit.prevent="addClient">
                <div class="col-md-3 mt-3">
                    <input type="text" class="form-control" v-model="formData.name" placeholder="App Name">
                </div>
                <div class="col-md-3 mt-3">
                    <input type="text" class="form-control" v-model="formData.redirect" placeholder="Redirect URL">
                </div>
                <div class="col-md-3 mt-3">
                    <button type="submit" class="btn btn-primary form-control">Add Client</button>
                </div>
            </form>

        </div>   
    </div>

</template>

<script>
    export default {
        data(){
            return{
                clients:{},
                formData:{
                    name:null,
                    redirect:null
                }
            }
        },
        mounted() {
            this.getClients()
        },
        methods:{
            async addClient(){
                await axios.post('/oauth/clients', this.formData)
                .then( response =>{
                    this.getClients()
                })
            },
            async getClients(){
                await axios.get('/getClients')
                .then( response =>{
                    this.clients = response.data
                })
            }
        }
    }
</script>
