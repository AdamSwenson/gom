<template>

    <!--This represents a question or an element-->
    <div v-bind:id="divId"
         class="item-card-component"
         v-bind:class="offsetClass"
         v-bind:data-id="index"
         v-bind:data-index="index"
         v-bind:data-parent-index="parentIndex"
    >
        <div class="row">
            <div class="col-md-12 text-left">
                <item-main :index="index"></item-main>
            </div>
        </div>

        <div class="row" v-show="paneVisible">
            <div class="col-md-12 text-left">
                <edit-tabs :index="index" :is-exam="false"></edit-tabs>

                <!-- Tab panels -->
                <div class="tab-panel-area">
                    <router-view name="itemPanels"></router-view>
                </div>

            </div>
        </div>

        <div class="row" v-show="paneVisible">
            <div class="button-row col-md-12 text-left">
                <div class="btn-group "
                     role="group"
                     aria-label="Item tool buttons">

                    <delete-item-button :index="index"></delete-item-button>

                    <public-indicator :index="index"></public-indicator>
                    <button class="btn btn-warning">Clone</button>
                </div>
            </div>
        </div>

        <div class="row">
            <!--<sub-list></sub-list>-->
        </div>
    </div>


</template>
<style lang="scss">

    .item-card-component {

        /*width: 80%;*/
        .button-row {
            padding: 1em;
        }
        .panel-heading {

            /*background-color: #FFFDF4;*/
        }

        .bottom-stripe {
            /*line-height: 3em;*/
            /*background-color: #385a7f;*/
        }

    }

</style>
<script>
    //    import deleteButton from './buttons.item.delete.component.vue'
    //    import itemEditPane from './item.edit-pane.component.vue'
    //    import depthControl from './buttons.depth-control.component.vue'
    //    import itemMain from './item.main.component.vue'

    import Item from '../../../models/Item'
    import Payload from '../../../models/Payload'
    import * as mTypes from '../../../store/mutation-types'
    import * as gTypes from '../../../store/getter-types'

    export default{

        props: [ 'index', 'parent-index' ],

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
            /**
             * Returns true if the settings pane for this item should be displayed
             */
            paneVisible: function () {
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

            ddepth: function () {

                //start with the current instance
                //that way, if we are at the root,
                //the while won't run
                //todo or do I need the other kind?
                let current = this.$parent;
                let d = 0;
                let limit = 5;
                while (_.isEmpty(current) && d < limit) {
                    //we aren't at the root, so
                    //increment our depth counter
                    d++;
                    //and set the parent of the parent as current
                    current = current.$parent;
                }
                return d;
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

        directives: {
            'sortable': {
                inserted: function ( el, binding ) {
                    var sortable = new Sortable( el, binding.value || {} );
                }
            }
        },

        events: {
            'display-settings': function () {
                console.log('itemMain', 'CAUGHT', 'display-settings', this.index);
            },
        },

        mounted: function () {
        },
    }
</script>
