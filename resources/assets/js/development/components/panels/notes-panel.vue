<!--For adding arbitrary notes visible only to the user with access to the setup page-->

<template>
    <div class="panel-notes-component">

        <div id="new-note-area">
            <div class="field new-note-input-area"
                 v-show="isNewNoteVisible">
                <label class="label">New note</label>
                <div class="control">
                        <textarea id="new-note-text"
                                  class="textarea"
                                  rows="3"
                                  v-bind:placeholder="placeholders.noteText"
                                  v-model="text">
                        </textarea>
                </div>
            </div>

            <div id="new-note-button-area"
                 class="field"
            >
                <p class="control">

                    <button class="button new-note-button is-fullwidth"
                            v-bind:class="newNoteStyling"
                            v-on:click="toggleNewNote"
                    >{{ newNoteLabel }}
                    </button>
                </p>
            </div>

        </div>

        <!--<div class="field">-->
        <!--<p class="control">-->

        <!--<button class="button is-success is-outlined"-->
        <!--v-on:click="addNewNote">-->
        <!--<span class="icon">-->
        <!--<i class="fa fa-plus" aria-hidden="true"></i>-->
        <!--</span>-->
        <!--<span>Add Note</span>-->
        <!--</button>-->
        <!--</p>-->
        <!--</div>-->

        <div id="existing-notes-area" class="container">
            <h3 class="title is-3">Things your past self wanted you to remember</h3>

            <!--<note-area-->
            <!--v-for="note in notes"-->
            <!--v-bind:key="note.serialNumber"-->
            <!--&gt;</note-area>-->
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
    import noteArea from './note-area.vue';

    export default {
//        props: ['serialNumber'], //the serial number of the note

        components: {
            'note-area': noteArea
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

            text: {
                get: function () {
                    return this.newNote ? this.newNote.text : '';
                },
                set: function ( v ) {
                    window.console.log( 'notes-panel', 'set', 155, this.newNote);
                    let pl = Payload.factory( {
                        obj: this.newNote,
                        updateProp: 'text',
                        updateVal: v
                    } );
                    this.$store.commit( mTypes.updateNote, pl );
                }
            },

            name: {
                get: function () {
                },
                set: function ( v ) {

                }
            },


            notes: function () {
                if ( this.item.id === -1 ) return [];

                return this.$store[ gTypes.getNotesForItem ]( this.itemSerialNumber );
            },

        },

        methods: {
            addNewNote: function () {
                window.console.log( 'panel.notes.component', 'addNewNote', 65, );
                this.$store.dispatch( "createNewNote", Payload.factory( { obj: this.item } ) );
                //switch the dialog back
            },

            initializeNote: function () {

                if ( this.isNoteVisible ) {
                    this.addNewNote();
                }
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
    }
</script>
