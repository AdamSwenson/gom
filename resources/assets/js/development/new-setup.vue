<template>
    <div id="examEditor"
         class="setup-main"
    >
        <div class="row">
            <div class="col-md-1 col-lg-2"></div>

            <div class="col-md-10 col-lg-8 graph-paper-background-small border-image-lft">

                <div id="examCardArea" class="row">
                    <div class="col-md-12 col-lg-12 ">
                        <exam-card :index="0"></exam-card>
                    </div>
                </div>


                <div id="itemCardArea" class="row ">
                    <div class="col-md-1 col-lg-1"></div>

                    <div class="itemCol col-md-10 col-lg-10">
                        <card-list></card-list>
                    </div>

                    <div class="col-md-1 col-lg-1"></div>
                </div>
            </div>

            <div class="col-md-1 col-lg-2"></div>

        </div>

        <!--<div id="examEditorHead" class="row">-->
        <!--<div class="col-md-1 col-lg-2"></div>-->
        <!--<div class="itemCol col-md-10 col-lg-8">-->
        <!--<exam-card></exam-card>-->
        <!--</div>-->
        <!--<div class="col-md-1 col-lg-2"></div>-->
        <!--</div>-->


        <!--<div id="examEditorBody" class="row">-->
        <!--<div class="col-md-1 col-lg-3"></div>-->
        <!--<div class="itemCol col-md-10 col-lg-6">-->
        <!--<card-list></card-list>-->
        <!--</div>-->
        <!--<div class="col-md-1 col-lg-3"></div>-->
        <!--</div>-->

        <div class="row">
            <div class="col-md-1 col-lg-1"></div>

            <div class="col-md-10 col-lg-10">
                <progress-dashboard></progress-dashboard>
            </div>

            <div class="col-md-1 col-lg-1"></div>
        </div>

    </div>
</template>

<style lang="scss">
    @import '../../sass/development/newSetup';


    .setup-main {
        background-image: linear-gradient(bottom left, $main-background-color, $main-background-color-gradient-limit);
    }

    #examCardArea {
        background-color: $color-primary-2;

        /*<!--background-color: $main-background-color-gradient-limit;-->*/

        box-shadow: 0 1px 3px rgba(0, 0, 0, .8), 0 3px 9px rgba(0, 0, 0, .2);
    }

    #itemCardArea {
        box-shadow: 0 1px 3px rgba(0, 0, 0, .8), 0 3px 9px rgba(0, 0, 0, .2);
    }

    .itemCol {
        border-left-color: $border-outline-color;
        border-left-width: thin;
        border-left-style: solid;
        border-right-color: $border-outline-color;
        border-right-width: thin;
        border-right-style: solid;
        /*-moz-border-image: url(http://localhost:8000/images/styling/border.png) 10 stretch round;*/
        /*-webkit-border-image: url(http://localhost:8000/images/styling/border.png) 10 stretch round;*/
        /*border-image: url(http://localhost:8000/images/styling/border.png) 10 stretch round;*/
        /*border-width: 10px;*/
        /*border-image : url('http://localhost:8000/images/styling/border.png') 10 repeat;*/

    }

    .infoCol {
        margin-top: 2em;
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
