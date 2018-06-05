
//The name of the tested component
var compName = 'scoreInputMixin';
//The path to the tested component
var Component = require('../../../../../resources/assets/js/development/components/grading/inputs/scoreInputMixin.js');

import sinon from 'sinon';
import moxios from 'moxios';
import faker from 'faker';

//helpers
// import { see } from '../../../helpers/test-helpers';
import { assertExpectedDivIsDisplayed } from '../../../helpers/assertions';
// import { factories } from '../../../helpers/vuex.spec.helpers';
//
//
// import * as mTypes from "../../../../../resources/assets/js/store/mutation-types";
// import * as gTypes from "../../../../../resources/assets/js/js/store/getter-types";
// import * as nggTypes from "../../../../../resources/assets/js/store/new-grading-getter-types";




describe(  compName , () => {

    let componentDivIdentifier = '.' + compName;
    let obj;
    let getters;
    let mutations;
    let store;
    let wrapper;

    beforeEach( (  ) => {
        obj = Component

    } );


    describe( " loads into expected default state for testing ", () => {
        it( 'loaded instance', () => {
            expect(obj).not.toBeEmpty()
        } );
    } );
    
    describe(" TESTS NEEDED", () => {
        it('awaits tests')        
    });


});
