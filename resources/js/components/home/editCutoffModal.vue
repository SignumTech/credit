<template>
    <form action="#" @submit.prevent="updateCutoff">
        <div class="row p-3">
            <div class="col-md-12">
                <label for="">Credit Worthiness Cutoff</label>
                <input required v-model="formData.cutoff" type="number" step="0.01" :max="max" class="form-control" placeholder="cutoff">
            </div>
            <div class="col-md-12 mt-3">
                <button type="submit" class="btn btn-primary btn-sm rounded-1 form-control">Update</button>
            </div>
        </div>
    </form>
</template>
<script>
export default {
    props:['cutoff', 'max', 'client_id'],
    data(){
        return{
            formData:{
                cutoff:null
            }
        }
    },
    mounted(){
        this.formData.cutoff = this.cutoff
    },
    methods:{
        async updateCutoff(){
            await axios.put('/updateCutoff/'+this.client_id, this.formData)
            .then( response =>{
                this.$emit('close')
            })
        }
    }
}
</script>