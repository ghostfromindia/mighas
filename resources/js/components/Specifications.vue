<template>



        <div class="spec">

            <div class="spec__section" v-for="(head, ind) in data">
                <h4 class="spec__section-title">{{ind}}</h4>


                <div class="spec__row" v-for="field in head">
                    <div class="spec__name">{{field[0]}}</div>
                    <div class="spec__value">{{field[1]}}</div>
                </div>
            </div>

            <div class="spec__disclaimer">
                Information on technical characteristics, the delivery set, the country of manufacture and the appearance
                of the goods is for reference only and is based on the latest information available at the time of publication.
            </div>
        </div>



</template>

<script>
    export default {
        data: function(){
            return {
                data:[],
                head:[],
                field:{
                    key:'',
                    value:''
                }
            }
        },
        created(){
               this.fetchSpecification(this.id)

        },
        methods:{
            fetchSpecification(id) {
                console.log('creating specification  from ' + baseUrl + '/specification/' + id);
                fetch(baseUrl + '/specification/' + id)
                    .then(res => res.json())
                    .then(res => {
                        this.data = res;
                    })
            }

        },
        props: [
            'id'
        ]
    }
</script>

<style>

</style>