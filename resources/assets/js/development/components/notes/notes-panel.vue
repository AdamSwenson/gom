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
                            :object="note"
                            :serial-number="note.serialNumber"
                            :use-central-store="useCentralStore"
                            v-on:note-deleted="refreshNotes"
                            v-on:note-updated="refreshNotes"
                    ></note-object>
                </div>

            </div>

            <div class="new-note-input-area "
                 v-show="isNewNoteVisible"
            >
                <h5 class="title is-5">Remind your future self...</h5>

                <div class="field">
                    <label class="label">Title</label>
                    <div class="control">
                        <input type="text"
                               v-bind:id="getId('new-note-title')"
                               v-model="newNoteName">
                    </div>
                    <p class="help"></p>
                </div>

                <div class="field">
                    <div class="control">
                        <textarea id="new-note-text"
                                  class="textarea"
                                  rows="3"
                                  v-bind:placeholder="placeholders.noteText"
                                  v-model="newNoteText">
                        </textarea>
                    </div>
                    <p class="help"></p>
                </div>

                <color-selector
                        v-on:priority-selected="handlePrioritySelection"
                ></color-selector>
                <!--<priority-selector-->
                <!--v-on:priority-selected="handlePrioritySelection"-->
                <!--&gt;</priority-selector>-->


                <div class="field is-grouped">

                    <p class="control">
                        <a class="button save-note-button is-success"
                           v-on:click="saveNewNote"
                        >Save</a>
                    </p>

                    <p class="control">
                        <a class="button clear-note-button is-warning"
                           v-on:click="clearNewNote"
                        >Clear</a>
                    </p>
                </div>

            </div>

            <div class="field" v-show="isNewButtonVisible">
                <div class="control">
                    <button class="button new-note-button is-fullwidth"
                            v-bind:class="newNoteButtonStyling"
                            v-on:click="toggleNewNote"
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


    export default {
//        props: ['serialNumber'], //the serial number of the note

        components: {
            'note-object': noteObject,
            // 'priority-selector': prioritySelector,
            'color-selector': colorSelector,
            'loading-indicator': loadingIndicator
        },

        data: function () {
            return {
                isLoading: false,

                isNewNoteVisible: false,

                //whether to show the create new note button
                isNewButtonVisible: true,

//                note: new Note(),
                //The serial number of the item the notes belong to
                itemSerialNumber: _.toInteger( this.$route.params.serialNumber ),

                placeholders: {
                    noteText: "Add a new note to your future self here"
                },

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
                get() {
                    let me = this;
                    let result = [];
                    if ( this.useCentralStore ) {
                        result = this.$store.getters[ gTypes.getNotesForItem ]( this.item );
                        if ( result.length === 0 ) return result;

                        //filter out the note being created, since
                        //that looks weird. When we hit done, that will
                        //unset it as the newNote, and the text will display
                        if ( this.newNote ) {
                            let sn = this.newNote.serialNumber;
                            return result.filter( ( r ) => {
                                if ( r.serialNumber !== sn ) return r;
                            } );
                        }

                    } else {

                        //load it from the server
                        this.isLoading = true;
                        let p = loadNotesForItemRequest( null, this.item );
                        return p.then( function ( data ) {
                            me.isLoading = false;
                            return data;
                        } );
                    }
                },

                watch() {
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


            newNoteButtonLabel: function () {
                if ( this.isNewNoteVisible ) return "Save";
                return this.labels.buttons.newNote;
            },

            newNoteButtonStyling: function () {
                if ( this.isNewNoteVisible ) return "is-primary";
                return "is-success";
            },

            newNote: function () {
                return this.$store.getters.getNewNote;
            },

        },

        methods: {
            addNewNote: function () {
                // window.console.log( 'panel.notes.component', 'addNewNote', 65, );
                if ( this.useCentralStore ) {
                    this.$store.dispatch( "createNewNote", Payload.factory( { obj: this.item } ) );
                }
            },

            clearNewNote: function () {
                this.newNoteName = '';
                this.newNoteText = '';
                this.newNotePriority = 0;
            },

            saveNewNote: function () {
                let note = Note.factory( {
                    associatedObject: this.item,
                    name: this.newNoteName,
                    text: this.newNoteText,
                    priority: this.newNotePriority
                } );
                let me = this;
                let p = createNoteRequest( null, note );
                p.then( function () {
                    me.refreshNotes();
                    me.toggleNewNote();
                    me.clearNewNote();
                } );
            },

            handlePrioritySelection: function ( priority ) {
                window.console.log( 'notes-panel', 'handlePrioritySelection', 297, priority );
                this.newNotePriority = priority;
            },

            initializeNote: function () {
                if ( this.isNewNoteVisible ) this.addNewNote();
            },

            refreshNotes: function () {
                this.loadTrigger += 1;
            },

            getId: function ( identifier ) {
                return identifier + '-' + this.serialNumber;
            },

            toggleNewNote: function () {
                this.isNewNoteVisible = !this.isNewNoteVisible;
                this.isNewButtonVisible = !this.isNewButtonVisible;
                if ( this.useCentralStore && this.isNewNoteVisible ) {
                    //if the note is now open,
                    //initialize the fields
                    this.initializeNote();
                }
            }
        },

    }
</script>
