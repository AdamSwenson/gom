<template>
    <div id="examEditor"
         class="setup-main">
        <div id="examEditorHead"
             class="row"
        >
            <div class="col-md-1"></div>

            <div class="panel col-md-10">
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
            <div class="col-md-1"></div>
        </div>

        <div id="examEditorBody"
             class="row"
        >
            <div class="col-md-1"></div>

            <div id="itemCol"
                 class="col-md-8"
            >
                <card-list></card-list>
            </div>

            <div id="infoCol"
                 class="col-md-2"
            >
                <!--<div class="row">-->
                    <props-dashboard></props-dashboard>
                <!--</div>-->

                <!--<div class="row">-->
                    <tools-dashboard></tools-dashboard>
                <!--</div>-->

            </div>
            <div class="col-md-1"></div>

        </div>
    </div>
</template>

<style lang="scss">
    /*@import '../node_modules/bootstrap-vue/dist/bootstrap-vue.css';*/
    /*#itemCol.well {*/
    /*background-color: #2b417f*/
    /*}*/

    .setup-main {
        background-color: #00496C
        /*background-color: #2b417f*/
    }

    #examEditorHead {
        .panel {
            background-color: #FFFDF4
        }

    }

    #examEditorBody {
            /*background: rgba(0, 0, 0, 0) url("http://localhost:8000/images/styling/cover.png") repeat-y scroll 0 0;*/
            /*padding: 0 30px;*/
        /*padding-left: 5%;*/
        /*padding-right: 5%;*/
        /*background-color: #385a7f*/
    }
    #itemCol{
        background-color: #FFFDF4;
    }

    #infoCol{
        background-color: #FFFDF4;
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
            store.dispatch('setupOnMount');
        },

        components: {},

    }
</script>
