<template>
    <div class="row p-4">
        <div class="col-md-12">
            <h5>{{secret.name}} Secret <span @click="$emit('close')" class="float-end fa fa-times"></span></h5>
            <h6 class="bg-light p-2 rounded-1">{{ secret.secret }}</h6>
        </div>
    </div>
</template>
<script>
export default {
    props:['secret']
}
</script>