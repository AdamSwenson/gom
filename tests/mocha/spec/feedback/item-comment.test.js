
//The name of the tested component
var compName = 'item-comment';
//The path to the tested component
var Component = require('../../../../resources/assets/js/development/components/feedback/item-comment.vue');

require('../../injectglobals');
import { mount, shallow, createLocalVue } from 'vue-test-utils';
import { assertExpectedDivIsDisplayed } from '../../helpers/assertions';

const localVue = createLocalVue();

localVue.use( Vuex )
describe(  compName , () => {

    let componentDivIdentifier = '.' + compName;

    let getters;
    let mutations;
    let store;
    let wrapper;
    let obj;

    beforeEach( (  ) => {
        obj = factories.itemScoreFactory()

        getters = {
            [nggTypes.getItemScoreObject] : (  ) => (  ) => obj




        };

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
        it( 'displays the expected component div on first load', () => {
            assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );
    
    describe.skip(" TESTS NEEDED", () => {
        it('awaits tests')        
    });


});
