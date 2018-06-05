<template>

    <div class="tag-display">
        <h5>
            <span class="icon is-small">
                <i class="fa fa-tags" aria-hidden="true"></i>
            </span>
            <span>Tags</span>
        </h5>

        <div class="object-tag-list field is-grouped is-grouped-multiline">
            <tag-object v-for="tag in tags"
                        v-bind:key="tag.serialNumber"
                        :object="tag"
            ></tag-object>

            <div class="tag-object">
                <div v-on:click="handleEditClick" class="control">
                    <div class="tags has-addons">
                        <span class="tag is-rounded is-info is-small new-tag-button">Edit Tags</span>
                    </div>
                </div>
            </div>

        </div>

        <div v-show="showTagMenu">
            <tag-menu :object-serial-number="serialNumber"
                      :object-type="objectType"
                      v-on:tag-row-selected="handleTagToggle"
                      v-on:new-tag-saved="handleNewTagSavedEvent"
            ></tag-menu>
        </div>


    </div>
</template>

<style lang="scss">
    .tag-display {

    }
</style>

<script>

    import Item from '../../../../models/Item'
    import Exam from '../../../../models/Exam'
    import Payload from '../../../../models/Payload'
    import * as mTypes from '../../../../store/mutation-types'
    import * as gTypes from '../../../../store/getter-types'

    import { Routes } from '../../../../api/apiSettings';

    import {
        loadTagsForItemRequest,
        associateTagRequest,
        disassociateTagRequest
    } from '../../../../api/requests/tagRequests';

    import tagMenu from '../../menus/tags-menu.vue';
    import tagObject from './tag-object.vue';

    /**
     * This displays the list of tags for the item.
     * Other dialogs will handle searches by tag
     * or tag creation
     */
    export default {

        props: [ 'serialNumber', 'objectType', 'object' ],

        components: {
            'tag-menu': tagMenu,
            'tag-object': tagObject
        },

        data: function () {
            return {
                showTagMenu: false,
                //this gives us something to watch and thereby trigger a reload from the db
                //it is intrinsically meaningless
                clickCounter: 0,
                useCentralStore: false,
                defaults: {}
            }
        },

        asyncComputed: {
            tags: {
                get () {
                    let me = this;
                    if(_.isUndefined(this.object)) return [];

                    this.$store.dispatch('loadTagsForItem', this.object)
                        .then(function(){
                        return me.$store.getters[ gTypes.getTagsForObject ]( me.object );
                    });
                    //
                    //
                    //
                    // let result = [];
                    // if ( this.useCentralStore ) {
                    //     result = this.$store.getters[ gTypes.getTagsForObject ]( this.object );
                    // } else {
                    //     result = loadTagsForItemRequest( null, this.object );
                    // }
                    //
                    // return result;
                },
                watch() {
                    // this.clickCounter
                }
            }
        },

        computed: {

            /**
             * If the menu is attached to an object (item,
             * exam, etc), this will return that object.
             * If it is free-floating, it will return false
             */
//             object: function () {
//                 if ( this.objectType === 'item' || this.objectType instanceof Item ) {
// //                    window.console.log( 'tag-display', 'object', 92, );
//                     return this.$store.getters.getItemBySerialNumber( this.serialNumber );
//                 }
//
//                 if ( this.serialNumber ) {
// //                    window.console.log( 'tag-display', 'object', 86, this );
//                     switch ( this.objectType ) {
//                         case 'item':
//                             return this.$store.getters.getItemBySerialNumber( this.serialNumber );
//                             break;
//                         case this.objectType instanceof Item:
// //                            window.console.log( 'tag-display', 'object', 92, );
//                             return this.$store.getters.getItemBySerialNumber( this.serialNumber );
//                             break;
//                         //todo exam
//                         //todo student
//                         default:
//                     }
//                 }
//                 return false;
//             }
//
        },

        methods: {
            handleEditClick: function () {
                this.showTagMenu = !this.showTagMenu;
//                window.console.log( 'tag-display', 'handleEditClick', 77, this.showTagMenu);
            },

            handleDeleteClick: function ( tag ) {
                //This is the call to disassociate the tag
                //from the item. It is not the call to delete
                //the tag from the database
                window.console.log( 'tag-display', 'handleDeleteClick', 40, tag );

                if ( this.object && this.$store.getters.isObjectTagged( this.object, tag ) ) {
                    //remove the tag
                    this.$store.commit( mTypes.disassociateTag, Payload.factory( { obj: this.object, tag: tag } ) );
                }

            },

            /**
             * when someone clicks a tag row in the menu,
             * it emits an event handled by this function.
             * This function thus can be responsible for associating
             * and disassociating tags
             * @param tag
             */
            handleTagToggle: function ( tag ) {
                window.console.log( 'tag-display', 'handleTagToggle', 96, tag, this, this.object );

                //make sure there's an object to act upon
                if ( this.object ) {
                    //The fact that we aren't using the central store
                    //of tags doesn't matter. The mutations trigger the
                    //api plugin to send the change to the server.
                    //At the end, we'll increment the click counter which
                    //will reload tags from the db

                    let isTagged = false;

                    //find out if already tagged
                    switch ( this.objectType ) {
                        case 'item':
                            if ( tag.items.length === 0 ) return false;
                            tag.items.filter( ( i ) => {
                                if ( i.id === this.object.id )
                                    isTagged = true;
                            } );
                            break;
                        default:
                    }

                    if ( isTagged ) {
                        if ( !this.useCentralStore ) {
                            disassociateTagRequest( null, tag, this.object );
                        }
                        else {
                            if ( this.$store.getters.isObjectTagged( this.object, tag ) ) {
                                //remove the tag
                                this.$store.commit( mTypes.disassociateTag, Payload.factory( {
                                    obj: this.object,
                                    tag: tag
                                } ) );
                            }
                        }
                    }
                    else {
                        //add the tag
                        if ( !this.useCentralStore ) {
                            associateTagRequest( null, tag, this.object );
                        } else {
                            this.$store.commit( mTypes.associateTag, Payload.factory( {
                                obj: this.object,
                                tag: tag
                            } ) );
                        }
                    }
                    //incrementing this triggers the reload
                    this.refreshTags();
                }
            },

            handleNewTagSavedEvent: function ( tag ) {
                window.console.log( 'tag-display', 'handleNewTagSavedEvent', 221, tag );
                this.refreshTags();
            }
            ,

            /**
             * Triggers the reload of scores from db
             */
            refreshTags: function () {
                //incrementing this triggers the reload
                this.clickCounter += 1;
            }
        }
        ,

        directives: {}
        ,

        events: {
            'tag-row-selection':

                function ( tag ) {
                    this.handleTagToggle( tag )
                }
        }
        ,

        mounted: function () {
        }
    }
</script>