<template>
    <!--This is the hideable area via which we edit the exam's properties-->
    <div class="exam-detail-pane well well-sm"
         v-show="visible"
    >
        <h4>Properties of the overall exam or assignment </h4>

        <panel-exam-detail></panel-exam-detail>

    </div>

</template>

<style>

</style>

<script>

    import * as aTypes from '../../store/action-types';
    import * as mTypes from '../../store/mutation-types';
    import * as gTypes from '../../store/getter-types';

    import Payload from '../../models/Payload'

    import panelExamDetail from './panel.exam-detail.component.vue'
    // Vue.component('panel-exam-detail', panelExamDetail)

    export default{

        props: [ 'exam-id' ],

        data: function () {
            return {};
        },

        components: {
            panelExamDetail
        },

        computed: {
            visible: function () {
                console.log( this.$store.getters );
                return this.$store.getters[ gTypes.isExamSettingsVisible ];
            },

        },

        methods: {
            getExam: function () {
                return this.$store.getters[ gTypes.getActiveExamObj ];
            },

        },

        directives: {},

        events: {},

        mounted: function () {
            console.log( 'exam-edit-pane ready' );
        },
    };
</script>
