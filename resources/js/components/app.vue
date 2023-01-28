<template>
    <div class="container-fluid">
        <div class="row">
            <nav v-if="authenticated" class="navbar navbar-expand-lg px-5 navbar-light bg-light" style="background-color: #011b48b8 !important; border: 0px !important">
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
            <router-view></router-view>
        </div>
    </div>
</template>
<script>
  export default {
    data(){
      return{
        authenticated:false,
        permissions:{}
      }
    },
    mounted(){
      
      this.authenticated = this.$store.state.auth.authenticated
      
    },
    computed: {
      togggle(){
          this.authenticated = this.$store.state.auth.authenticated; 
      },
      
    },
    methods:{
      logout(){
          axios.post("logout").then(response => { 
          window.location.replace("/home");
          })
          .catch(error => {
          
          });
      },
    }
  }
</script>
