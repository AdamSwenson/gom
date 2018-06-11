
//The name of the tested component
var compName = 'comment-setup-panel';
//The path to the tested component
var Component = require('../../../../resources/assets/js/development/components/setup/comment-setup-panel.vue');



require( '../../injectglobals' );
import { mount, shallow, createLocalVue } from 'vue-test-utils';

const localVue = createLocalVue();

localVue.use( Vuex )

describe( compName, () => {

    let componentDivIdentifier = '.' + compName;

    let getters, mutations, actions, store;

    let wrapper;

    let listOfValues, test;
    let payload, exam, item, kumi, kumis, student, grade;

    beforeEach( () => {
        actions = {}

        getters = {};

        mutations = {};

        store = new Vuex.Store( {
            getters, mutations, actions
        } );

        wrapper = shallow( Component, {
            store, localVue
        } );

    } );


    describe( " loads into expected default state for testing ", () => {
        it( 'displays the expected component div on first load', () => {
            assertions.assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );

    describe( "methods", () => {
        it( " calls for the correct mutation when ....", () => {
        } );
    } )


} );
