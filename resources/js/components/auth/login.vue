<template>
<div class="row m-0" style="height: 100vh">
    <div class="col-md-4"></div>
    <div class="col-md-4 mt-5">
        <div class="rounded-circle shadow-sm m-auto d-flex align-items-center overflow-hidden" style="width: 100px; height: 100px;">
            <img class="img img-fluid d-block m-auto" src="/storage/settings/logo.jpg" style="width:200px; height: auto">
        </div>
        <div class="bg-white shadow-sm rounded-1 px-4 py-5 mt-3">
            <form action="#" @submit.prevent="submit">
                <div>
                    <div class="input-group">
                        <span class="input-group-text bg-brand text-white"><span class="fa fa-envelope"></span></span>
                        
                        <input class="form-control form-control-auth" required placeholder="E-mail" name="email" id="email" v-model="form.email">
                    </div>
                </div>
                <div class="mt-5">
                    <div class="input-group mb-4">
                        <span class="input-group-text bg-brand text-white"><span class="fa fa-lock"></span></span>
                        <input class="form-control form-control-auth" required placeholder="Password" type="password" name="password" id="password" v-model="form.password">
                    </div>
                </div>
                <div v-if="loading" class="d-flex justify-content-center mt-5">
                    <bounce-loader  :color="`#011b48`" :size="size"></bounce-loader> 
                </div>
                <div class="mt-3" v-if="valErrors">
                    <h6 class="text-center text-danger"><strong>The credentials do not match our records!</strong></h6>
                  </div>
                <div class="mt-5">
                    <button v-if="!loading" type="submit" class="form-control form-control-auth-btn btn btn-primary">
                        <h5 class="m-0"><strong>LOG IN</strong></h5>
                    </button>
                    
                </div>
            </form>            
        </div>
              
        </div>
        <div class="col-md-4"></div>
</div>    
</template>
<script>
import PulseLoader from 'vue-spinner/src/PulseLoader.vue'
import BounceLoader from 'vue-spinner/src/BounceLoader.vue'
import { mapActions } from 'vuex'

export default {
    name: 'SignIn',
    components: {
        PulseLoader,
        BounceLoader
    },
    data () {
    return {
        size: '40px',
        margin: 'auto',
        loading: false,
        valErrors:false,
        phone_no:null,
        form: {
            email: null,
            password: null,
        },
    }
    },

    methods: {
    ...mapActions({
        signIn: 'auth/signIn'
    }),
    async submit () {
        this.loading = true
        await this.signIn(this.form)
        .then( response =>{
            window.location.replace('/')
            this.loading = false
        })
        .catch( error =>{
            this.valErrors = true
        })
        this.loading = false
        
    }
    }
}
</script>