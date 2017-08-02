<!--For adding arbitrary notes visible only to the user with access to the setup page-->

<template>
    <div class="panel-notes-component">

        <div class="box"
             id="new-note-area">

            <div class="field new-note-input-area"
                 v-show="isNewNoteVisible">
                <h5 class="title">Remind your future self...</h5>

                <div class="columns">
                    <div class="column is-half">
                        <div class="field">
                            <label class="label">Title</label>
                            <div class="control">
                                <input type="text"
                                       v-bind:id="getId('new-note-title')"
                                       v-model="name">
                            </div>
                            <p class="help"></p>
                        </div>
                    </div>
                    <div class="column is-half">
                        <priority-selector :serial-number="this.newNote.serialNumber"
                        ></priority-selector>
                    </div>
                </div>


                <div class="field">
                    <div class="control">
                        <textarea id="new-note-text"
                                  class="textarea"
                                  rows="3"
                                  v-bind:placeholder="placeholders.noteText"
                                  v-model="text">
                        </textarea>
                    </div>
                    <p class="help"></p>
                </div>


            </div>

            <div id="new-note-button-area">
                <div class="field">
                    <div class="control">
                        <button class="button new-note-button is-fullwidth"
                                v-bind:class="newNoteStyling"
                                v-on:click="toggleNewNote"
                        >{{ newNoteLabel }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div id="existing-notes-area"
             class="box">
            <h5 class="title">Your past self wanted you to remember....</h5>

            <note-area
                    v-for="note in notes"
                    v-bind:key="note.serialNumber"
                    :serial-number="note.serialNumber"
            ></note-area>
        </div>


    </div>
</template>

<style lang="scss">

    .panel-notes-component {
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

    import noteArea from './note/note-area.vue';

    import { loadNotesForItemRequest } from '../../../api/requests/noteRequests';

    import prioritySelector from './note/priority-selector';

    export default {
//        props: ['serialNumber'], //the serial number of the note

        components: {
            'note-area': noteArea,
            'priority-selector': prioritySelector
        },

        data: function () {
            return {

                isNewNoteVisible: false,
//                note: new Note(),
                //The serial number of the item the notes belong to
                itemSerialNumber: _.toInteger( this.$route.params.serialNumber ),

                placeholders: {
                    noteText: "Add a new note to your future self here"
                },

                labels: {
                    buttons: {
                        newNote: 'New Note'
                    }
                }
            };
        },

        watch: {
            /*
            * We created a new note object on load
            * or ajax success but did not store it
            * in store. This was to avoid having
            * empty note objects created in the db
            * every time the notes tab is clicked.
            * (We could've just reused the same one,
            * but that wastes space and makes it more
            * complicated to display the timestamps in
            * a way useful to the user).
            * */
//          note: function ( evt ) {
//              //if note's text has started changing
//              //send note to the server and from now on
//              //sync them
//          }
        },

        computed: {

            /**
             * The exam or item the note is associated with
             *
             */
            item: function () {
                return this.$store.getters.getItemBySerialNumber( this.itemSerialNumber );
            },

            isExam: function () {
                return this.item ? this.item.isExam() : false;
            },

            name: {
                get: function () {
                    return this.newNote ? this.newNote.name : '';

                },
                set: function ( v ) {
                    let pl = Payload.factory( {
                        obj: this.newNote,
                        updateProp: 'name',
                        updateVal: v
                    } );
                    this.$store.commit( mTypes.updateNote, pl );
                }
            },

            newNoteLabel: function () {
                if ( this.isNewNoteVisible ) return "Done";
                return this.labels.buttons.newNote;
            },

            newNoteStyling: function () {
                if ( this.isNewNoteVisible ) return "is-primary";
                return "is-success";

            },

            newNote: function () {
                return this.$store.getters.getNewNote;
            },

            notes: function () {
                let n = this.$store.getters[ gTypes.getNotesForItem ]( this.item );
                if ( n.length === 0 ) return n;

                return n;
                //filter out the note being created, since
                //that looks weird. When we hit done, that will
                //unset it as the newNote, and the text will display
                if ( this.newNote ) {
                    let sn = this.newNote.serialNumber;
                    return n.filter( ( r ) => {
                        if ( r.serialNumber !== sn ) return r;
                    } );
                }
                return [];
            },

            text: {
                get: function () {
                    return this.newNote ? this.newNote.text : '';
                },
                set: function ( v ) {
                    let pl = Payload.factory( {
                        obj: this.newNote,
                        updateProp: 'text',
                        updateVal: v
                    } );
                    this.$store.commit( mTypes.updateNote, pl );
                }
            }

        },

        methods: {
            addNewNote: function () {
                window.console.log( 'panel.notes.component', 'addNewNote', 65, );
                this.$store.dispatch( "createNewNote", Payload.factory( { obj: this.item } ) );
                //switch the dialog back
            }
            ,

            initializeNote: function () {

                if ( this.isNoteVisible ) {
                    this.addNewNote();
                }
            }
            ,

            getId: function (identifier){
                return identifier + '-' + this.serialNumber;
            },

            toggleNewNote: function () {
                this.isNewNoteVisible = !this.isNewNoteVisible;
                if ( this.isNoteVisible ) {
                    //if the note is now open,
                    //initialize it
                    this.initializeNote();
                }
                this.addNewNote();
            }
        }
        ,

        created: function () {
            loadNotesForItemRequest( this.$store, this.item );
        }
    }
</script>
