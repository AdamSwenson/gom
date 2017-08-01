<template>
    <div class="panel-history-component ">
        <!--tab-pane"-->
        <!--role="tabpanel"-->
        >
        <h3 class="title is-3">Past scores for this item</h3>

        <div class="tile is-ancestor">

            <div class="tile"
                 v-if="exams.length > 0"
                 v-for="exam in exams"
            >
                {{exam.name}}
            </div>
        </div>
    </div>
</template>
<style>

</style>
<script>

    import * as aTypes from '../../../store/action-types';
    import * as mTypes from '../../../store/mutation-types';

    import Payload from '../../../models/Payload'

    import { getItemHistory } from '../../../api/requests/historyRequests';

    export default {
//        props: ['index'],

        data: function () {
            return {
                serialNumber: _.toInteger( this.$route.params.serialNumber ),
//                active: this.serialNumber,

                placeholders: {},
            };
        },

        asyncComputed: {

            exams: function () {
                if(this.item && this.item.id !== -1){
                    return getItemHistory( this.item );
                }
            }

        },

        computed: {
            //if this is not the panel for the exam
            item: function () {
                return this.$store.getters.getItemBySerialNumber( this.serialNumber );
            },


            isExam: function () {
                return this.item ? this.item.isExam() : false;
            },



        },

        methods: {}
    }

</script>
