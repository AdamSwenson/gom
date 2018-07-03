
//The name of the tested component
var compName = 'preferencesInput.mixin';
//The path to the tested component
var Component = require('../../../../resources/assets/js/development/components/preferences/preferencesInput.mixin.js');

require('../../injectglobals');

import { mount, shallow, createLocalVue } from 'vue-test-utils';
import { assertExpectedDivIsDisplayed } from '../../helpers/assertions';


const localVue = createLocalVue();

localVue.use( Vuex )
// localVue.use( VueRouter );


//tested stuff



describe(  compName , () => {
let obj;
    beforeEach( (  ) => {
obj = Component;
    } );


    describe( " loads into expected default state for testing ", () => {
     } );
    
    describe.skip(" TESTS NEEDED", () => {
        it('awaits tests')        
    });


});
