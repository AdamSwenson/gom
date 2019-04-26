<style>

</style>
<script>
    import { assignDefaultCommentsToGradedItems } from '../../../../api/requests/commentRequests';
    import buttonBase from '../../input/button-base';
    import * as gTypes from '../../../../store/getter-types';

    export default {
        name: 'add-child-button',

        extends: buttonBase,

        data: function () {
            return {
                //define the properties of the button
                isRunning: false,
                showError: false,
            };
        },

        computed: {
            exam: function () {
                return this.$store.getters[ gTypes.getActiveExam ];
            },
            local: function () {
                let cls = this.isRunning ? 'is-warning ' : 'is-primary is-outlined';

                if ( this.showError ) cls = 'is-danger';

                return {
                    buttonText: 'Assign comments to graded exams',
                    icon: "fa fa-list-alt",
                    identifyingClass: 'assign-comments',
                    linkClass: cls,
                    linkTitle: 'Assign comments to graded exams',
                    screenReaderText: 'Assigns default comments to exams which have already been graded.',
                }
            },


            //
            // localLinkTitle: function () {
            //     if ( this.isExam ) return 'Add an item to this exam';
            //     return 'Add a new item as a child of this item';
            // },
            //
            //
            // localButtonText: function () {
            //     if ( this.isExam ) return 'Add Item';
            //     return 'Add Child';
            // },
            //
            // localScreenReaderText: function () {
            //     if ( this.isVisible ) return 'Click to add an item to this exam';
            //     return 'Click to add a child to this item';
            // },

        },

        methods: {
            handleError: function () {
                this.isRunning = false;
                this.showError = true;
                let me = this;
                alert( 'Something went wrong (oh, and this needs to be replaced with a real notification)' );
                setTimeout( function () {
                    me.showError = false;
                }, 200 );
            },

            /**
             * Called on click.
             * It in turn calls a handler
             */
            handleClick: function () {
                window.console.log( 'assign-comments-to-graded-button', 'handleClick', 60, );
                let me = this;
                this.isRunning = true;
                // console.log( 'CALLED', 'add', this.serialNumber );
                assignDefaultCommentsToGradedItems( this.exam )
                    .then( function () {
                        window.console.log( 'assign-comments-to-graded-button', 'done', 63, );
                        me.isRunning = false;
                    } ).catch( function () {
                    window.console.log( 'assign-comments-to-graded-button', 'error', 73, );
                    me.handleError();
                } );


            },

            /**
             * This sends the actual request(s)
             */
            sendRequest: function () {
            }
        },

    }
</script>
