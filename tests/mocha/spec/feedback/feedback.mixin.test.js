//The name of the tested component
var compName = 'feedback.mixin';
//The path to the tested component
var Component = require( '../../../../resources/assets/js/development/components/feedback/feedback.mixin.js' );

import sinon from 'sinon';
import moxios from 'moxios';
import faker from 'faker';

//helpers
// import { see } from '../../helpers/test-helpers';
// import { factories } from '../../helpers/vuex.spec.helpers';
//
//
// import * as mTypes from "../../../../../resources/assets/js/store/mutation-types";
// import * as gTypes from "../../../../../resources/assets/js/js/store/getter-types";
// import * as nggTypes from "../../../../../resources/assets/js/store/new-grading-getter-types";

// localVue.use( VueRouter );


//tested stuff


describe( compName, () => {

    let componentDivIdentifier = '.' + compName;

    let getters;
    let mutations;
    let store;
    let wrapper;
    let obj;

    beforeEach( () => {
        obj = Component;
    } );


    describe( " loads into expected default state for testing ", () => {
        it( 'loads object', () => {
            expect( obj ).not.toBeEmpty();
        } );
    } );

    describe( " TESTS NEEDED", () => {
        it( 'awaits tests' )
    } );


} );
