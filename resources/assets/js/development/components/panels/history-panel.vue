<template>
    <div class="panel-history-component ">

        <loading-indicator v-if="isLoading"
                           :is-loading="isLoading"
        ></loading-indicator>

        <div v-else
             class="panel">
            <p class="panel-heading">
                Exams using this item
            </p>
            <a class="panel-block"
               v-for="exam in exams"
               v-on:click="handleClick(exam)"
            >
                        <span class="panel-icon">
                            <i class="fa fa-book"></i>
                        </span>
                {{exam.name}}
            </a>
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

    import loadingIndicator from '../helpers/loading-indicator.vue';

    export default {
//        props: ['index'],


        components: {
            'loading-indicator': loadingIndicator,
        },

        data: function () {
            return {
                /** Whether the history info is currently loading */
                isLoading: false,

                serialNumber: _.toInteger( this.$route.params.serialNumber ),
//                active: this.serialNumber,

                placeholders: {},
            };
        },

        asyncComputed: {

            exams: function () {
                if ( !_.isUndefined( this.item ) && this.item.id !== -1 ) {
                    let me = this;
                    //Start the loading indicator
                    me.isLoading = true;
                    let p = getItemHistory( this.$store, this.item );

                    return p.then( function ( data ) {
                        me.isLoading = false;
                        return data;
                    } );

                }
                return [];
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

        methods: {
            handleClick: function ( exam ) {
                window.console.log( 'history-panel', 'handleClick', 70, exam );
                //todo redirect to new exam

            }
        }
    }

</script>
