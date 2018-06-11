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
// localVue.use( VueRouter );


//tested stuff
var Component = require( "../../../../../resources/assets/js/development/components/stats/item-summary-stats.vue" );


describe( "item-summary-stats  ", () => {

    let getters;
    let mutations;
    let store;
    let item;
    let $route = { params: { serialNumber: null } };
    let wrapper;
    let routeSerialNumber;

    beforeEach( () => {
        item = new Item();
        routeSerialNumber = item.serialNumber;

        // import and pass your custom axios instance to this method
        moxios.install()


        getters = {
            getItemBySerialNumber: ( v ) => ( v ) => {
                return item;
            }
        };

        mutations = {};

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
            expect( wrapper.find( '.item-stat-summary' ).isEmpty() ).toBe( false );
        } );

    } );

    describe( " displays expected data after loading  async   ", () => {
        let expected = {};
        let getItemSummaryStats;
        let getItemScoreSummaryForExam;
        let getItemScoreSummariesByKumis;

        it( " displays the item score summary for the current exam ", () => {
            let summaryForItem = {
                maxScore: 590.86,
                mean: 331.8925,
                median: 338.12,
                minScore: 60.47,
                numberAnswers: 4,
                percentile25: "139",
                percentile75: "591",
                standardDeviation: 234.50274533308
            };

            wrapper.setProps( {
                item: item,
                scope: 'exam'
            } );

            moxios.wait( function () {
                let request = moxios.requests.mostRecent();
                request
                    .respondWith( {
                        status: 200,
                        response: [ summaryForItem ]
                    } )
                    .then( function () {
                        //check that values were set from axios response
                        _.forEach( summaryForItem, function ( v, k ) {
                            expect( wrapper.vm.summary[ k ] ).toBe( v )
                        } );
                    } );
            } );
        } );

        it( " displays the item score summary for every exam " ); //, () => {} );

        it( " displays a list of scores from the present exam  " ); //, () => {} );

        it( " displays item score summaries by kumi " ); //, () => {} );

        it( " stats for item where graded over several exams " ); //, () => {} );
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

    let summaryForItem = {
        maxScore: 590.86,
        mean: 331.8925,
        median: 338.12,
        minScore: 60.47,
        numberAnswers: 4,
        percentile25: "139",
        percentile75: "591",
        standardDeviation: 234.50274533308
    };

    let r = [ {
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

    let summaryByKumi = [ {
        "kumiId": 4,
        "kumiName": "Eum est ab eum sed.",
        "mean": 99.825,
        "standardDeviation": 39.355,
        "maxScore": 139.18,
        "minScore": 60.47,
        "numberAnswers": 2,
        "scores": {
            "1": { "item_id": 7, "score": 60.47, "exam_id": 5, "kumi_id": 4 },
            "0": { "item_id": 7, "score": 139.18, "exam_id": 5, "kumi_id": 4 }
        },
        "median": 99.825
    }, {
        "kumiId": 5,
        "kumiName": "Facere id dolorum eligendi.",
        "mean": 563.96,
        "standardDeviation": 26.9,
        "maxScore": 590.86,
        "minScore": 537.06,
        "numberAnswers": 2,
        "scores": [ { "item_id": 7, "score": 537.06, "exam_id": 5, "kumi_id": 5 }, {
            "item_id": 7,
            "score": 590.86,
            "exam_id": 5,
            "kumi_id": 5
        } ],
        "median": 563.96
    } ];

} );


//
//     beforeEach(  ()=> {
// //runs before each test
// //         let component = mount( commentPanel );
//
//     })

