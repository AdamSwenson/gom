<template>
    <div class="list-dropdown-component">

        <b-dropdown v-bind:text="title" variant="success" class="m-md-2">
            <b-dropdown-item v-for="i in toList" href="#">{{ i }}</b-dropdown-item>
        </b-dropdown>


        <!--<div class="input-group">-->

        <!--<div class="input-group-btn">-->
        <!--<button-->
        <!--class="btn btn-primary dropdown-toggle"-->
        <!--:title="title"-->
        <!--data-toggle="dropdown"-->
        <!--v-bind:id="buttonId"-->
        <!--&gt;{{ title }} <span class="glyphicon glyphicon-menu-down"></span></button>-->

        <!--<ul class="dropdown-menu"-->
        <!--id="dropdownList"-->
        <!--role="menu"-->
        <!--v-bind:aria-labelledby="buttonId"-->
        <!--aria-haspopup="true"-->
        <!--&gt;-->
        <!--<li v-for="i in toList">-->
        <!--<a href="#" v-on:click="notifySelect(i)">{{ i }}</a>-->
        <!--</li>-->
        <!--</ul>-->
        <!--</div>-->

        <!--<input type="text"-->
        <!--class="form-control"-->
        <!--v-model="selectedValue"-->
        <!--v-bind:aria-label="textLabel">-->
        <!--</div>-->

        <!--<div class="helpLink">-->
        <!--<a v-on:click="showHelp"-->
        <!--href="#">-->
        <!--<span class="glyphicon glyphicon-question-sign"></span>-->
        <!--</a>-->
        <!--</div>-->

    </div>
</template>

<style lang="scss">
    /*input {*/
    /*width: 3em;*/
    /*}*/

    /*.dropdown-menu{*/
    /*cursor: pointer;*/
    /*}*/

</style>

<script>
    import * as aTypes from '../../store/action-types';
    import * as mTypes from '../../store/mutation-types';
    import * as gTypes from '../../store/getter-types';

    import Payload from '../../models/Payload'

    export default {
        props: [ 'type' ],


        data: function () {
            return {
                defaults: {
                    term: {
                        buttonId: 'termButton',
                        title: 'Choose Term',
                        placeHolders: {},
                        listItems: [ 'fall', 'winter', 'spring', 'summer' ],
                        textId: 'termField',
                        textLabel: 'Record term here'
                    },

                    year: {
                        buttonId: 'yearButton',
                        title: 'Choose Year',
                        placeHolders: {},
                        listItems: [ 2017, 2018, 2019 ],
                        textId: 'yearField',
                        textLabel: 'Record year here'
                    },

                },
                types: [ 'term', 'year' ],

            };
        },

        computed: {
            buttonId: function () {
                let defaults = this.getForType();
                return defaults.buttonId;
            },

            /**
             * Returns a list of things to populate the dropdown with
             */
            toList: function () {
                let defaults = this.getForType();
                console.log( 'toList', defaults );
                return defaults.listItems;
            },

            title: function () {
                let defaults = this.getForType();
                return defaults.title;
            },

            selectedValue: {
                get: function () {
                    let exam = this.$store.getters[ gTypes.getActiveExamObj ];
                    let v = exam[ this.type ];
                    if ( typeof v != 'undefined' ) {
                        return v;
                    }
                },
                set: function ( v ) {
                    this.$store.commit( mTypes.updateActiveExamProp, Payload.factory( {
                        updateProp: this.type,
                        updateVal: v
                    } ) );
                }
            }


        },

        methods: {
            //Determines which set of settings to use
            getForType: function () {
                if ( this.type ) {
                    switch ( this.type ) {
                        case 'term':
                            return this.defaults.term;
                            break;
                        case 'year':
                            return this.defaults.year
                            break;
                        default:
                    }
                }
            },

            showHelp: function () {
                console.log( 'show help called' );
            },

            notifySelect: function ( data ) {
                console.log( 'notifySelect', 'clicked', data );
            }
        }
    }

</script>
