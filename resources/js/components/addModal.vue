<template>
    <form action="#" @submit.prevent="addClient">
        <div class="row px-4 pb-4 pt-3">
            <div class="col-md-12">
                <h4 class="text-center">Add Project</h4>
            </div>
            <div class="col-md-12 mt-3">
                <label for="">Project Name</label>
                <input required type="text" class="form-control" v-model="formData.name" placeholder="Project Name">
            </div>
            <div class="col-md-12 mt-3">
                <label for="">Redirect URL</label>
                <input required type="text" class="form-control" v-model="formData.redirect" placeholder="Redirect URL">
            </div>
            <div class="col-md-12 mt-3">
                <button type="submit" class="btn btn-primary form-control"><span class="fa fa-plus"></span> Add Project</button>
            </div>
            
        </div>
    </form>

</template>
<script>
export default {
    data(){
        return{
            formData:{
                name:null,
                redirect:null
            }
        }
    },
    methods:{
        async addClient(){
            await axios.post('/oauth/clients', this.formData)
            .then( response =>{
                this.$emit('close')
            })
        },
    }
}
</script>