<template>
    <!-- Template used by 'edit_element' to hold the fields and buttons for an individual element.  -->
    <div
            class="item-settings-comment-setup-component">

        <div class="row">
            <div class="col-md-12 ">

                <h5>Set up your comments for this item</h5>
                <!-- element description (the "stock comment") -->
                <div class="form-group">
                        <textarea
                                class="form-control"
                                rows="3"
                                v-bind:placeholder="placeholders.elementText"
                                v-model="commentText"></textarea>
                </div>

                <valence-buttons :index="index"></valence-buttons>
                <!--<div class="btn-group-justified"-->
                <!--role="group"-->
                <!--aria-label="valence buttons">-->

                <!--<valence-button-->
                <!--v-for="v in valences"-->
                <!--:valence="v"></valence-button>-->

                <!--</div>-->
                <!--</div>-->

            </div>

        </div>
    </div>

</template>
<style>

</style>
<script>

    import Comment from '../../models/Comment'
    import Payload from '../../models/Payload'
    import * as mTypes from '../../store/mutation-types';
    import * as aTypes from '../../store/action-types';
    import * as gTypes from '../../store/getter-types';
    import valenceButtons from './input/buttons.valence.component.vue'

    /**
     * The comment details setup area
     * Created by adam on 2/19/17.
     */
    export default {
        components: {
            valenceButtons, // 'valence-buttons': valenceButtons,
        },

        props: [ 'index' ],

        data: function () {
            return {

                displayed: 'stock',

                defaults: {
                    commentText: ''
                },
                placeholders: {
                    elementName: "Enter a short reminder for this element, e.g., &quot;Economic causes of World War I&quot; ",
                    elementText: "Explain in detail what needed to be done in order to fully complete this task. This will form the basis for the response seen by the student.",
                },
            };
        },


        /*
         One thing to note when using routes with params is that when the user navigates from /user/foo to /user/bar,
         the same component instance will be reused. Since both routes render the same component, this is more efficient
         than destroying the old instance and then creating a new one. However, this also means that the lifecycle
         hooks of the component will not be called.
         To react to params changes in the same component, you can simply watch the $route object:
         */
        watch: {
            '$route' ( to, from ) {
                // react to route changes...
            }
        },
        computed: {

            commentText: {
                get: function () {
                    let item = this.$store.getters.getItemByIndex(this.$route.params.index);
                    if ( typeof item !== 'undefined' ) {
                        let comment = item.getComment(this.displayed);
                        if ( typeof comment !== 'undefined' ) {
                            return comment.text;
                        }
                    }
                },

                set: function ( v ) {
                    window.console.log('panel.comment-setup.component', 'set', 97, this.index, this);
                    let pl = Payload.factory({
                        index: this.$route.params.index,
                        updateValence: this.displayed,
                        updateVal: v
                    });
                    window.console.log('set', 101, pl);
                    this.$store.commit(mTypes.updateComment, pl);
                }
            },

            displayedValence: {
                get: function () {
                    return this.displayed;
                },

                set: function ( newValence ) {
                    if ( newValence ) {
                        let idx = Comment.valences.indexOf(newValence);
                        if ( idx >= 0 ) {
                            this.displayed = Comment.valences[ idx ];
                        }
                    }
                }
            },


            valences: function () {
                return Comment.valences;
            }

        },

        methods: {
            getter: function ( name ) {
                let item = this.$store.getters.getItemByIndex(this.$route.params.index);
                if ( typeof item !== 'undefined' ) {
                    return item[ name ]
                }
            },

            setter: function ( name, value ) {
                let pl = Payload.factory({index: this.$route.params.index, updateProp: name, updateVal: value});
                this.$store.commit(mTypes.updateItem, pl);
            },


            /**
             * Alters which valence is displayed.
             * Called by child components
             */
            changeDisplayedValence: function ( newValence ) {
                window.console.log('changeDisplayedValence', 130, newValence);
                if ( newValence ) {
                    this.displayedValence = newValence;
                }
            }
        },


        directives: {},

        events: {
            'please-change-valence': function ( evt ) {
                console.log('caught please-change-valence', evt);
                this.displayedValence = evt;
            }
        },

        mounted: function () {
//            window.console.log('panel.comment-setup.component', 'mounted', 166, this.index);
        },
    };
</script>
