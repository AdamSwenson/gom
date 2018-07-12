<template xmlns="http://www.w3.org/1999/html">
    <div class="item-card card"
         v-bind:id="id"
         v-bind:class="styling"
    >

        <div class="card-content">
            <item-main :item="item"
                       :is-exam="false"
            ></item-main>
        </div>

        <div class="card-content"
             v-bind:id="contentId"
             v-show="isPaneVisible"
        >
            <nav-tabs
                    :item="item"
                    :is-exam="false">
            </nav-tabs>
            <router-view
                    :item="item"
                    name="itemPanels"></router-view>
        </div>

        <div class="card-footer">
            <div class="columns is-mobile is-multiline is-centered">

                <div class="column is-narrow">
                    <add-sibling-button :item="item">
                    </add-sibling-button>
                </div>

                <div class="column is-narrow">
                    <add-child-button :item="item"></add-child-button>
                </div>

                <div class="column is-narrow">
                    <item-clone-button :item="item"></item-clone-button>
                </div>

                <div class="column is-narrow">
                    <item-import-button :item="item"></item-import-button>
                </div>

                <div class="column is-narrow">
                    <public-indicator
                            :serial-number="serialNumber">
                    </public-indicator>
                </div>

            </div>

        </div>

        <!--This has the class card-footer-->
        <card-movement-control :item="item"></card-movement-control>


        <!--Check whether the item has children, if it does-->
        <!--we will make a box that will surround the children-->
        <div class="box" v-if="isChildrenVisible">

            <div v-for="item in items">
                <!--Now we make cards recursively-->
                <item-card
                        :item="item"
                        :key="item.serialNumber"></item-card>
            </div>
        </div>
    </div>
</template>

<style lang="scss">

    .item-card {
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

    import Item from '../../../models/Item';
    import Payload from '../../../models/Payload';
    import * as mTypes from '../../../store/mutation-types'
    import * as gTypes from '../../../store/getter-types'

    import AddChildButton from '../items/add-child-button.vue'
    import itemMain from '../items/item-main.vue';
    import itemCloneButton from '../items/item-clone-button.vue';
    import itemImportButton from '../items/item-import-button.vue';
    import movementControl from '../items/card-movement-control.vue';
    import navTabs from '../navigation/item-card-navigation-tabs.vue'
    import PublicIndicator from '../items/visibility-control.vue'
    import siblingAddButton from '../items/add-sibling-button.vue'


    export default {

        props: [ 'item', ], //'serialNumber' ],

        components: {
            AddChildButton,
            PublicIndicator,
            'card-movement-control': movementControl,
            'item-clone-button': itemCloneButton,
            'item-import-button': itemImportButton,
            'item-main': itemMain,
            'nav-tabs': navTabs,
            'add-sibling-button' : siblingAddButton
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

        asyncComputed : {


            /**
             * The children of the item
             */
            items: function () {
                if ( _.isUndefined( this.item ) ) return [];

                let c = this.$store.getters.getItemChildren( this.item );
                return !_.isUndefined( c ) ? c : [];
            },
        },

        computed: {

            id: function () {
                return this.identifier + "-" + this.height + '-' + this.depth; // + this.serialNumber;
            },

            contentId: function () {
                return "card-content-" + this.height + '-' + this.depth;
            },


            serialNumber : function (  ) {
              return this.item.serialNumber;
            },


            numberChildren: function () {
                return (!_.isUndefined( this.items ) && ! _.isNull(this.items) ) ? this.items.length : 0;
            },


            depth: function () {
                return this.$store.getters[ gTypes.getDepthOfNode ]( this.serialNumber );
            },


            height: function () {
                return this.$store.getters[ gTypes.getHeightOfNode ]( this.serialNumber );
            },

            /**
             * Whether this item's children are visible
             * If they exist and are hidden, that's usually due to the children-display-control
             * being clicked.
             */
            isChildrenVisible: function(){
                //no need to display the box area if nothing is going in it
                if(this.numberChildren === 0) return true;

                return this.$store.getters.isItemChildrenVisible(this.serialNumber);

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
