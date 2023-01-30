<template>
    <form action="#" @submit.prevent="updatecredit_score">
        <div class="row p-3">
            <div class="col border-end pb-3">
                <h5>payment_history</h5>
                <div class="row">
                    <div class="col-md-12 border-bottom pb-2">
                        <label for="">Weight</label>
                        <input required v-model="formData.payment_history.weight" type="number" step="0.01" class="form-control">
                    </div>
                    <div class="col-md-12 mt-2">
                        <h6>Values</h6>
                    </div>
                    <div class="col-md-12 mt-1">
                        <label for="">NO_CREDIT</label>
                        <input required v-model="formData.payment_history.values.NO_CREDIT" type="number" step="0.5" class="form-control">
                    </div>
                    <div class="col-md-12 mt-1">
                        <label for="">PAID_ON_TIME</label>
                        <input required v-model="formData.payment_history.values.PAID_ON_TIME" type="number" step="0.5" class="form-control">
                    </div>
                    <div class="col-md-12 mt-1">
                        <label for="">PAID_LATE</label>
                        <input required v-model="formData.payment_history.values.PAID_LATE" type="number" step="0.5" class="form-control">
                    </div>
                    <div class="col-md-12 mt-1">
                        <label for="">DEFAULT</label>
                        <input required v-model="formData.payment_history.values.DEFAULT" type="number" step="0.5" class="form-control">
                    </div>
                </div>
            </div>
            <div class="col border-end pb-3">
                <h5>credit_utilization</h5>
                <div class="row">
                    <div class="col-md-12 border-bottom pb-2">
                        <label for="">Weight</label>
                        <input required v-model="formData.credit_utilization.weight" type="number" step="0.01" class="form-control">
                    </div>
                    <div class="col-md-12 mt-2">
                        <h6>Values</h6>
                    </div>
                    <div class="col-md-12 mt-1">
                        <label for="">NO_DEBT</label>
                        <input required v-model="formData.credit_utilization.values.NO_DEBT" type="number" step="0.5" class="form-control">
                    </div>
                    <div class="col-md-12 mt-1">
                        <label for="">HALF_PAID</label>
                        <input required v-model="formData.credit_utilization.values.HALF_PAID" type="number" step="0.5" class="form-control">
                    </div>
                    <div class="col-md-12 mt-1">
                        <label for="">UNPAID_BILL</label>
                        <input required v-model="formData.credit_utilization.values.UNPAID_BILL" type="number" step="0.5" class="form-control">
                    </div>
                    <div class="col-md-12 mt-1">
                        <label for="">EXCEED</label>
                        <input required v-model="formData.credit_utilization.values.EXCEED" type="number" step="0.5" class="form-control">
                    </div>
                </div>
            </div>
            <div class="col border-end pb-3">
                <h5>item_type</h5>
                <div class="row">
                    <div class="col-md-12 border-bottom pb-2">
                        <label for="">Weight</label>
                        <input required v-model="formData.item_type.weight" type="number" step="0.01" class="form-control">
                    </div>
                    <div class="col-md-12 mt-2">
                        <h6>Values</h6>
                    </div>
                    <div class="col-md-12 mt-1">
                        <label for="">CATEGORY_A</label>
                        <input required v-model="formData.item_type.values.CATEGORY_A" type="number" step="0.5" class="form-control">
                    </div>
                    <div class="col-md-12 mt-1">
                        <label for="">CATEGORY_B</label>
                        <input required v-model="formData.item_type.values.CATEGORY_B" type="number" step="0.5" class="form-control">
                    </div>
                    <div class="col-md-12 mt-1">
                        <label for="">CATEGORY_C</label>
                        <input required v-model="formData.item_type.values.CATEGORY_C" type="number" step="0.5" class="form-control">
                    </div>
                </div>
            </div>
            <div class="col border-end pb-3">
                <h5>transaction_history</h5>
                <div class="row">
                    <div class="col-md-12 border-bottom pb-2">
                        <label for="">Weight</label>
                        <input required v-model="formData.transaction_history.weight" type="number" step="0.01" class="form-control">
                    </div>
                    <div class="col-md-12 mt-2">
                        <h6>Values</h6>
                    </div>
                    <div class="col-md-12 mt-1">
                        <label for="">less than 100,000</label>
                        <input required v-model="formData.transaction_history.values.ONE_LESS" type="number" step="0.5" class="form-control">
                    </div>
                    <div class="col-md-12 mt-1">
                        <label for="">100,000 - 200,000</label>
                        <input required v-model="formData.transaction_history.values.ONE_TO_TWO" type="number" step="0.5" class="form-control">
                    </div>
                    <div class="col-md-12 mt-1">
                        <label for="">200,000 - 300,000 </label>
                        <input required v-model="formData.transaction_history.values.TWO_TO_THREE" type="number" step="0.5" class="form-control">
                    </div>
                    <div class="col-md-12 mt-1">
                        <label for="">>300,000</label>
                        <input required v-model="formData.transaction_history.values.THREE_ABOVE" type="number" step="0.5" class="form-control">
                    </div>
                </div>
            </div>
            <div class="col border-end pb-3">
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
            <div class="col-md-12 mt-3">
                <button type="submit" class="btn btn-primary rounded-1 btn-sm float-end">Update Parameters</button>
            </div>
        </div>    
    </form>

</template>
<script>
export default {
    props:["credit_score", "client_id"],
    data(){
        return{
            formData:{}
        }
    },
    mounted(){
        this.formData = this.credit_score
    },
    methods:{
        async updatecredit_score(){
            await axios.put('/updateCreditScore/'+this.client_id, {data:this.formData})
            .then( response =>{
                this.$emit('close')
            })
        }
    }
}
</script>