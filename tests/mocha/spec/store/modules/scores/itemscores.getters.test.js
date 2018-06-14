//test libraries
require( '../../../../injectglobals' );

//
// import { testAction, description, factories } from '../../../../../spec/helpers/vuex.spec.helpers';


import getters from '../../../../../../resources/assets/js/store/modules/scores/itemscores.getters';

import { createLocalVue } from 'vue-test-utils';
const localVue = createLocalVue();
localVue.use( Vuex )


import { itemscores } from "../../../../helpers/state-factories";
let { makePopulatedState, makeState } = itemscores;


describe( "itemscores.getters ", function () {
    let state;
    let testExam;
    let testItem;
    let testStudent;
    let testScore;
    let testText;
    let store;

    beforeEach( function () {
        testExam = factories.examFactory();
        testItem = factories.itemFactory();
        testStudent = factories.studentFactory();
        testScore = faker.random.number();
        testText = faker.company.bs();


        state = makePopulatedState();
        store = new Vuex.Store({
            state, getters
        });


    } );

    describe( nggTypes.getItemScoreObject, function () {
        it( "happy path ", function () {

            let testObj = state.scores[ 1 ];
            let payload = { item: { id: testObj.itemId }, student: { id: testObj.studentId } };

            return (function(){
                let result = store.getters[nggTypes.getItemScoreObject](payload);
                //(function(){ return getters[ nggTypes.getItemScoreObject ]( state, {}, {}, payload );})();
                expect( result.examId ).toBe( testObj.examId );
                expect( result.itemId ).toBe( testObj.itemId );
                expect( result.studentId ).toBe( testObj.studentId );
            })();

        } );
    } );
} );
