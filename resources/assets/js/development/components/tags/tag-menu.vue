<template>
    <div class="tag-menu panel">

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


        <div class="panel-tabs filter-tabs">
            <a v-for="v in filterVals"
               v-bind:class="filterTabStyling(v)"
               v-on:click="filterDisplayedTagsBy(v)"
            >{{v}}</a>
        </div>


        <a class="panel-block tag-menu-row"
           v-for="tag in tags"
           v-on:click="handleRowClick(tag)"
           v-bind:key="tag.serialNumber"
           v-bind:class="styling(tag)"
           v-if="isDisplayed(tag)"
        >
            <span class="panel-icon">
                <i class="fa fa-tag"></i>
            </span>

            <span>
                {{tag.name}}
            </span>

            <slot></slot>
        </a>


        <div id="new-tag-input-area"
             class="panel-block is-fullwidth"
             v-show="isNewTagInputVisible"
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

            <div class="field">
                <label class="label">Color</label>
                <div class="control">
                    <color-selector
                            v-on:color-selected="handleColorSelection"
                    ></color-selector>
                </div>
                <p class="help"></p>
            </div>

        </div>


        <div class="panel-block new-tag-button-area">
            <a class="button new-tag-button  is-fullwidth"
               v-bind:class="newTagButtonStyling"
               v-on:click="handleNewClick"
            >{{ newTagButtonLabel }}
            </a>
        </div>


    </div>

</template>

<style lang="scss">
    .tags-panel {
        .filter-tabs {
            text-transform: capitalize;
        }
    }
</style>

<script>


    import Item from '../../../models/Item'
    import Exam from '../../../models/Exam'
    import Payload from '../../../models/Payload'
    import Tag from '../../../models/Tag'
    import * as mTypes from '../../../store/mutation-types'
    import * as gTypes from '../../../store/getter-types'


    import colorSelector from './color-selector.vue';

    /**
     * This is a menu of all tags existing for the user.
     * It also contains the tools for editing, creating, and
     * removing tags.
     *
     * It is normally used to select or remove tags from an object,
     * though it could be used as an object-independent panel for
     * adding or deleting tags globally.
     */
    export default {

        props: [ 'object', ],

        components: {
            'color-selector': colorSelector
        },

        data: function () {
            return {
                /**
                 * The type of tagged object to display
                 * Usual values:
                 *      false
                 *      items
                 *      students
                 *      exams
                 */
                filterTo: 'all',

                filterVals: [ 'all', 'exams', 'items', 'students' ],

                isEditable: false,
                isNewTagInputVisible: false,
                isEditButtonVisible: true,

                //these are the values of the new tag
                newTagName: '',
                newTagText: '',
                priority: 1,

                //if true, uses values stored in store.tags
                //if false, handles and stores all tag related
                //data internally.
                useCentralStore: true,
                defaults: {}
            }
        },

        asyncComputed: {
            //We need to load all tags associated with the user from the server
            //We can't just iterate through all existing items because the user
            //might have created tags in another exam which have not been used here.
            tags: {
                get() {
                    let me = this;
                    // return this.$store.getters[ gTypes.getAllTags ];

                    // if(this.$store.getters[ gTypes.getAllTags ].length === 0) {
                    let p = me.$store.dispatch( 'loadAllUserTagsFromServer' );
                    return p.then( function () {
                        // window.console.log( 'tag-menu', 'loaded tags', 161, );
                        return me.$store.getters[ gTypes.getAllTags ];
                    } );
                    // }
                },

                watch() {
                    // this.$parent.clickCounter;
                }
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

        },

        methods: {
            filterTabStyling: function ( taggedObjectType ) {
                if ( this.filterTo === taggedObjectType ) return 'is-active'
            },

            /**
             * Handle a click on the filtration tabs
             */
            filterDisplayedTagsBy: function ( taggedObjectType ) {
                switch ( taggedObjectType ) {
                    case 'exams':
                        this.filterTo = taggedObjectType;
                        break;
                    case 'items':
                        this.filterTo = taggedObjectType;
                        break;

                    case 'students':
                        this.filterTo = taggedObjectType;
                        break;

                    default:
                        this.filterTo = 'all';
                }

            },

            styling: function ( tag ) {
                let styles = tag.styleString();
                if ( this.isHighlighted( tag ) ) {
                    styles += ' is-active';
                }
                //this handles tag props having to do w style
                return styles;
            },

            handleColorSelection: function ( styleKey ) {
//                window.console.log( 'tags-menu', 'handleColorSelection', 275, styleKey);
                this.priority = styleKey;
            },

            handleRowClick: function ( tag ) {
//                if(this.isHighlighted(tag)){
//                    this.$emit( 'tag-row-deselected', tag )
//                }
                this.$emit( 'tag-row-selected', tag )
            },

            handleSearch: function ( v ) {
                let showKeys = _.findKey( this.tags, function ( t ) {
                    return _.startsWith( t.name, v );
                } );
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
                this.clearNewTag();

                //toggle state
                this.isNewTagInputVisible = !this.isNewTagInputVisible;
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

                this.$emit( 'new-tag-saved', tag );


                // Trying to do it this way creates an error where it claims:
                // TypeError: tag.styleString is not a function
                // at VueComponent.styling (new-setup-package.js:18506)
                // at new-setup-package.js:69564

                // window.console.log( 'tag-menu', 'saveNewTag', 288, tag);
                // let me = this;
                // let pl = Payload.factory( { obj: this.object, tag: tag });
                // let p = this.$store.dispatch( 'createTag',  pl );
                // p.then( function(  ){
                //     let p2 = this.$store.dispatch( 'associateTag', pl );
                //     p2.then( function(  ) {
                //         this.$emit( 'new-tag-saved', tag );
                //         window.console.log( 'tag-menu', 'new-tag-saved', 295, );
                //     });
                //
                // });


            },


            /**
             * Returns a boolean of whether to display
             * the row containing the tag
             */
            isDisplayed: function ( tag ) {

                if ( this.filterTo === 'all' ) return true;

                if ( tag[ this.filterTo ].length > 0 ) return true;

                return false;
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
                let isHighlighted = tag.isTagged( this.object );
                // switch ( this.object ) {
                //     case this.object instanceof Item.constructor:
                //         if ( tag.isTagged(this.object)) isHighlighted = false;
                //         _.forEach( tag.items, ( i ) => {
                //             if ( i.id === this.object.id ) isHighlighted = true;
                //         } );
                //         break;
                //     default:
                // }
                return isHighlighted;
            },

            /**
             * Resets (or sets) the fields which hold
             * the new tag data to their default state.
             */
            clearNewTag: function () {
                //Clean up
                this.newTagText = '';
                this.newTagName = '';
                this.priority = 1;
            }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>