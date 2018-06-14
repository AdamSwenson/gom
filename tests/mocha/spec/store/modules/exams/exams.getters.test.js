
//The name of the tested component
var compName = 'exams.getters';
//The path to the tested component
import getters from '../../../../../../resources/assets/js/store/modules/exams/exams.getters.js' ;


require( '../../../../injectglobals' );

import { createLocalVue } from 'vue-test-utils';
const localVue = createLocalVue();
localVue.use( Vuex )

//tested object
describe( compName, () => {
    let listOfValues, test;
    let payload, exam, item, kumi, kumis, student, grade;
    let store, state;
    
    beforeEach( () => {
        state = {};
        store = new Vuex.Store({
            state, getters
        });

    } );


    describe( " actions", () => {
        it.skip( 'awaits tests', () => {
             } );
    } );


    describe( " getters", () => {
        it.skip( 'awaits tests', () => {
        } );
    } );


    describe( " mutations ", () => {
        it.skip( 'awaits tests', () => {
        } );
    } );

} );
