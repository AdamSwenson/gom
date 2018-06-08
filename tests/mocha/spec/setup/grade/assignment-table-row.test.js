//The name of the tested component
var compName = 'assignment-table-row';
//The path to the tested component
var Component = require( '../../../../../resources/assets/js/development/components/setup/grade/assignment-table-row.vue' );

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

        mutations = {};

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

    describe( 'computed p;roperties', () => {
        describe( 'isInconsistent', () => {
            it( "returns false when the grade is not on the inconsistent list", () => {
                expect( wrapper.vm.isInconsistent ).toBe(false);
            } )
            it( "returns true if the grade is on the inconsistent list", () => {
                getters[ gTypes.getInconsistentCutOffs ] = () => [ grade ];

                store = new Vuex.Store( {
                    getters,
                    mutations
                } );

                wrapper = shallow( Component, {
                    store, localVue,
                    propsData: { grade }
                } );

                expect( wrapper.vm.isInconsistent ).toBe(true);
            } );
        } )
    } );

} );
