<template>
    <div id="examEditor"
         class="setup-main"
    >
        <div id="examEditorHead" >
            <div class="row">
                <div class="col-md-1 col-lg-2"></div>
                <div class=" itemCol col-md-10 col-lg-8">
                    <exam-main></exam-main>
                </div>
                <div class="col-md-1 col-lg-2"></div>
            </div>

            <div class="row">
                <div class="col-md-1 col-lg-2"></div>
                <div class=" itemCol col-md-10 col-lg-8">
                    <exam-edit-pane
                            :index="0"
                            :is-exam="true"
                    ></exam-edit-pane>
                </div>
            </div>

        </div>

        <div id="examEditorBody" class="row">
            <div class="col-md-1 col-lg-3"></div>


            <div class="itemCol col-md-10 col-lg-6"
            >
                <card-list></card-list>
            </div>

            <div class="col-md-1 col-lg-3"></div>

        </div>
        <div class="row">
            <div class="col-md-1 col-lg-3"></div>
            <div class="col-md-10 col-lg-6"><p></p></div>
            <div class="col-md-1 col-lg-3"></div>
        </div>

        <div id="infoCol" class="row">
            <div class="col-md-1 col-lg-3"></div>
            <div class="col-md-10 col-lg-6">
                <progress-dashboard></progress-dashboard>
            </div>

            <div class="col-md-1 col-lg-3"></div>

        </div>

    </div>
</template>

<style lang="scss">
    /*@import '../node_modules/bootstrap-vue/dist/bootstrap-vue.css';*/
    /*#itemCol.well {*/
    /*background-color: #2b417f*/
    /*}*/

    .setup-main {
        /*background-color: #00496C;*/
        background-image: linear-gradient(bottom left, #00496C, #004768);

        /*background-color: #2b417f*/
    }

    #examEditorHead {
        /*background-color: #00496C;*/

        .panel {
            background-color: #FFFDF4
        }

    }

    #examEditorBody {
        /*background-color: #00496C*/

        /*background: rgba(0, 0, 0, 0) url("http://localhost:8000/images/styling/cover.png") repeat-y scroll 0 0;*/
        /*padding: 0 30px;*/
        /*padding-left: 5%;*/
        /*padding-right: 5%;*/
        /*background-color: #385a7f*/
    }

    .itemCol {
        /*background-color: #FFFDF4;*/
        border-color: #990002;
        border-width: thin;
        border-style: solid;

        /*-moz-border-image: url(http://localhost:8000/images/styling/border.png) 10 stretch round;*/
        /*-webkit-border-image: url(http://localhost:8000/images/styling/border.png) 10 stretch round;*/
        /*border-image: url(http://localhost:8000/images/styling/border.png) 10 stretch round;*/
        /*border-width: 10px;*/
        /*border-image : url('http://localhost:8000/images/styling/border.png') 10 repeat;*/
        /*border-width : 10px;*/
        /*border-right-color: #990002;*/
        /*border-right-width: thin;*/
        /*border-right-style: solid;*/
        /*border-left-color: #990002;*/
        /*border-left-width: thin;*/
        /*border-left-style: solid;*/
        /*padding-left: 1px;*/
        /*padding-right: 1px;*/

        box-shadow: 0 1px 3px rgba(0, 0, 0, .8), 0 3px 9px rgba(0, 0, 0, .2);

    }

    #infoCol {
        /*background-color: #00496C;*/
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
