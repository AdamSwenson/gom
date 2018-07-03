<!--For adding arbitrary notes visible only to the user with access to the setup page-->

<template>
    <div class="notes-panel">

        <div class="box"
             id="new-note-area">

            <div id="existing-notes-area">
                <h5 class="title is-5">Reminders from your past self</h5>

                <div v-if="isLoading">
                    <loading-indicator :isLoading="isLoading"></loading-indicator>
                </div>

                <div v-if="!isLoading">
                    <note-object
                            v-for="note in notes"
                            v-bind:key="note.serialNumber"
                            :note="note"
                            :serial-number="note.serialNumber"
                            :use-central-store="useCentralStore"
                            v-on:note-deleted="refreshNotes"
                            v-on:note-updated="refreshNotes"
                    ></note-object>
                </div>

            </div>

            <edit-note v-on:note-added="refreshNotes"></edit-note>


            <div class="field" v-show="isNewButtonVisible">
                <div class="control">
                    <button class="button new-note-button is-fullwidth"
                            v-bind:class="newNoteButtonStyling"
                            v-on:click="createNewNote"
                    >{{ newNoteButtonLabel }}
                    </button>
                </div>
            </div>
        </div>


    </div>
</template>

<style lang="scss">

    .notes-panel {
        label {
            text-align: left;
        }
    }
</style>
<script>
    import * as aTypes from '../../../store/action-types';
    import * as mTypes from '../../../store/mutation-types';
    import * as gTypes from '../../../store/getter-types';

    import Note from '../../../models/Note';
    import Payload from '../../../models/Payload';

    import noteObject from './note-object.vue';

    import { createNoteRequest, loadNotesForItemRequest } from '../../../api/requests/noteRequests';

    // import prioritySelector from './note/priority-selector';
    import colorSelector from '../tags/color-selector.vue';
    import loadingIndicator from '../helpers/loading-indicator.vue';
    import editNote from './new-note';


    export default {
//        props: ['serialNumber'], //the serial number of the note

        components: {
            editNote,
            'note-object': noteObject,
            // 'priority-selector': prioritySelector,
            'color-selector': colorSelector,
            'loading-indicator': loadingIndicator
        },

        data: function () {
            return {
                isLoading: false,

                // isNewNoteVisible: false,

                //whether to show the create new note button
                // isNewButtonVisible: true,

//                note: new Note(),
                //The serial number of the item the notes belong to
                itemSerialNumber: _.toInteger( this.$route.params.serialNumber ),

                // placeholders: {
                //     noteText: "Add a new note to your future self here"
                // },

                //these are the values of the new tag
                newNoteName: '',
                newNoteText: '',
                newNotePriority: 1,

                //if true, uses values stored in store.tags
                //if false, handles and stores all tag related
                //data internally.
                useCentralStore: true,

                //just a value to watch, when we need to
                //reload notes, we increment this.
                //There is no significance to the number otherwise
                loadTrigger: 0,

                labels: {
                    buttons: {
                        newNote: 'New Note'
                    }
                }
            };
        },

        asyncComputed: {
            notes: {
                get: function () {

                    let me = this;
                    // Set the loading icon displayed
                    this.isLoading = true;
                    // //get the data from the server
                    let p = me.$store.dispatch( 'loadNotes', Payload.factory( { obj: me.item } ) );

                    return p.then( function () {
                        me.isLoading = false;
                        return me.$store.getters[ gTypes.getNotesForItem ]( me.item );
                    } );
                },

                watch() {
                    //reloads from server when updated
                    this.loadTrigger;
                }
            }
        },


        computed: {

            /**
             * The exam or item the note is associated with
             */
            item: function () {
                return this.$store.getters.getItemBySerialNumber( this.itemSerialNumber );
            },

            isExam: function () {
                return this.item ? this.item.isExam() : false;
            },

            isNewButtonVisible: function () {
                let n = this.$store.getters.getNewNote;
                return !_.isObject( n );
            },

            newNoteButtonLabel: function () {
                if ( this.isNewNoteVisible ) return "Save";
                return this.labels.buttons.newNote;
            },

            newNoteButtonStyling: function () {
                if ( this.isNewNoteVisible ) return "is-primary";
                return "is-success";
            },

        },

        methods: {
            createNewNote: function () {
                this.$store.dispatch( "createNewNote", Payload.factory( { obj: this.item } ) );
            }
            ,

            refreshNotes: function () {
                this.loadTrigger += 1;
            },

            getId: function ( identifier ) {
                return identifier + '-' + this.serialNumber;
            },
        },
        

    }
</script>
