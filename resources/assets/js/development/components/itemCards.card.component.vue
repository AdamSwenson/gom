<template>
    <!--This represents a question or an element-->
    <div v-bind:id="divId"
         class="item-card-component"
         v-bind:class="offsetClass"
    >
        <div class="row">
            <item-name
                    :index="index"
                    :id="id"
            ></item-name>

        </div>
        <div class="row">
            <div class="clearfix"></div>

            <div class="col-lg-12">
                <!--<div class="col-lg-10">-->
                <div class="clearfix"></div>
                <slot name="head">

                    <item-settings
                            :index="index"
                            :id="id"
                    >
                        <!--is="currentView"-->
                        <div slot="controlsArea">
                            <div class="row">
                                <div class="col-md-1">
                                    <depth-control
                                            type="demote"
                                            :index="index"
                                            :id="id"
                                    ></depth-control>
                                </div>

                                <div class="col-md-10"></div>

                                <div class="col-md-1">
                                    <depth-control
                                            type="promote"
                                            :index="index"
                                            :id="id"
                                    ></depth-control>
                                </div>

                            </div>
                        </div>
                    </item-settings>
                </slot>

                <div class="clearfix"></div>

            </div>

            <!--<div class="col-lg-1 vertical-align">-->
            <!--<depth-control type="promote" :index="index"></depth-control>-->
            <!--</div>-->
        </div>

        <div class="row">
            <!--<div class="col-lg-1"></div>-->
            <div class="col-lg-12">
                <delete-item-button
                        :index="index"
                        :id="id"
                ></delete-item-button>
            </div>
            <!--<div class="col-lg-1"></div>-->
        </div>
    </div>


</template>
<style>

</style>
<script>

    export default{

        props: [ 'index' , 'id'],

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
            divId : function(){
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
                    let item = this.$store.getters.getItemById( this.id );
//                let item = this.$store.getters.getItemByIndex( this.index );
                    if ( typeof item != 'undefined' ) {
                        return item.depth
                    }

                },
                set: function (v) {
                    let item = this.$store.getters.getItemById( this.id );
                    // let item = this.$store.getters.getItemByIndex( this.index );
                    if ( typeof item != 'undefined' ) {
                        this.$store.commit(Payload.factory({id: this.id, index: this.index, updateProp: 'depth', updateVal: v}));
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

        directives: {},

        events: {
            'display-settings': function () {
                console.log( 'itemName', 'CAUGHT', 'display-settings', this.index );
            },
        },

        mounted: function () {
        },
    }
</script>
