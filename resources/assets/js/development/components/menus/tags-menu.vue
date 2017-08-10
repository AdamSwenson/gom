<template>
    <div class="tags-panel panel">

        <div class="panel-heading">
            Tags
        </div>

        <div class="panel-block tag-search-area">
            <p class="control has-icons-left">
                <input class="input is-small" type="text" placeholder="Search">
                <span class="icon is-small is-left">
                        <i class="fa fa-search"></i>
                    </span>
            </p>
        </div>


        <div class="panel-tabs">
            <a class="is-active">All</a>
            <a>Items</a>
            <a>Students</a>
            <a>Exams</a>
        </div>


        <a class="panel-block "
           v-for="tag in tags"
           v-on:click="handleRowClick(tag)"
           :key="tag.serialNumber"
           v-bind:class="styling(tag)"
        >
            <span class="panel-icon">
                <i class="fa fa-tag"></i>
            </span>

            <span>
                {{tag.name}}
            </span>

            <slot></slot>
        </a>

        <div id="new-tag-input-area is-fullwidth"
             v-show="isNewTagInputVisible"
             class="panel-block "
        >
            <div class="field">
                <label class="label">Tag</label>
                <div class="control">
                    <input type="text"
                           id="new-tag-name"
                           class="input"
                           v-model="newTagName">
                </div>
                <p class="help">The text you want to see in the tag</p>
            </div>


            <div class="field is-horizontal">
                <div class="field-label">
                    <label class="label">Color</label>
                </div>
                <div class="field-body">
                    <div class="field is-narrow">
                        <div class="control">
                            <label class="radio">
                                <input type="radio" name="priority" value="0" v-model="priority">
                                0
                            </label>
                            <label class="radio">
                                <input type="radio" name="priority" value="1"  v-model="priority">
                                1
                            </label>
                            <label class="radio">
                                <input type="radio" name="priority"  value="3" v-model="priority">
                                3
                            </label>
                        </div>
                    </div>
                </div>

                <p class="help"></p>
            </div>


        <!--<div class="field">-->
        <!--<label for="new-tag-text">(optional) Brief reminder of what this tag means</label>-->
        <!--<div class="control">-->
        <!--<textarea id="new-tag-text"-->
        <!--rows="3"-->
        <!--class="textarea"-->
        <!--v-model="newTagText"-->
        <!--&gt;</textarea>-->
        <!--</div>-->
        <!--<p class="help">This won't usually be visible. To see it, click the tag.</p>-->

        <!--</div>-->

    </div>


    <div class="panel-block new-tag-button-area">
        <a class="button new-tag-button  is-fullwidth"
           v-bind:class="newTagButtonStyling"
           v-on:click="handleNewClick"
        >{{ newTagButtonLabel }}
        </a>
    </div>


    <!--<div class="panel-block edit-tag-button-area"-->
    <!--v-if="isEditButtonVisible">-->
    <!--<a class="button edit-tag-button  is-fullwidth"-->
    <!--v-bind:class="editTagButtonStyling"-->
    <!--v-on:click="handleEditClick"-->
    <!--&gt;{{ editTagButtonLabel }}-->
    <!--</a>-->
    <!--</div>-->

    </div>

</template>

<style lang="scss">

</style>

<script>


    import Item from '../../../models/Item'
    import Exam from '../../../models/Exam'
    import Payload from '../../../models/Payload'
    import Tag from '../../../models/Tag'
    import * as mTypes from '../../../store/mutation-types'
    import * as gTypes from '../../../store/getter-types'

    import { Routes } from '../../../api/apiSettings';
    import { loadAllUserTagsRequest } from '../../../api/requests/tagRequests';


    /**
     * This is a menu of all tags existing for the user.
     * It also contains the tools for editing, creating, and
     * removing tags.
     *
     * It is normally used to select or remove tags from an object,
     * though it need not be.
     */
    export default {

        /**
         * objectSerialNumber : if this is displaying / managing
         *                      the tags associated with something,
         *                      this is the identifier of that something.
         */
        props: [ 'objectSerialNumber', 'objectType' ],

        components: {},

        data: function () {
            return {

                isEditable: false,
                isNewTagInputVisible: false,
                isEditButtonVisible: true,

                newTagName: '',
                newTagText: '',
                priority: 0,
                defaults: {}
            }
        },

        computed: {
            editTagButtonStyling: function () {
                if ( this.isEditable ) {
                    //the edit button has been clicked
                    return 'is-warning '
                }
                return 'is-primary is-outlined'
            },

            editTagButtonLabel: function () {
                return this.isEditable ? 'Done' : 'Edit'
            },


            newTagButtonStyling: function () {
                if ( this.isNewTagInputVisible ) {
                    //The input fields are open
                    return 'is-warning '
                }
                return 'is-primary is-outlined'
            },

            newTagButtonLabel: function () {
                return this.isNewTagInputVisible ? 'Save' : 'New'
            },


            tags: function () {
                return this.$store.getters[ gTypes.getAllTags ];
            },

            /**
             * If the menu is attached to an object (item,
             * exam, etc), this will return that object.
             * If it is free-floating, it will return false
             */
            object: function () {
                if ( this.objectSerialNumber ) {
//                    if ( this.objectType instanceof Object ) {
//                        return this.objectType;
//                    }

                    switch ( this.objectType ) {
                        case this.objectType.kind === 'item':
                            return this.$store.getters.getItemBySerialNumber( this.objectSerialNumber );
                            break;
                        case 'item':
                            return this.$store.getters.getItemBySerialNumber( this.objectSerialNumber );
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

            styling: function ( tag ) {
                let styles = "is-default ";
                if ( this.isHighlighted( tag ) ) {
                    styles += 'is-active';
                }
                //this handles tag props having to do w style
                return styles;
            },

            handleRowClick: function ( tag ) {
                this.$emit( 'tag-row-selected', tag )
            },


            saveNewTag: function () {
                let tag = Tag.factory( {
                    name: this.newTagName,
//                    text: this.newTagText,
                    props: {
                        priority: this.priority
                    }
                } );

                this.$store.dispatch( 'createAndAssociateTag', Payload.factory( { obj: this.object, tag: tag } ) );

            },

            handleEditClick: function () {
                this.isEditable = !this.isEditable;
            },

            handleNewClick: function () {
                if ( this.isNewTagInputVisible ) {
                    //we are in edit mode
                    //thus the click was a request to save
                    //so let's do that
                    this.saveNewTag();
                }
                //Clean up
                this.newTagText = '';
                this.newTagName = '';
                this.priority = 0;

                //toggle state
                this.isNewTagInputVisible = !this.isNewTagInputVisible;
            },

            /**
             * Whether the row should be highlighted.
             * Usually this is done to indicate that a tag
             * is already associated with the object this menu
             * is displaying for.
             *
             * @param tagSerialNumber
             */
            isHighlighted: function ( tag ) {
                //if the menu isn't attached to an object
                //nothing should highlight
                if ( _.isUndefined( this.serialNumber ) ) return false;

                return this.$store.getters.isTagged( this.object, tag );
            }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>