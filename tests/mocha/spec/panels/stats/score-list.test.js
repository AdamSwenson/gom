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


//tested stuff
var Component = require( "../../../../../resources/assets/js/development/components/panels/stats/score-list.vue" );


describe( "score-list   ", () => {

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


        getters = {
            getItemBySerialNumber: ( v ) => ( v ) => {
                return item;
            },
            getStatsForItem: (v)=>(v)=>{ return scoreListAjaxResponse; }
        };

        mutations = {
            getStatsForItem : sinon.spy()
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

        it( " test store has been set up properly ", () => {
            expect( store.getters.getItemBySerialNumber() ).toBe( item );
        } );

        it( 'displays the expected component div on first load', () => {
            expect( wrapper.find( '.score-list' ).isEmpty() ).toBe( false );
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
                        expect(wrapper.vm.scores).toBe(scoreListAjaxResponse);
                        //check that the spy was called
                        expect(getItemScoresForStats.callCount).toBe(1);
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


    scoreListAjaxResponse = [ {
        "examId": 5,
        "itemId": 7,
        "score": 590.86,
        "kumis": [ {
            "id": 5,
            "user_id": 1,
            "year": 1989,
            "name": "Facere id dolorum eligendi.",
            "created_at": "2017-11-10 09:57:28",
            "updated_at": "2017-11-10 09:57:28",
            "pivot": {
                "student_id": 104,
                "kumi_id": 5,
                "created_at": "2017-11-10 09:57:28",
                "updated_at": "2017-11-10 09:57:28"
            }
        } ]
    }, {
        "examId": 5,
        "itemId": 7,
        "score": 537.06,
        "kumis": [ {
            "id": 5,
            "user_id": 1,
            "year": 1989,
            "name": "Facere id dolorum eligendi.",
            "created_at": "2017-11-10 09:57:28",
            "updated_at": "2017-11-10 09:57:28",
            "pivot": {
                "student_id": 103,
                "kumi_id": 5,
                "created_at": "2017-11-10 09:57:28",
                "updated_at": "2017-11-10 09:57:28"
            }
        } ]
    }, {
        "examId": 5,
        "itemId": 7,
        "score": 139.18,
        "kumis": [ {
            "id": 4,
            "user_id": 1,
            "year": 1988,
            "name": "Eum est ab eum sed.",
            "created_at": "2017-11-10 09:57:28",
            "updated_at": "2017-11-10 09:57:28",
            "pivot": {
                "student_id": 101,
                "kumi_id": 4,
                "created_at": "2017-11-10 09:57:28",
                "updated_at": "2017-11-10 09:57:28"
            }
        } ]
    }, {
        "examId": 5,
        "itemId": 7,
        "score": 60.47,
        "kumis": [ {
            "id": 4,
            "user_id": 1,
            "year": 1988,
            "name": "Eum est ab eum sed.",
            "created_at": "2017-11-10 09:57:28",
            "updated_at": "2017-11-10 09:57:28",
            "pivot": {
                "student_id": 102,
                "kumi_id": 4,
                "created_at": "2017-11-10 09:57:28",
                "updated_at": "2017-11-10 09:57:28"
            }
        } ]
    } ];


} );