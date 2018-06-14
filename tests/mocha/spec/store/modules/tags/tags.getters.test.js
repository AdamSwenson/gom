
var compName = 'tags.getters';
//The path to the tested component
import getters from  '../../../../../../resources/assets/js/store/modules/tags/tags.getters.js' ;


require( '../../../../injectglobals' );

//tested object

import { createLocalVue } from 'vue-test-utils';
const localVue = createLocalVue();
localVue.use( Vuex )


describe( compName, () => {
    let listOfValues, test;
    let store, state, payload, exam, item, kumi, kumis, student, grade;
    
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
