<template>

    <div class="note-object"
         v-bind:id="getId('note-object')"
    >

        <div class="note-editing field"
             v-if="isEditable"
        >
            <h5 class="title">Add a new note to your future self</h5>

            <div class="field">
                <label class="label">{{ noteNameLabel }}</label>
                <div class="control">
                    <input class="text note-name"
                           v-bind:id="getId('note-name')"
                           v-bind:placeholder="placeholders.nameText"
                           v-model="name">
                </div>
                <p class="help">This is a help text</p>
            </div>

            <div class="field">
                <label class="label">Note</label>
                <div class="control">
                <textarea class="note-text textarea"
                          rows="3"
                          v-bind:placeholder="placeholders.noteText"
                          v-model="text"></textarea>
                </div>
                <p class="help">This is a help text</p>
            </div>

        </div>


        <div class=" message "
             v-else
             v-bind:class="priorityClass"
        >
            <div class="message-header">
                <p>{{ note.name }}</p>
                <button class="delete delete-note"
                        v-on:click="handleDeleteClick"
                ></button>
            </div>

            <div class="message-body">
                <div class="note-text-display">
                    {{ note.text }}
                </div>

                <div class="level timestampArea">
                    <!-- Left side -->
                    <div class="level-left">
                        <div class="level-item has-text-centered">

                            <div>
                                <p class="heading">Created: {{ creationTimestamp }}</p>

                                <!--<p class="heading">Created: {{ creationTimestamp }}  |  Updated: {{ updatedTimestamp-->
                                <!--}}</p>-->

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </div>
</template>

<style lang="scss">
    .note-object {
        .message {
            margin-bottom: 0.5em;
        }
    }

</style>

<script>
    import * as aTypes from '../../../store/action-types';
    import * as mTypes from '../../../store/mutation-types';
    import * as gTypes from '../../../store/getter-types';
    import Note from '../../../models/Note';
    import Payload from '../../../models/Payload';

    import { destroyNoteRequest, updateNoteRequest } from '../../../api/requests/noteRequests';

    export default {

        props: [ 'note' ],

        components: {},

        data: function () {
            return {
//                priorityStyles: Note.priorityStyles(),
//                    {
//                    0: 'is-dark',
//                    1: 'is-primary',
//                    2: 'is-info',
//                    3: 'is-warning',
//                    4: 'is-danger'
//                },

                //whether we are able to edit properties of the note
                isEditable: false,

                noteObject: false,

                defaults: {},
                noteNameLabel: "Title",
                placeholders: {
                    noteText: "Dear Future Self....",
                    nameText: ""
                }
            }
        },

        computed: {

            creationTimestamp: function () {
                if ( this.note.created_at ) return this.note.created_at;
                return this.note.createdAt;
            },

            name: {
                get: function () {
                    return this.note.name;
                },
                set: function ( v ) {
                    let pl = Payload.factory( {
                        obj: this.note,
                        updateProp: 'name',
                        updateVal: v
                    } );
                    this.$store.commit( mTypes.updateNote, pl );
                }
                   },

            /**
             * The actual note object
             */
//             note: function () {
//                 //if its in the noteObject spot, it is an instance of Note
//                 //so we can just return it
//                 if ( this.noteObject ) return this.noteObject;
//
//                 //However, if we loaded the notes directly, it may just be a json returned from the
//                 //server. So we take the object and make a Note which gets stored in noteObject
//                 if ( this.object ) {
//                     if ( _.isUndefined( this.object.kind ) ) this.noteObject = Note.factory( this.object );
// //                    if(! this.object instanceof Note) this.object = Note.factory(this.object);
//                     return this.noteObject;
//                 } else {
//                     return this.$store.getters[ gTypes.getNoteBySerialNumber ]( this.serialNumber );
//                 }
//
//             },

            priorityClass: function () {
                return this.note.styleString();
            },

            priority: {
                get: function () {
                    return this.note.priority;
                },
                set: function ( v ) {
                    let pl = Payload.factory( {
                        obj: this.note,
                        updateProp: 'priority',
                        updateVal: v
                    } );
                    this.$store.commit( mTypes.updateNote, pl );
                    }
                },

                props: {
                    get: function () {
                        return this.note.props;
                    },
                    set: function ( v ) {
                        let pl = Payload.factory( {
                            obj: this.note,
                            updateProp: 'props',
                            updateVal: v
                        } );
                        this.$store.commit( mTypes.updateNote, pl );
                    }
                },

                text: {
                    get: function () {
                        return this.note.text;
                    },
                    set: function ( v ) {
                            let pl = Payload.factory( {
                                obj: this.note,
                                updateProp: 'text',
                                updateVal: v
                            } );
                            this.$store.commit( mTypes.updateNote, pl );
                        }
                },

                updatedTimestamp: function () {
                    if ( this.note.updated_at ) return this.note.updated_at;
                    return this.note.updatedAt;
                },


            },

            methods: {
                getId: function ( identifier ) {
                    return identifier + '-' + this.serialNumber;
                },

                handleDeleteClick: function () {
                    window.console.log( 'note-area', 'handleDeleteClick', 190, this.note );

                    if ( this.useCentralStore ) {
                        this.$store.commit( mTypes.destroyNote, Payload.factory( { obj: this.note } ) );
                    } else {
                        let me = this;
                        let p = destroyNoteRequest( null, this.note );
                        p.then( function () {
                            me.$emit( 'note-deleted' );
                        } );
                    }
                }
            },


        }
</script>