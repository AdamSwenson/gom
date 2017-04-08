<template>
    <!--This represents a question or an element-->
    <div v-bind:id="divId"
         class="item-card-component panel"
         v-bind:class="offsetClass"
    >
        <div class="panel-heading">
            <item-main :index="index"></item-main>
        </div>

        <div class="panel-body" v-show="visible">
            <item-edit-pane :index="index"></item-edit-pane>
            <delete-item-button
                    :index="index"
            ></delete-item-button>
        </div>
    </div>

</template>
<style>
    .panel-heading{

        background-color: #FFFDF4;
    }
    .bottom-stripe {
        /*line-height: 3em;*/
        /*background-color: #385a7f;*/
    }

    /*li {*/
    /*margin-bottom: 10em;*/
    /*}*/

</style>
<script>
    //    import deleteButton from './buttons.item.delete.component.vue'
    //    import itemEditPane from './item.edit-pane.component.vue'
    //    import depthControl from './buttons.depth-control.component.vue'
    //    import itemMain from './item.main.component.vue'

    import Item from '../../models/Item'
    import Payload from '../../models/Payload'
    import * as mTypes from '../../store/mutation-types'
    import * as gTypes from '../../store/getter-types'

    export default{

        props: [ 'index' ],

        data: function () {
            return {

                defaults: {
                    depth: null,
                    index: null,
                    type: null,
                    //how much one unit of depth will be offset
                    tabOffset: 2
                },
                isCommented: false,
                /**
                 * Whether students can see the name of the item
                 */
                isNamePublic: false,
            };
        },

//        components : {
//            'item-settings': itemEditPane,
//            'delete-item-button': deleteButton,
//            'depth-control': depthControl,
//            'item-name': itemMain,
//
//        },

        computed: {
            /**
             * Returns true if the settings pane for this item should be displayed
             */
            visible: function () {
                return this.$store.getters[ gTypes.isItemSettingsVisible ](this.index)
            },

            divId: function () {
                return "item-card-" + this.index
            },

            /**
             * Returns the bootstrap class for the depth
             */
            offsetClass: function () {
                if ( this.depth > 0 ) {
                    let amt = this.defaults.tabOffset * this.depth;
                    let col = "col-md-offset-" + amt;
                    return col
                }
            },

            depth: {
                get: function () {
//                    let item = this.$store.getters.getItemById(this.id);
                    let item = this.$store.getters.getItemByIndex(this.index);
                    if ( typeof item !== 'undefined' ) {
                        return item.depth
                    }

                },
                set: function ( v ) {
//                    let item = this.$store.getters.getItemById(this.id);
                    let item = this.$store.getters.getItemByIndex(this.index);
                    if ( typeof item !== 'undefined' ) {
                        this.$store.commit(Payload.factory({
//                            id: this.id,
                            index: this.index,
                            updateProp: 'depth',
                            updateVal: v
                        }));
                    }
                }
            },

            type: {
                get: function () {
                    return this.defaults.index;
                },
                set: function () {

                }
            }
        },

        methods: {
            /**
             * Toggles whether comments are shown for this item.
             * Turning comments off does not delete any existing
             * comments.
             */
            toggleCommentsOn: function () {
                console.log('CALLED', 'toggleCommentsOn');
                this.isCommented = !this.isCommented;
            },

            /**
             * Toggles whether comments are shown for this item.
             * Turning comments off does not delete any existing
             * comments.
             */
            toggleNameVisibility: function () {
                console.log('CALLED', 'toggleNameVisibility');
                this.isNamePublic = !this.isNamePublic;
            },


        },

        directives: {},

        events: {
            'display-settings': function () {
                console.log('itemMain', 'CAUGHT', 'display-settings', this.index);
            },
        },

        mounted: function () {
        },
    }
</script>
