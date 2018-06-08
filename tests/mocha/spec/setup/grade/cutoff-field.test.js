//The name of the tested component
var compName = 'cutoff-field';
//The path to the tested component
var Component = require( '../../../../../resources/assets/js/development/components/setup/grade/cutoff-field.vue' );


import GradeAssignment from '../../../../../resources/assets/js/models/GradeAssignment';


require( '../../../injectglobals' );
import { mount, shallow, createLocalVue } from 'vue-test-utils';


const localVue = createLocalVue();

localVue.use( Vuex )

describe( compName, () => {

    let componentDivIdentifier = '.' + compName;

    let getters;
    let mutations;
    let store;
    let wrapper;

    let grade, itemProp;
    let payload, test;

    beforeEach( () => {
        grade = new GradeAssignment();

        // payload = Payload.factory({
        //     obj: item,
        //     updateProp: itemProp,
        //     updateValue: test})

        getters = {
            [ gTypes.getInconsistentCutOffs ]: () => []
        };

        mutations = {
            [ mTypes.updateGradeCutoffs ]: sinon.spy()
        };

        store = new Vuex.Store( {
            getters,
            mutations
        } );

        wrapper = shallow( Component, {
            store, localVue,
            propsData: { grade }
        } );

    } );


    describe( " loads into expected default state for testing ", () => {
        it( 'displays the expected component div on first load', () => {
            assertions.assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );

    describe( 'computed properties', () => {
        it( 'minScore -- setter works as expected', () => {
            let test = 54;
            helpers.type( wrapper, 'input', test );
            expect( mutations[ mTypes.updateGradeCutoffs ].calledOnce ).toBe( true );
        } );
    } );


} );
