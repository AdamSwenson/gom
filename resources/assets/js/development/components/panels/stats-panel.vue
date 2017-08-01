<template>
    <div class="panel-stats-component">

        <h3 class="title is-3">Item scores for this exam</h3>

        <div class="box">
            <p>No scores have been recorded for this item on this exam.</p>
        </div>


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
                serialNumber: _.toInteger( this.$route.params.serialNumber ),
                active: this.serialNumber,

                placeholders: {},
            };
        },

        computed: {},

        methods: {}
    }
</script>
