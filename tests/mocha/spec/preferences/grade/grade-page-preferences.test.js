//The name of the tested component
var compName = 'grade-page-preferences';
//The path to the tested component
var Component = require( '../../../../../resources/assets/js/development/components/preferences/grade/grade-page-preferences.vue' );

var Mixin = require( '../../../../../resources/assets/js/development/components/preferences/preferencesPage.mixin' );


require( '../../../injectglobals' );
import { assertExpectedDivIsDisplayed } from '../../../helpers/assertions';
import { mount, shallow, createLocalVue, RouterLinkStub } from 'vue-test-utils';

const localVue = createLocalVue();

localVue.use( Vuex )
// localVue.use(VueRouter);

describe( compName, () => {

    let componentDivIdentifier = '.' + compName;

    let getters, actions;
    let mutations;
    let store;
    let wrapper;
    let $route = { params: { serialNumber: null }, path: 'taco' };

    beforeEach( () => {

        actions = {
            [ ngaTypes.loadGradePreferencesFromServer ]: () => () => sinon.spy()
        };

        $route.params.serialNumber = factories.itemFactory().serialNumber;

        let stub = sinon.stub( Mixin.methods, 'loadDefaultRoute' );
        mutations = {};

        store = new Vuex.Store( {
            actions,
            mutations
        } );
// let $router = {push: sinon.spy()};
        const mixin = {};
        const router = new VueRouter()
        wrapper = shallow( Component, {
            store, localVue, router,
            mixins: [ Mixin ],
            // stubs: RouterLinkStub,
            // stubs: [ 'router-link', 'router-view' ],
            mocks: {
                $route,
                // $router
            }
        } );

    } );


    describe( " loads into expected default state for testing ", () => {
        it( 'displays the expected component div on first load', () => {
            assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );
    } );

    describe.skip( " TESTS NEEDED", () => {
        it( 'awaits tests' )
    } );


} );
