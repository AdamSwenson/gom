<template>

    <div class="note-area"
         v-bind:id="getId('note-area')"
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
                    <p class="help">This is a help text</p>
                </div>
            </div>

            <div class="field">
                <label class="label">Note</label>
                <div class="control">
                <textarea class="textarea"
                          rows="3"
                          v-bind:placeholder="placeholders.noteText"
                          v-model="text"></textarea>
                </div>
            </div>

        </div>
        <!--<div class="field">-->
        <!--<div class="control">-->
        <!--<button class="button is-outlined"-->
        <!--v-on:click="handleSave">Save-->
        <!--</button>-->
        <!--</div>-->
        <!--<div class="control">-->
        <!--<button v-on:click="handleClear"-->
        <!--class="button is-outlined">Clear-->
        <!--</button>-->
        <!--</div>-->
        <!--</div>-->

        <div class="message "
             v-else
             v-bind:class="priorityClass"
        >
            <div class="message-header">
                <p>{{ name }}</p>
                <button class="delete" v-on:click="handleDeleteClick"></button>
            </div>

            <div class="message-body">
                <div class="note-text-display">
                    {{ text }}
                </div>
                <div class="level timestampArea">
                    <!-- Left side -->
                    <div class="level-left">
                        <div class="level-item has-text-centered">
                            <div>
                                <p class="heading">Created: {{ creationTimestamp }}  |  Updated: {{ updatedTimestamp
                                    }}</p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </div>
</template>

<style lang="scss">
    .note-area {
        .message {
            margin-bottom: 0.5em;
        }
    }

</style>

<script>
    import * as aTypes from '../../../../store/action-types';
    import * as mTypes from '../../../../store/mutation-types';
    import * as gTypes from '../../../../store/getter-types';
    import Note from '../../../../models/Note';
    import Payload from '../../../../models/Payload';

    export default {

        props: [ 'serialNumber' ],

        components: {},

        data: function () {
            return {
                priorityStyles: Note.priorityStyles(),
//                    {
//                    0: 'is-dark',
//                    1: 'is-primary',
//                    2: 'is-info',
//                    3: 'is-warning',
//                    4: 'is-danger'
//                },

                isEditable: false,

                defaults: {},
                noteNameLabel: "Title",
                placeholders: {
                    noteText: "Dear Future Self....",
                    nameText: ""

                }
            }
        },

        computed: {
            /**
             * The actual note object
             */
            note: function () {
                return this.$store.getters[ gTypes.getNoteBySerialNumber ]( this.serialNumber );
            },

            creationTimestamp: function () {
                return this.note.createdAt;
            },

            updatedTimestamp: function () {
                return this.note.updatedAt;
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

            priorityClass: function () {
                if ( this.note.priority ) {
                    return this.priorityStyles[ this.note.priority ];
                }
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
            }


        },

        methods: {
            getId: function ( identifier ) {
                return identifier + '-' + this.serialNumber;
            },

            handleDeleteClick: function () {
                window.console.log( 'note-area', 'handleDeleteClick', 190, this.note );
                this.$store.commit( mTypes.destroyNote, Payload.factory( { obj: this.note } ) );
            },

            handleClear: function () {

            },

            handleSave: function () {

            },

            handleEditClick: function () {

            }
        },

        directives: {},

        events: {},

        mounted: function () {
        }
    }
</script>