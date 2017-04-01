<template>
    <div class="panel-notes-component">
        <!--tab-pane"-->
        <!--role="tabpanel"-->

        <div class="row">
            <div class="col-md-12">

                <h3>Saved notes to self display here</h3>

            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h5>Add note to your future self</h5>
                <div class="form-group">
                        <textarea class="form-control"
                                  rows="3"
                                  v-bind:placeholder="placeholders.noteText"
                                  v-model="noteText"></textarea>
                </div>
                <button class="btn btn-success"
                        v-on:click="saveNote"><span
                        class="glyphicon glyphicon-plus"></span></button>
            </div>
        </div>

    </div>
</template>
<style>

</style>
<script>
    import * as aTypes from '../../store/action-types';
    import * as mTypes from '../../store/mutation-types';

    import Payload from '../../models/Payload'

    export default {
//        props: ['index'],

        data: function () {
            return {
                index: this.$route.params.index,
                placeholders: {

                    noteText: "Write something you want to remember about this item here"
                },
            };
        },

        computed: {
            noteText: {
                get: function () {
                },
                set: function ( v ) {
                }
            }

        },

        methods: {
            saveNote: function () {
                window.console.log('panel.notes.component', 'saveNote', 65,);
            }
        }
    }
</script>
