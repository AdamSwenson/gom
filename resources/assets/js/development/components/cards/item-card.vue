<template xmlns="http://www.w3.org/1999/html">
    <div v-bind:id="divId"
         class="item-card-component card"
         v-bind:class="offsetClass"
         v-bind:data-id="index"
         v-bind:data-index="index"
         v-bind:data-parent-index="parentIndex"
    >

        <div class="card-content">
            <item-main :index="index" :serial-number="serialNumber" :is-exam="false"></item-main>
        </div>

        <div class="card-content" v-show="paneVisible">
            <edit-tabs :index="index"
                       :serial-number="serialNumber"
                       :is-exam="false">

            </edit-tabs>
            <router-view name="itemPanels"></router-view>
        </div>

        <div class="card-footer">
            <div class="card-footer-item">
                <div class="field is-grouped">
                    <p class="control">
                        <add-sibling-button :index="serialNumber"
                                            :serial-number="serialNumber">
                        </add-sibling-button>
                    </p>

                    <p class="control">
                        <add-child-button :index="serialNumber"
                                          :serial-number="serialNumber">
                        </add-child-button>
                    </p>

                    <p class="control">
                        <button class="button is-primary is-outlined">
                                <span class="icon is-small">
                                    <i class="fa fa-clone" aria-hidden="true"></i>
                                </span>
                            <span>Clone</span>
                        </button>
                    </p>
                    <p class="control">
                        <button class="button is-primary is-outlined">
                                <span class="icon is-small">
                                    <i class="fa fa-mail-forward" aria-hidden="true"></i>
                                </span>
                            <span>Import item</span>
                        </button>
                    </p>

                    <p class="control">
                        <public-indicator :index="index"
                                          :serial-number="serialNumber">
                        </public-indicator>
                    </p>
                    <p class="control">
                        <remove-item-button :index="index"
                                            :serial-number="serialNumber">
                        </remove-item-button>
                    </p>
                </div>

            </div>
        </div>

        <div class="card-footer navTabs">
            <div class="card-footer-item is-fullwidth">
                <card-movement-control :serialNumber="serialNumber"></card-movement-control>
            </div>
        </div>


        <!--Check whether the item has children, if it does-->
        <!--we will make a box that will surround the children-->
        <div class="box" v-if="numberChildren > 0">

            <div v-for="isn in children">
                <!--Now we make cards recursively-->
                <item-card :serial-number="isn" :index="isn" :key="isn"></item-card>
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
            margin-left:1em;
            margin-right:1em;
            margin-bottom:1em;

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

    export default{

        props: [ 'index', 'parent-index', 'serialNumber' ],

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


        computed: {
            item: function () {
                return this.$store.getters[ gTypes.getItemBySerialNumber ]( this.serialNumber );
            },

            /**
             * Returns an array of serial numbers belonging to
             * this item's children (in order)
             */
            children: function () {
                let node = this.$store.getters[ gTypes.getItemNodeFromOrder ]( this.serialNumber );
                let cdrn = [];
                if ( node.children.length > 0 ) {
                    for (let i = 0; i < node.children.length; i++) {
                        cdrn.push( node.children[ i ].data );
                    }
                }
                return cdrn;
            },

            numberChildren: function () {
                let node = this.$store.getters[ gTypes.getItemNodeFromOrder ]( this.serialNumber );
                return node.children.length;
            },


            /**
             * Returns true if the settings pane for this item should be displayed
             */
            paneVisible: function () {
                return this.$store.getters[ gTypes.isItemSettingsVisible ]( this.serialNumber )
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

            ddepth: function () {

                //start with the current instance
                //that way, if we are at the root,
                //the while won't run
                //todo or do I need the other kind?
                let current = this.$parent;
                let d = 0;
                let limit = 5;
                while (_.isEmpty( current ) && d < limit) {
                    //we aren't at the root, so
                    //increment our depth counter
                    d++;
                    //and set the parent of the parent as current
                    current = current.$parent;
                }
                return d;
            },

            item: function () {
                return this.$store.getters[ gTypes.getItemBySerialNumber ]( this.serialNumber );
            },

            depth: {
                get: function () {
//                    return this.$store.getters[ gTypes.getDepthOfNode ]( this.serialNumber );
//                    let item = this.$store.getters.getItemById(this.id);
//                    let item = this.$store.getters.getItemByIndex(this.index);
//                    if ( typeof item !== 'undefined' ) {
//                        return item.depth
//                    }
//
                },
                set: function ( v ) {
//                    let item = this.$store.getters.getItemById(this.id);
//                    let item = this.$store.getters[ gTypes.getDepthOfNode ]( this.serialNumber );
//                    if ( typeof item !== 'undefined' ) {
//                        this.$store.commit( Payload.factory( {
////                            id: this.id,
//                            index: this.index,
//                            updateProp: 'depth',
//                            updateVal: v
//                        } ) );
//                    }
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
