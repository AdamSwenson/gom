<template>

<div class="grades-panel">
    <!--tab-pane"-->
    <!--role="tabpanel"-->
<p>Setting grade distribution happens here</p>

</div>

</template>
<style>

</style>
<script>
    import * as aTypes from '../../../store/action-types';
    import * as mTypes from '../../../store/mutation-types';

    import Payload from '../../../models/Payload'

    export default {
//        props: ['index'],

        data: function () {
            return {
                serialNumber: _.toInteger(this.$route.params.serialNumber),
                placeholders: {},
            };
        },

        computed: {

            item: function () {
                return this.$store.getters.getItemBySerialNumber( this.serialNumber );
            },

            //Doing this via computed property so don't have to pass in on route
            isExam: function () {
                if ( this.item instanceof Exam ) return true;
                return false;
            }
        },

        methods: {}
    }
</script>
