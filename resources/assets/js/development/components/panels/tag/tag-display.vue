<template>

    <div class="tag-display-area">
        <h5>
            <span class="icon is-small">
                <i class="fa fa-tags" aria-hidden="true"></i>
            </span>
            <span>Tags</span>
        </h5>

        <div class="field is-grouped is-grouped-multiline">
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

        <!--<div class="tags">-->
        <!--<span v-for="tag in tags"-->
        <!--class="tag is-rounded"-->
        <!--&gt;{{ tag.name}} <button class="delete is-small" v-on:click="handleDeleteClick(tag)"></button>-->
        <!--</span>-->

        <!--<span class="tag is-primary is-small new-tag-button"-->
        <!--v-on:click="handleEditClick"-->
        <!--&gt;Edit Tags-->
        <!--</span>-->
        <!--</div>-->

        <div v-show="showTagMenu">
            <tag-menu :object-serial-number="serialNumber"
                      :object-type="objectType"
                      v-on:tag-row-selected="handleTagToggle"
            ></tag-menu>
        </div>


    </div>
</template>

<style lang="scss">
    .tag-display-area {

    }
</style>

<script>

    import Item from '../../../../models/Item'
    import Exam from '../../../../models/Exam'
    import Payload from '../../../../models/Payload'
    import * as mTypes from '../../../../store/mutation-types'
    import * as gTypes from '../../../../store/getter-types'

    import { Routes } from '../../../../api/apiSettings';

    import tagMenu from '../../menus/tags-menu.vue';
    import tagObject from './tag-object.vue';

    /**
     * This displays the list of tags for the item.
     * Other dialogs will handle searches by tag
     * or tag creation
     */
    export default {

        props: [ 'serialNumber', 'objectType' ],

        components: {
            'tag-menu': tagMenu,
            'tag-object': tagObject
        },

        data: function () {
            return {
                showTagMenu: false,

                defaults: {}
            }
        },

        computed: {
            tags: function () {
                let result = this.$store.getters[ gTypes.getTagsForObject ]( this.serialNumber );
//                window.console.log( 'tag-display', 'tags', 53, this.serialNumber, result );
                if ( _.isUndefined( result ) ) return [];
                return result;
            },
            /**
             * If the menu is attached to an object (item,
             * exam, etc), this will return that object.
             * If it is free-floating, it will return false
             */
            object: function () {
                if ( this.objectType instanceof Item ) {
                    window.console.log( 'tag-display', 'object', 92, );
                    return this.$store.getters.getItemBySerialNumber( this.serialNumber );
                }

                if ( this.serialNumber ) {
                    window.console.log( 'tag-display', 'object', 86, this );
                    switch ( this.objectType ) {
                        case 'item':
                            return this.$store.getters.getItemBySerialNumber( this.serialNumber );
                            break;
                        case this.objectType instanceof Item:
                            window.console.log( 'tag-display', 'object', 92, );
                            return this.$store.getters.getItemBySerialNumber( this.serialNumber );
                            break;
                        //todo exam
                        //todo student
                        default:
                    }
                }
                return false;
            }

        },

        methods: {
            handleEditClick: function () {
                window.console.log( 'tag-display', 'handleEditClick', 77, );
                this.showTagMenu = !this.showTagMenu;
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

            handleTagToggle: function ( tag ) {
                window.console.log( 'tag-display', 'handleTagToggle', 96, tag, this, this.object );

                //make sure there's an object to act upon
                if ( this.object ) {
                    //find out if already tagged
                    if ( this.$store.getters.isObjectTagged( this.object, tag ) ) {
                        //remove the tag
                        this.$store.commit( mTypes.disassociateTag, Payload.factory( { obj: this.object, tag: tag } ) );
                    }
                    else {
                        //add the tag
                        this.$store.commit( mTypes.associateTag, Payload.factory( { obj: this.object, tag: tag } ) );
                    }
                }
            }
        },

        directives: {},

        events: {
            'tag-row-selection': function ( tag ) {
                this.handleTagToggle( tag )
            }
        },

        mounted: function () {
        }
    }
</script>