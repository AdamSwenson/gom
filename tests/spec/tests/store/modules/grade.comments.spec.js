//test libraries
require('jasmine-jquery');
require('sinon');

//Dependencies
import * as active from '../../../../../resources/assets/js/store/modules/grade.comments';
import * as types from '../../../../../resources/assets/js/store/mutation-types'
import * as aTypes from '../../../../../resources/assets/js/store/action-types'


import {makeState} from './helpers';
import {makeRootState} from './helpers';
import {testAction} from './helpers';
import {description} from './helpers';


describe("store | modules | ", () => {
    describe("grade.comments | ", () => {

        describe("mutations | ", () => {
            describe(description(types.loadElementComments), ()=>{
                xit("happy path | ", ()=>{
                    //todo
                });
            });

            describe(description(types.loadStockComments), ()=>{
                xit("happy path | ", () => {
                    //todo
                });
            });

            describe(description(types.setElementComment), ()=>{
                describe("pre-existing comment text | ", () => {
                    xit("happy path | ", () => {
                        //todo
                    });
                });
                describe("no pre-existing comment text | ", () => {
                    xit("happy path | ", () => {
                        //todo
                    });
                });

            });


        });

        describe("actions | ", () => {
            describe(description(aTypes.storeCommentText), ()=>{
                xit("happy path | ", () => {
                    testAction
                    //todo
                })
            });
            describe(description(aTypes.storeCommentTextForActiveStudent), ()=>{
                xit("happy path | ", () => {
                    //todo
                })
            });
        });

        describe("getters | ", () => {
            describe("getElementComment | ", () => {
                xit("happy path | ", () => {
                    //todo
                })
            });
            describe("getCommentText | ", () => {
                xit("happy path | ", () => {
                    //todo
                })
            });
            describe("getStoredCommentText | ", () => {
                xit("happy path | ", () => {
                    //todo
                })
            });
            describe("getCommentTextForActiveStudent | ", () => {
                xit("happy path | ", () => {
                    //todo
                })
            });
        });
    });
});
