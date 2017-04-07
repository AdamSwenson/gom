<template>
    <div id="examEditor">
        <div class="row">
            <div class="col-lg-1"></div>

            <div class="examEditor col-lg-10">
                <div class="panel-heading">
                    <exam-main></exam-main>
                </div>

                <div class="panel-body">
                    <exam-edit-pane
                            :index="0"
                            :is-exam="true"
                    ></exam-edit-pane>
                </div>
            </div>
            <div class="col-lg-1"></div>
        </div>

        <div id="examEditorBody"
             class="row"
        >

            <div class="col-lg-1"></div>

            <div id="itemCol"
                 class="col-lg-9 well well-sm  "
            >
                <div class="itemRow row">
                    <card-list></card-list>
                </div>
            </div>

            <div id="infoCol"
                 class="col-lg-2 well well-sm"
            >

                <div class="row">
                    <props-dashboard></props-dashboard>
                </div>

                <div class="row">
                    <tools-dashboard></tools-dashboard>
                </div>

            </div>

            <div class="col-lg-1"></div>

        </div>
    </div>
</template>

<style>
    /*@import '../node_modules/bootstrap-vue/dist/bootstrap-vue.css';*/
    #itemCol.well {
        background-color: #385a7f
    }
</style>
<script>

    import Exam from '../models/Exam'
    import Item from '../models/Item'
    import Payload from '../models/Payload'

    import * as aTypes from '../store/action-types'
    import * as mTypes from '../store/mutation-types'
    import * as gTypes from '../store/getter-types'

    import store from '../store'

    export default {
        store,

        data: function () {
            return {
                defaults: {},
            };
        },

        computed: {},

        methods: {},

        directives: {},

        events: {},

        mounted: function () {


//
        },

        components: {
        },

    }
</script>
