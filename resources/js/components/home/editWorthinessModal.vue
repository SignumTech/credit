<template>
    <form action="#" @submit.prevent="updateWorthiness">
        <div class="row p-3">
            <div class="col-md-3 border-end pb-3">
                <h5>business_type</h5>
                <div class="row">
                    <div class="col-md-12 border-bottom pb-2">
                        <label for="">Weight</label>
                        <input required v-model="formData.business_type.weight" type="number" step="0.01" class="form-control">
                    </div>
                    <div class="col-md-12 mt-2">
                        <h6>Values</h6>
                    </div>
                    <div class="col-md-12 mt-1">
                        <label for="">KIOSK</label>
                        <input required v-model="formData.business_type.values.KIOSK" type="number" step="0.5" class="form-control">
                    </div>
                    <div class="col-md-12 mt-1">
                        <label for="">OUTLET</label>
                        <input required v-model="formData.business_type.values.OUTLET" type="number" step="0.5" class="form-control">
                    </div>
                    <div class="col-md-12 mt-1">
                        <label for="">MINIMARKET</label>
                        <input required v-model="formData.business_type.values.MINIMARKET" type="number" step="0.5" class="form-control">
                    </div>
                    <div class="col-md-12 mt-1">
                        <label for="">SUPERMARKET</label>
                        <input required v-model="formData.business_type.values.SUPERMARKET" type="number" step="0.5" class="form-control">
                    </div>
                </div>
            </div>
            <div class="col-md-3 border-end pb-3">
                <h5>last_order_date</h5>
                <div class="row">
                    <div class="col-md-12 border-bottom pb-2">
                        <label for="">Weight</label>
                        <input required v-model="formData.last_order_date.weight" type="number" step="0.01" class="form-control">
                    </div>
                    <div class="col-md-12 mt-2">
                        <h6>Values</h6>
                    </div>
                    <div class="col-md-12 mt-1">
                        <label for="">>3months since last ordered</label>
                        <input required v-model="formData.last_order_date.values.three_and_up" type="number" step="0.5" class="form-control">
                    </div>
                    <div class="col-md-12 mt-1">
                        <label for="">2 months since last ordered</label>
                        <input required v-model="formData.last_order_date.values.two" type="number" step="0.5" class="form-control">
                    </div>
                    <div class="col-md-12 mt-1">
                        <label for="">1 month since last ordered </label>
                        <input required v-model="formData.last_order_date.values.one" type="number" step="0.5" class="form-control">
                    </div>
                    <div class="col-md-12 mt-1">
                        <label for="">ordered within a month</label>
                        <input required v-model="formData.last_order_date.values.one_less" type="number" step="0.5" class="form-control">
                    </div>
                </div>
            </div>
            <div class="col-md-3 border-end pb-3">
                <h5>presale_estimation</h5>
                <div class="row">
                    <div class="col-md-12 border-bottom pb-2">
                        <label for="">Weight</label>
                        <input required v-model="formData.presale_estimation.weight" type="number" step="0.01" class="form-control">
                    </div>
                    <div class="col-md-12 mt-2">
                        <h6>Values</h6>
                    </div>
                    <div class="col-md-12 mt-1">
                        <label for="">BAD</label>
                        <input required v-model="formData.presale_estimation.values.BAD" type="number" step="0.5" class="form-control">
                    </div>
                    <div class="col-md-12 mt-1">
                        <label for="">MEDIUM</label>
                        <input required v-model="formData.presale_estimation.values.MEDIUM" type="number" step="0.5" class="form-control">
                    </div>
                    <div class="col-md-12 mt-1">
                        <label for="">GOOD </label>
                        <input required v-model="formData.presale_estimation.values.GOOD" type="number" step="0.5" class="form-control">
                    </div>
                    <div class="col-md-12 mt-1">
                        <label for="">EXCELLENT</label>
                        <input required v-model="formData.presale_estimation.values.EXCELLENT" type="number" step="0.5" class="form-control">
                    </div>
                </div>
            </div>
            <div class="col-md-3 border-end pb-3">
                <h5>created_at</h5>
                <div class="row">
                    <div class="col-md-12 border-bottom pb-2">
                        <label for="">Weight</label>
                        <input required v-model="formData.created_at.weight" type="number" step="0.01" class="form-control">
                    </div>
                    <div class="col-md-12 mt-2">
                        <h6>Values</h6>
                    </div>
                    <div class="col-md-12 mt-1">
                        <label for="">New (less than 6Months)</label>
                        <input required v-model="formData.created_at.values.new" type="number" step="0.5" class="form-control">
                    </div>
                    <div class="col-md-12 mt-1">
                        <label for="">6 Months</label>
                        <input required v-model="formData.created_at.values.six" type="number" step="0.5" class="form-control">
                    </div>
                    <div class="col-md-12 mt-1">
                        <label for="">Between 6 months and 1year </label>
                        <input required v-model="formData.created_at.values.six_to_twelve" type="number" step="0.5" class="form-control">
                    </div>
                    <div class="col-md-12 mt-1">
                        <label for="">More than 1 year</label>
                        <input required v-model="formData.created_at.values.one_and_up" type="number" step="0.5" class="form-control">
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-3">
                <button type="submit" class="btn btn-primary rounded-1 btn-sm float-end">Update Parameters</button>
            </div>
        </div>    
    </form>

</template>
<script>
export default {
    props:["worthiness", "client_id"],
    data(){
        return{
            formData:{}
        }
    },
    mounted(){
        this.formData = this.worthiness
    },
    methods:{
        async updateWorthiness(){
            await axios.put('/updateWorthiness/'+this.client_id, {data:this.formData})
            .then( response =>{
                this.$emit('close')
            })
        }
    }
}
</script>