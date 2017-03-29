<template>
    <div class="panel-history-component">
     <!--tab-pane"-->
        <!--role="tabpanel"-->

        <div class="row">
            <div class="col-md-12">
                <p>Which exams clones of this item have been used on</p>

            </div>
        </div>

    </div>
</template>
<style>

</style>
<script>

    import * as aTypes from '../../store/action-types';
    import * as mTypes from '../../store/mutation-types';

    import Payload from '../../models/Payload'

    export default {
//        props: ['index'],

        data: function () {
            return {
                index: this.$route.params.index,
                placeholders: {
                },
            };
        },

        computed: {

        },

        methods: {}
    }

</script>
