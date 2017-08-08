//test libraries
let faker = require( 'faker' );

import { testAction, description, factories } from '../../../helpers/vuex.spec.helpers';

import { makeState, makeRootState, makeTestPayload, makeMutationPayload } from '../../../helpers/items.tests.helpers'
window._ = require( 'lodash' );


//Dependencies
import * as jsonReaders from '../../../../../resources/assets/js/store/utlities/JsonReaders';

import * as mTypes from '../../../../../resources/assets/js/store/mutation-types'
import * as aTypes from '../../../../../resources/assets/js/store/action-types'
import Item from '../../../../../resources/assets/js/models/Item'
import Payload from '../../../../../resources/assets/js/models/Payload'


//tested object
let obj = jsonReaders.default;
//tested methods
let { actions, mutations } = obj;

const makeObjectTestJson = ( numObjects = 5 ) => {
    let testJson = [];
    for (let i = 0; i < numObjects; i++) {
        testJson.push( {
            comment_text: faker.random.word(),
            created_at: "2017-06-28 15:18:57",
            deleted_at: null,
            displayText: null,
            exam_id: null,
            id: i,
            max_score: faker.random.number(),
            name: faker.random.word(),
            settings: null,
            text: "",
            updated_at: "2017-06-28 15:18:57",
            user_id: 1
        } );
    }
    return testJson;
};

describe( " JsonReaders | ", function () {


    describe( description( "directLoadObjectsFromJson" ), function () {

        beforeEach( function () {
            //runs before each test
            this.numItems = 4;
            this.testObj = makeObjectTestJson( this.numItems );
            this.state = {items: []};
        } );

        it( "check setup", function () {
            //prep and check setup
            expect( this.testObj.length ).toBe( this.numItems );
            expect(this.state.items.length).toBe(0);
        } );

        it( "happy path", function () {
            //prep
            let payload = Payload.factory({obj: this.testObj});
            //call
            mutations.directLoadObjectsFromJson(this.state, {}, payload);
            //check
            expect(this.state.items.length).toBe(this.numItems);
            _.forEach(this.state.items, (data, index) =>{
                //everything is an item object
                expect(data instanceof Item).toBe(true);
                //check props
                let orig = this.testObj.filter((item)=>{ if(item.id === data.id) return item; })[0];
                expect(data.id).toBe(orig.id);
                expect(data.name).toBe(orig.name);
                //todo other props --automate
            });

        } );
    } );

} );