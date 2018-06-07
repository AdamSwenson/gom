
//The name of the tested component
var compName = 'finish-button';
//The path to the tested component
var Component = require('../../../../../resources/assets/js/development/components/grading/inputs/finish-button.vue');


import { mount, shallow, createLocalVue } from 'vue-test-utils';

require( '../../../injectglobals' );


const localVue = createLocalVue();

localVue.use( Vuex )


describe(  compName , () => {

    let componentDivIdentifier = '.' + compName;

    let getters;
    let mutations;
    let store;
    let wrapper;

    beforeEach( (  ) => {

        getters = {   };

        mutations = {};

        store = new Vuex.Store( {
            getters,
            mutations
        } );

        wrapper = shallow( Component, {
            store, localVue
        } );

    } );


    describe( " loads into expected default state for testing ", () => {
        it( 'the item is not displayed by default', () => {
            // wrapper.vm.isFinishButtonVisible = true;
            expect(wrapper.find(componentDivIdentifier).exists()).toBe(false);
            // assertions.assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );
    
    // describe(" TESTS NEEDED", () => {
    //     it('awaits tests')
    // });


});
