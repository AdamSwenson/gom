<template>
    <div id="grade-main-page"
         class=" mainBodyLocator"
    >

        <p>
            {{ student.nameFirstLast }}
        </p>
        <p>
            {{ exam.name }}
        </p>

        <feedback-panel :exam="exam" :student="student"></feedback-panel>

    </div>
</template>

<style lang="scss">

</style>

<script>
    import Student from '../../../models/Student';
    import Exam from '../../../models/Exam';

    import Payload from '../../../models/Payload';
    import Node from '../../../models/Node';
    import Item from '../../../models/Item';
    import ItemScore from '../../../models/ItemScore';
    import * as mTypes from '../../../store/mutation-types';
    import FeedbackPanel from "./feedback-panel";

    import { readJsonFromPageString, processItemObjectsFromJson } from '../../../store/utlities/JsonHelpers';

    export default {

        props: [],

        components: { FeedbackPanel },

        data: function () {
            return {
                defaults: {}
            }
        },

        computed: {
            student: function () {
                let studentJson = readJsonFromPageString( 'student' );
                return Student.factory( studentJson );
            },


            exam: function () {
                // return this.$store.getters.currentExam;
                let examJson = readJsonFromPageString( 'exam' );
                return Exam.factory( examJson );
            },

            itemScoreObjects: function () {
                let itemScoresJson = readJsonFromPageString( 'scores' );
                let scores = [];
                _.forEach( itemScoresJson, function ( s ) {
                    scores.push( ItemScore.factory( s ) );
                } );
                return scores;
            },

            items: function () {
                let o = this.loadItems();
                return !_.isUndefined( o ) ? o : [];
            },

            order: function () {
                // let o = this.loadOrder();
                // return !_.isUndefined( o ) ? o : [];
            }
        },

        methods: {
            loadOrder: function () {
                let orderJson = readJsonFromPageString( 'order' );
                if ( !_.isUndefined( this.exam ) && !_.isUndefined( this.items ) ) {
                    let state = {
                        items: this.items,
                        //initialize the order store
                        itemMap: new Node( this.exam.serialNumber, this.exam.serialNumber )
                    };
                    processItemOrderFromJson( state, orderJson );
                    return state.itemMap;
                }
            },

            loadItems: function () {
                // this.$store.commit(mTypes.loadExamAndItemsFromPageData);
                let ims = [];
                //the exam needs to be the root
                if ( _.isUndefined( this.exam ) ) return ims;
                ims.push( this.exam );
                let itemsJson = readJsonFromPageString( 'items' );
                return processItemObjectsFromJson( itemsJson );
                // _.forEach(itemsJson, function ( s ){
                //     ims.push(Item.factory(s));
                // });
                // return ims;
            }
        },

        directives: {},

        events: {},

        mounted: function () {
            this.$store.commit( mTypes.loadExamAndItemsFromPageData, Payload.factory( {
                options: {
                    elementIds: {
                        itemObjects: 'items',
                        itemOrder: 'order',
                        exam: 'exam'
                    }
                }
            } ));
        }
    }
</script>