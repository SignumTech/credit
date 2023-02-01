<template>
<div class="row px-5">
    <div class="col-md-12">
        <div class="bg-white rounded-1 shadow-sm p-3 mt-3">
            <div class="row">
                <div class="col-md-6">
                    <h4>
                        <strong>{{ client.name }}</strong> 
                    </h4>
                    <h6>
                        <strong>Client ID:</strong> {{ client.id }}
                    </h6>
                    <h6>
                        <strong>Client Secret: </strong><span class="fa fa-eye-slash" @click="showSecret()"></span>
                    </h6>
                    <h6>
                        <strong>Redirect URL: </strong><br>
                        {{ client.redirect }}
                    </h6>
                </div>
                <div class="col-md-6 align-self-center">
                    <button @click="initializeParameters()" v-if="!initialized" class="btn btn-primary btn-sm float-end rounded-1"><span class="fa fa-hourglass-start"></span> Initialize Parameters</button>
                </div>
            </div>

        </div>
    </div>
    <div v-if="initialized" class="col-md-6">
        <div class="bg-white rounded-1 shadow-sm p-3 mt-3">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="text-center"><strong>Credit Worthiness Parameters</strong></h5>
                </div>
                <div class="col-md-12 mt-3">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Parameter</th>
                                <th>Weight</th>
                                <th>Values</th>
                                <th><span @click="editWorthiness()" class="fa fa-edit"></span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>business_type</td>
                                <td>{{ worthiness.business_type.weight }}</td>
                                <td>
                                    <tr>
                                        <td>
                                           <h6>KIOSK : {{worthiness.business_type.values.KIOSK}}</h6> 
                                           <h6>OUTLET : {{worthiness.business_type.values.OUTLET}}</h6> 
                                           <h6>MINIMARKET : {{worthiness.business_type.values.MINIMARKET}}</h6> 
                                           <h6>SUPERMARKET : {{worthiness.business_type.values.SUPERMARKET}}</h6>
                                        </td>
                                    </tr>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>last_order_date</td>
                                <td>{{ worthiness.last_order_date.weight }}</td>
                                <td>
                                    <tr>
                                        <td>
                                           <h6>>3months since last ordered : {{worthiness.last_order_date.values.three_and_up}}</h6> 
                                           <h6>2 months since last ordered : {{worthiness.last_order_date.values.two}}</h6> 
                                           <h6>1 month since last ordered : {{worthiness.last_order_date.values.one}}</h6> 
                                           <h6>ordered within a month : {{worthiness.last_order_date.values.one_less}}</h6>
                                        </td>
                                    </tr>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>presale_estimation</td>
                                <td>{{ worthiness.presale_estimation.weight }}</td>
                                <td>
                                    <tr>
                                        <td>
                                           <h6>BAD : {{worthiness.presale_estimation.values.BAD}}</h6> 
                                           <h6>MEDIUM : {{worthiness.presale_estimation.values.MEDIUM}}</h6> 
                                           <h6>GOOD : {{worthiness.presale_estimation.values.GOOD}}</h6> 
                                           <h6>EXCELLENT : {{worthiness.presale_estimation.values.EXCELLENT}}</h6>
                                        </td>
                                    </tr>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                            <td>created_at</td>
                                <td>{{ worthiness.created_at.weight }}</td>
                                <td>
                                    <tr>
                                        <td>
                                           <h6>New (less than 6Months) : {{worthiness.created_at.values.new}}</h6> 
                                           <h6>6 Months : {{worthiness.created_at.values.six}}</h6> 
                                           <h6>Between 6 months and 1year : {{worthiness.created_at.values.six_to_twelve}}</h6> 
                                           <h6>More than 1 year : {{worthiness.created_at.values.one_and_up}}</h6>
                                        </td>
                                    </tr>
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <table class="table table-sm mt-2">
                        <thead>
                            <tr>
                                <th>Cutoff</th>
                                <th>Worthiness Max Score</th>
                                <th><span @click="editCutoff()" class="fa fa-edit float-end"></span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ parameters.worthiness_cutoff }}</td>
                                <td>{{ parameters.max_worthiness }}</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div v-if="initialized" class="col-md-6">
        <div class="bg-white rounded-1 shadow-sm p-3 mt-3">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="text-center"><strong>Credit Score Parameters</strong></h5>
                </div>
                <div class="col-md-12 mt-3">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Parameter</th>
                                <th>Weight</th>
                                <th>Values</th>
                                <th><span @click="editCreditScore()" class="fa fa-edit"></span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>payment_history</td>
                                <td>{{ credit_score.payment_history.weight }}</td>
                                <td>
                                    <tr>
                                        <td>
                                           <h6>NO_CREDIT : {{credit_score.payment_history.values.NO_CREDIT}}</h6> 
                                           <h6>PAID_ON_TIME : {{credit_score.payment_history.values.PAID_ON_TIME}}</h6> 
                                           <h6>PAID_LATE : {{credit_score.payment_history.values.PAID_LATE}}</h6> 
                                           <h6>DEFAULT : {{credit_score.payment_history.values.DEFAULT}}</h6>
                                        </td>
                                    </tr>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                            <td>credit_utilization</td>
                                <td>{{ credit_score.credit_utilization.weight }}</td>
                                <td>
                                    <tr>
                                        <td>
                                           <h6>NO_DEBT : {{credit_score.credit_utilization.values.NO_DEBT}}</h6> 
                                           <h6>HALF_PAID : {{credit_score.credit_utilization.values.HALF_PAID}}</h6> 
                                           <h6>UNPAID_BILL : {{credit_score.credit_utilization.values.UNPAID_BILL}}</h6> 
                                           <h6>EXCEED : {{credit_score.credit_utilization.values.EXCEED}}</h6>
                                        </td>
                                    </tr>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>item_type</td>
                                <td>{{ credit_score.item_type.weight }}</td>
                                <td>
                                    <tr>
                                        <td>
                                           <h6>CATEGORY_A : {{credit_score.item_type.values.CATEGORY_A}}</h6> 
                                           <h6>CATEGORY_B : {{credit_score.item_type.values.CATEGORY_B}}</h6> 
                                           <h6>CATEGORY_C : {{credit_score.item_type.values.CATEGORY_C}}</h6> 
                                        </td>
                                    </tr>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                            <td>transaction_history</td>
                                <td>{{ credit_score.transaction_history.weight }}</td>
                                <td>
                                    <tr>
                                        <td>
                                           <h6>less than 100,000 : {{credit_score.transaction_history.values.ONE_LESS}}</h6> 
                                           <h6>100,000 - 200,000 : {{credit_score.transaction_history.values.ONE_TO_TWO}}</h6> 
                                           <h6>200,000 - 300,000 : {{credit_score.transaction_history.values.TWO_TO_THREE}}</h6> 
                                           <h6>>300,000 : {{credit_score.transaction_history.values.THREE_ABOVE}}</h6>
                                        </td>
                                    </tr>
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>last_order_date</td>
                                <td>{{ credit_score.last_order_date.weight }}</td>
                                <td>
                                    <tr>
                                        <td>
                                           <h6>>3months since last ordered : {{credit_score.last_order_date.values.three_and_up}}</h6> 
                                           <h6>2 months since last ordered : {{credit_score.last_order_date.values.two}}</h6> 
                                           <h6>1 month since last ordered : {{credit_score.last_order_date.values.one}}</h6> 
                                           <h6>ordered within a month : {{credit_score.last_order_date.values.one_less}}</h6>
                                        </td>
                                    </tr>
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>    
</template>
<script>
import addModalVue from './addModal.vue'
import showSecretVue from './showSecret.vue'
import EditCreditScoreModal from './editCreditScoreModal.vue'
import editWorthinessModalVue from './editWorthinessModal.vue'
import editCutoffModalVue from './editCutoffModal.vue'
export default {
    data(){
        return{
            client:{},
            initialized:false,
            parameters:{},
            worthiness:{},
            credit_score:{}
        }
    },
    mounted(){
        this.getClient()
        this.getParameters()
    },
    methods:{
        showSecret(){
            this.$modal.show(
                showSecretVue,
                {secret:this.client},
                {height:'auto', width:'800px'}
            )
        },
        editCutoff(){
            this.$modal.show(
                editCutoffModalVue,
                {cutoff:this.parameters.worthiness_cutoff, max:this.parameters.max_worthiness, client_id:this.$route.params.id},
                {height:'auto',width:'300px'},
                {'closed':this.getParameters}
            )
        },
        editWorthiness(){
            this.$modal.show(
                editWorthinessModalVue,
                {worthiness:this.worthiness, client_id:this.$route.params.id},
                {height:'auto',width:'80%'},
                {'closed':this.getParameters}
            )
        },
        editCreditScore(){
            this.$modal.show(
                EditCreditScoreModal,
                {credit_score:this.credit_score, client_id:this.$route.params.id},
                {height:'auto',width:'90%'},
                {'closed':this.getParameters}
            )
        },
        async getClient(){
            await axios.get('/showClient/'+this.$route.params.id)
            .then( response =>{
                this.client = response.data
            })
        },
        async getParameters(){
            await axios.get('/getParameters/'+this.$route.params.id)
            .then( response =>{
                this.initialized = true
                this.parameters = response.data
                this.worthiness = JSON.parse(this.parameters.worthiness)
                this.credit_score = JSON.parse(this.parameters.credit_score)
                
            })
            .catch( error => {
                if(error.response.status == 422){
                    this.initialized = false
                }
            })
        },
        async initializeParameters(){
            await axios.put('/initializeParameters/'+this.$route.params.id)
            .then( response =>{
                this.initialized = true
                this.getParameters()
            })
        }
        
    }
}
</script>