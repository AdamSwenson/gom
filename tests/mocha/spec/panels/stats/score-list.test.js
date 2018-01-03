import { mount, shallow, createLocalVue } from 'vue-test-utils';
import sinon from 'sinon';
// import VueRouter from 'vue-router';
import Vuex from 'vuex';
// import Vue from 'vue';
import moxios from 'moxios';

//helpers
// import { see } from '../../helpers/test-helpers';

import Item from "./../../../../../resources/assets/js/models/Item";

const localVue = createLocalVue();

localVue.use( Vuex )

import { assertExpectedDivIsDisplayed } from '../../../helpers/assertions';
import { makeScoreListServerResponse } from '../../../helpers/factories';


//tested stuff
var Component = require( "../../../../../resources/assets/js/development/components/panels/stats/score-list.vue" );


describe( "score-list   ", () => {
    let componentDivId = '.score-list';
    let getters;
    let mutations;
    let store;
    let item;
    let $route = { params: { serialNumber: null } };
    let wrapper;
    let routeSerialNumber;
    let scoreListAjaxResponse;

    beforeEach( () => {
        item = new Item();
        routeSerialNumber = item.serialNumber;

        // import and pass your custom axios instance to this method
        moxios.install()

        scoreListAjaxResponse  = makeScoreListServerResponse();

        getters = {
            getItemBySerialNumber: ( v ) => ( v ) => {
                return item;
            },
            getAnonScoresForItemStats: ( v ) => ( v ) => {
                return scoreListAjaxResponse;
            }
        };

        mutations = {
            getAnonScoresForItemStats: sinon.spy()
        };

        store = new Vuex.Store( {
            getters,
            mutations
        } );

        $route.params.serialNumber = item.serialNumber;


        wrapper = shallow( Component, {
            store, localVue,
            stubs: [ 'router-link', 'router-view' ],
            mocks: {
                $route
            }
        } );

    } );

    afterEach( function () {
        // import and pass your custom axios instance to this method
        moxios.uninstall()
    } )

    describe( " loads into expected default state for testing ", () => {

        it( 'displays the expected component div on first load', () => {
            assertExpectedDivIsDisplayed( wrapper, componentDivId );
        } );

    } );


    describe( " displays expected data after loading  async   ", () => {
        let expected = {};
        let getItemScoresForStats;

        it( " displays the list of scores  ", () => {
            wrapper.setProps( {
                item: item
            } );

            getItemScoresForStats = sinon.stub();
            getItemScoresForStats.returns( scoreListAjaxResponse );

            moxios.wait( function () {
                let request = moxios.requests.mostRecent();
                request
                    .respondWith( {
                        status: 200,
                        response: [ summaryForItem ]
                    } )
                    .then( function () {
                        //check that values were set from axios response
                        expect( wrapper.vm.scores ).toBe( scoreListAjaxResponse );
                        //check that the spy was called
                        expect( getItemScoresForStats.callCount ).toBe( 1 );
                    } );
            } );


        } );
    } );

    /**
     * Asserts that the specified text is present within
     * the specified selector or page if no selector is
     * specified
     * @param text
     * @param selector
     */
    let see = ( text, selector ) => {
        let wrap = selector ? wrapper.find( selector ) : wrapper;
        expect( wrap.html() ).toContain( text );
    };
} );
