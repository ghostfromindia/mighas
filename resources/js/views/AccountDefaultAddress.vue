<template>
    <div class="dashboard__address card address-card address-card--featured" v-if="address">
        <user-address :address="address.address" 
        :default="address.is_default" 
        :type="address.type" 
        :full_name="address.full_name" 
        :phone="address.phone"
        :from="from"></user-address>
    </div>
    <div v-else class="dashboard__address">
        <div class="card-body profile-card__body p-0">
            <a :href="base_url+'/account/address'" class="w-100 addresses-list__item--new" data-toggle="modal" data-target="#add-address">
                <div class="addresses-list__plus"></div>
                <div class="btn btn-secondary btn-sm">Add New</div>
            </a>
        </div>
    </div>

</template>

<script>
    export default {
        data(){
            return{
                base_url: baseUrl,
                address: null,
                from: 'home'
            }
        },
        created(){
            this.fetchDefaultAddress()
        },
        methods: {
            fetchDefaultAddress() {
                fetch(baseUrl+'/account/default-address')
                    .then(res => res.json())
                    .then(res =>{
                        if(res)
                            this.address = res;
                    });

            }
        },
        mounted() {
        }
    }
</script>
<style>
    .addresses-list__item--new{
        min-height: 270px;
    }
</style>