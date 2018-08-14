<template>

    <div class="tag-display">
        <h5>
            <span class="icon is-small">
                <i class="fa fa-tags" aria-hidden="true"></i>
            </span>
            <span>Tags</span>
        </h5>

        <div class="object-tag-list field is-grouped is-grouped-multiline">
            <tag-object
                    v-if="isReady"
                    v-for="tag in tags"
                    v-bind:key="tag.serialNumber"
                    :tag="tag"
                    :isVisible="true"
                    :showRemove="isEditable"
                    v-on:tag-clicked="handleSelection"
                    v-on:remove-clicked="handleRemoveClick"
            ></tag-object>

            <div class="tag-object">
                <div v-on:click="handleEditClick" class="control">
                    <div class="tags has-addons">
                        <span class="tag is-info is-small edit-tag-button"
                        >{{ buttonDisplayText }}</span>
                    </div>
                </div>
            </div>

        </div>

        <div v-show="showTagMenu"
        >
            <tag-menu :object="object"
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

    import Item from '../../../models/Item'
    import Exam from '../../../models/Exam'
    import Payload from '../../../models/Payload'
    import * as mTypes from '../../../store/mutation-types'
    import * as gTypes from '../../../store/getter-types'

    import tagMenu from './tag-menu.vue';
    import tagObject from './tag-object.vue';

    /**
     * This displays the list of tags for the item / exam / student.
     *
     * Editing, creating, deleting tags is handled elsewhere.
     */
    export default {

        props: [ 'object', ],

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
                useCentralStore: true,
                defaults: {},
                isEditable: false,
                buttonText: {
                    editing: 'Done',
                    notEditing: 'Edit Tags'
                }
            }
        },

        computed: {
            /**
             * The text displayed on the edit button
             */
            buttonDisplayText: function(){
              if(this.isEditable) return this.buttonText.editing;
              return this.buttonText.notEditing;
            },

            tags: {
                get() {
                    if ( _.isUndefined( this.object ) ) return [];
                    return this.object.tags;
                }
            },

            isReady: function () {
                return this.tags.length > 0;
            }

        },

        methods: {
            handleEditClick: function () {
                this.showTagMenu = !this.showTagMenu;
                this.isEditable = !this.isEditable;
            },

            /**
             * This calls for disassociating the tag
             * from the item. It does not the call to delete
             * the tag from the database
             */
            handleRemoveClick: function ( tag ) {
                window.console.log( 'tag-display', 'handleDeleteClick', 114, tag);
                // window.console.log( 'tag-display', 'handleDeleteClick', 40, tag );
                if ( this.object && tag.isTagged( this.object ) ) {
                    //remove the tag
                    this.$store.commit( mTypes.disassociateTag, Payload.factory( { obj: this.object, tag: tag } ) );
                }
            },

            handleSelection: function(tag){
                window.console.log( 'tag-display', 'handleSelection', 123, tag);
            },

            /**
             * when someone clicks a tag row in the menu,
             * it emits an event handled by this function.
             * This function thus can be responsible for associating
             * and disassociating tags
             * @param tag
             */
            handleTagToggle: function ( tag ) {
                // window.console.log( 'tag-display', 'handleTagToggle', 96, tag, this, this.object );

                //make sure there's an object to act upon
                if ( this.object ) {
                    if ( tag.isTagged( this.object ) ) {
                        //if it is already tagged, we will be removing the association
                        //NB, not using an action since the mutations trigger the
                        //api plugin to send the change to the server.
                        this.$store.commit( mTypes.disassociateTag, Payload.factory( {
                            obj: this.object,
                            tag: tag
                        } ) );
                    }
                    else {
                        //add the tag association
                        this.$store.commit( mTypes.associateTag, Payload.factory( {
                            obj: this.object,
                            tag: tag
                        } ) );
                    }
                }
            },


            handleNewTagSavedEvent: function ( tag ) {
                // window.console.log( 'tag-display', 'handleNewTagSavedEvent', 221, tag );
            },

        },

        events: {
            'tag-row-selection':
                function ( tag ) {
                    // this.handleTagToggle( tag )
                }
        }
        ,

        mounted: function () {
        }
    }
</script>