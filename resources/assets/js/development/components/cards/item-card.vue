<template xmlns="http://www.w3.org/1999/html">
    <div class="item-card-component card"
         v-bind:id="id"
         v-bind:class="styling"
    >

        <div class="card-content">
            <item-main :serial-number="serialNumber" :is-exam="false"></item-main>
        </div>

        <div class="card-content"
             v-bind:id="contentId"
             v-show="isPaneVisible">
            <edit-tabs
                    :serial-number="serialNumber"
                    :is-exam="false">
            </edit-tabs>
            <router-view name="itemPanels"></router-view>
        </div>

        <div class="card-footer">
            <div class="columns is-mobile is-multiline ">

                <div class="column is-narrow">
                    <add-sibling-button
                            :serial-number="serialNumber">
                    </add-sibling-button>
                </div>

                <div class="column is-narrow">
                    <add-child-button
                            :serial-number="serialNumber">
                    </add-child-button>
                </div>

                <div class="column is-narrow">
                    <item-clone-button :serial-number="serialNumber"></item-clone-button>
                </div>

                <div class="column is-narrow">
                    <item-import-button :serial-number="serialNumber"></item-import-button>
                </div>

                <div class="column is-narrow">
                    <public-indicator
                            :serial-number="serialNumber">
                    </public-indicator>
                </div>

                <div class="column is-narrow">
                    <remove-item-button
                            :serial-number="serialNumber">
                    </remove-item-button>
                </div>
            </div>

        </div>

        <!--This has the class card-footer-->
        <card-movement-control :serialNumber="serialNumber"></card-movement-control>


        <!--Check whether the item has children, if it does-->
        <!--we will make a box that will surround the children-->
        <div class="box" v-if="numberChildren > 0">

            <div v-for="isn in children">
                <!--Now we make cards recursively-->
                <item-card
                        :serial-number="isn"
                        :key="isn"></item-card>
            </div>
        </div>
    </div>
</template>

<style lang="scss">

    .item-card-component {
        margin-top: 2em;

        border-bottom: solid;

        .nav-tabs {
            /*text-align: center;*/
        }

        .box {
            /*padding-left: 2%;*/
            margin-left: 1em;
            margin-right: 1em;
            margin-bottom: 1em;

            /*border-top-width: 0;*/
        }
        /*!*width: 80%;*!*/
        /*.button-row {*/
        /*padding: 1em;*/
        /*}*/
        /*.panel-heading {*/

        /*background-color: #FFFDF4;*/

    }

</style>
<script>
    //    import deleteButton from './item-remove-button.vue'
    //    import itemEditPane from './item.edit-pane.component.vue'
    //    import depthControl from './buttons.depth-control.component.vue'
    //    import itemMain from './item-main.vue'

    import Item from '../../../models/Item'
    import Payload from '../../../models/Payload'
    import * as mTypes from '../../../store/mutation-types'
    import * as gTypes from '../../../store/getter-types'

    import itemCloneButton from '../items/item-clone-button.vue';
    import itemImportButton from '../items/item-import-button.vue';

    export default {

        props: [ 'serialNumber' ],

        components: {
            'item-clone-button': itemCloneButton,
            'item-import-button': itemImportButton
        },

        data: function () {
            return {
                node: this.getNode(),
                identifier: 'item-card',

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


        computed: {

            id: function () {
                return this.identifier + "-" + this.height + '-' + this.depth; // + this.serialNumber;
            },

            contentId: function () {
                return "card-content-" + this.height + '-' + this.depth;
            },

            /**
             * The object representing the item's intrinsic properties
             * */
            item: function () {
                return this.$store.getters[ gTypes.getItemBySerialNumber ]( this.serialNumber );
            },

            /**
             * Returns an array of serial numbers belonging to
             * this item's children (in order)
             */
            children: function () {
                let c = [];
                if ( this.node ) {
                    for (let i = 0; i < this.node.children.length; i++) {
                        c.push( this.node.children[ i ].data );
                    }
                }
                return c;
            },

            numberChildren: function () {
                return this.children.length;
            },

            depth: function () {
                return this.$store.getters[ gTypes.getDepthOfNode ]( this.serialNumber );
            },


            height: function () {
                return this.$store.getters[ gTypes.getHeightOfNode ]( this.serialNumber );
            },


            /**
             * Returns true if the settings pane for this item should be displayed
             */
            isPaneVisible: function () {
                return this.$store.getters[ gTypes.isItemSettingsVisible ]( this.serialNumber )
            },

            styling: function () {

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
            getNode: function () {
                return this.$store.getters.getItemNodeFromOrder( this.serialNumber )
            },
//            addSibling: function ( rel="younger" ) {
//                switch (rel){
//                    case 'older':
//                        break;
//                    case 'younger':
//                        break;
//                    default:
//                }

            /**
             * Toggles whether comments are shown for this item.
             * Turning comments off does not delete any existing
             * comments.
             */
            toggleCommentsOn: function () {
                console.log( 'CALLED', 'toggleCommentsOn' );
                this.isCommented = !this.isCommented;
            },

            /**
             * Toggles whether comments are shown for this item.
             * Turning comments off does not delete any existing
             * comments.
             */
            toggleNameVisibility: function () {
                console.log( 'CALLED', 'toggleNameVisibility' );
                this.isNamePublic = !this.isNamePublic;
            },


        },

        directives: {
            'sortable': {
                inserted: function ( el, binding ) {
//                    var sortable = new Sortable( el, binding.value || {} );
                }
            }
        },

        events: {
            'display-settings': function () {
                console.log( 'itemMain', 'CAUGHT', 'display-settings', this.index );
            },
        },

        mounted: function () {
        },
    }
</script>
