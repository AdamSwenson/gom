<template>
    <div class="item-comment">
        <p v-for="t in childTextParagraphs" class="item-comment-para">
            {{t}}
        </p>
    </div>
</template>

<style lang="scss">

</style>

<script>
    import * as nggTypes from '../../../store/new-grading-getter-types';

    import feedbackMixin from './feedback.mixin';

    const buildText = function ( store, student, item, paragraph ) {
        return (function ( store, student, item, paragraph ) {
            console.log( 'item-comment', 'buildText', 17, paragraph );
            //add the present item's text
            let so = store.getters[ nggTypes.getItemScoreObject ]( {
                item: child,
                student: student
            } );
            window.console.log( 'item-comment', 'so', 23, so );
            if ( !_.isUndefined( so ) ) paragraph += so.text;

            //get present item's children
            let children = store.getters.getItemChildren( item );
            //if the item has no children, we are done here
            if ( _.isUndefined( children ) || _.isNull( children ) || children.length === 0 ) return true;

            //otherwise iterate through each child
            _.forEach( children, function ( child ) {
                window.console.log( 'item-comment', '', 32, child );
                //and recurse....
                buildText( store, student, child, paragraph );
            } );
        })( store, student, item, paragraph );
    }


    export default {
        mixins: [ feedbackMixin ],
        props: [ 'item', 'student' ],

        components: {},

        data: function () {
            return {
                defaults: {}
            }
        },

        asyncComputed: {
            childItemScoreObjects: function () {
                let me = this;
                let s = [];

                if ( _.isUndefined( this.itemChildren ) || _.isNull( this.itemChildren ) || this.itemChildren.length === 0 ) return s;
                if ( !this.isReady() ) return s;

                _.forEach( this.itemChildren, function ( item ) {

                    let childScoreObject = me.$store.getters[ nggTypes.getItemScoreObject ]( {
                        item: item,
                        student: me.student
                    } );
                    s.push( childScoreObject );
                } );
                return s;
            },


            text: function () {
                return this.scoreObject ? this.scoreObject.text : '';
            },

            childTextParagraphs: function () {
                let t = [];
                if ( _.isUndefined( this.childItemScoreObjects ) || _.isNull( this.childItemScoreObjects ) || this.childItemScoreObjects.length === 0 ) return t;
                _.forEach( this.childItemScoreObjects, function ( score ) {
                    if ( !_.isUndefined( score ) ) t.push( score.text );
                } );
                // buildText( this.$store, this.student, this.item, t );
                return t;
            }

        },

        methods: {
            // buildText: function ( paragraph, item ) {
            //     let me = this;
            //     //get children
            //     let children = this.$store.getters.getItemChildren( item );
            //     if ( _.isUndefined( children ) || _.isNull( children ) || children.length === 0 ) return paragraph;
            //
            //     //otherwise iterate through each child
            //     _.forEach( children, function ( child ) {
            //         let so = this.$store.getters[ nggTypes.getItemScoreObject ]( {
            //             item: child,
            //             student: me.student
            //         } );
            //         if ( !_.isUndefined( so ) ) paragraph += so.text;
            //
            //         me.buildText( paragraph, child );
            //     } );
            // }
        }

    }
</script>