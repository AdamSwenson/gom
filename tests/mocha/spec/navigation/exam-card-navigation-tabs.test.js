//The name of the tested component
var compName = 'exam-card-navigation-tabs';
//The path to the tested component
var Component = require( '../../../../resources/assets/js/development/components/navigation/exam-card-navigation-tabs.vue' );

require( '../../injectglobals' );
import { mount, shallow, createLocalVue } from 'vue-test-utils';

const localVue = createLocalVue();

localVue.use( Vuex )

describe( compName, () => {

    let componentDivIdentifier = '.' + compName;

    let getters;
    let mutations;
    let store;
    let wrapper;
    let exam;
    let $route;
    let spy1, spy2;

    beforeEach( () => {

        spy1 = sinon.spy();

        getters = {
            [ gTypes.isExamSettingsVisible ]: () => () => false,
            //
            // [gTypes.getHeightOfNode] : (  ) => () => 3,
            // getItemBySerialNumber : (  ) =>(  ) => factories.itemFactory(),
            // getDepthOfNode: (  ) => (  ) => 3

        };
        exam = factories.examFactory();
        mutations = {
            [ mTypes.toggleExamSettings ]: spy1
        };

        store = new Vuex.Store( {
            getters,
            mutations
        } );

        $route = { path: '/' };
        //
        // wrapper = shallow( Component, {
        //     store, localVue, propsData: { exam },
        //     mocks: {$route}
        // } );

    } );


    describe( " loads into expected default state for testing ", () => {
        it( 'displays the expected component div on first load', () => {
            wrapper = shallow( Component, {
                store, localVue, propsData: { exam },
                mocks: { $route }
            } );

            assertions.assertExpectedDivIsDisplayed( wrapper, componentDivIdentifier );
        } );

        it( ' see expected labels', () => {
            wrapper = shallow( Component, {
                store, localVue, propsData: { exam },
                mocks: { $route }
            } );

            _.forEach( wrapper.vm.routes, function ( route ) {
                expect( assertions.assertThatSeeText( wrapper, _.capitalize( route.label ) ) );
            } );
        } )
    } );

    describe( "watcher correctly manages the display state", () => {
        it( "opens the exam settings pane when one of the tabs is selected", () => {


            wrapper = shallow( Component, {
                store, localVue, propsData: { exam },
                mocks: { $route }
            } );
            // wrapper.vm.togglePaneVisibility();
            $route.path = wrapper.vm.routes[ 0 ].path;
            wrapper.setData( { $route } );

            expect( spy1.called ).toBeTruthy();


        } );

        it( "closes the pane when the url is changed by another process", () => {
            getters[ gTypes.isExamSettingsVisible ] = () => () => true;
            $route.path = wrapper.vm.routes[ 0 ].path;

            store = new Vuex.Store( {
                getters,
                mutations
            } );


            wrapper = shallow( Component, {
                store, localVue, propsData: { exam },
                mocks: { $route }
            } );

            $route.path = '/';
            expect( spy1.called ).toBeTruthy();
        } );
    } )


} );
