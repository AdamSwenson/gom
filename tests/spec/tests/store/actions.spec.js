//test libraries
require('jasmine-jquery');
require('sinon');

//Dependencies
import * as actions from '../../../../resources/assets/js/store/actions.js';

const {setExamId} = actions;

describe("store | actions.js | ", function () {
    describe("setExamId | ", function () {
        beforeEach(function () {
//runs before each test
        });

        it("happy path | ", function () {


        });
    });

    xdescribe( aTypes.setActiveStudentId + " | ", function () {
        describe( "is number | ", function () {
            it( "happy path ", function () {
                let test = 6; //todo make random
                let state = makeState(); //{Index: null, Id: null, student: null};
                let action = active.default.actions[ aTypes.setActiveStudentId ];

                testAction( action, test, state, [
                    {type: mTypes.setId, payload: test}
                ] );

                expect( state.Index ).toBeNull();
                // expect(state.Id).toBe(test);
                expect( state.student ).toBeNull();
            } );

        } );

        xdescribe( "is object w expected key | ", function () {
            it( "happy path | ", function () {
                //todo
            } );
        } );

        xdescribe( "is numeric string | ", function () {
            it( "happy path | ", function () {
                //todo
            } );
        } );
    } );


    xdescribe( aTypes.setActiveStudentIndex + " | ", function () {
        describe( "is number | ", function () {
            it( "happy path | ", function () {
                //todo
            } );
        } );

        describe( "is object with expected key | ", function () {
            it( "happy path | ", function () {
                //todo
            } );
        } );

        describe( "is numeric string | ", function () {
            it( "happy path | ", function () {
                //todo
            } );
        } );

    } );

    xdescribe( aTypes.setActiveStudentObject + " | ", function () {
        describe( "is number | ", function () {
            xit( "happy path | ", function () {
                //todo
            } );
        } );

        describe( "is object w expected key | ", function () {
            xit( "happy path | ", function () {
                //todo
            } );
        } );

        describe( "is numeric string | ", function () {
            xit( "happy path | ", function () {
                //todo
            } );
        } );

    } );
    xdescribe( aTypes.setIndex, function () {
        describe( "happy paths | ", function () {
            //happy path cases:
            //Number
            it( "is number | ", function () {
            } );

        } );

        describe( "sad paths | ", function () {
            //object, even with expected key
            it( "is object | ", function () {
            } );
            //numeric string
            it( "is numeric string | ", function () {
            } );
        } )
    } );

    xdescribe( aTypes.setId, function () {
        describe( "happy paths | ", function () {
            //happy path cases:
            //Number
            it( "is number | ", function () {
            } );

        } );

        describe( "sad paths | ", function () {
            //object, even with expected key
            it( "is object | ", function () {
            } );
            //numeric string
            it( "is numeric string | ", function () {
            } );
        } )
//cases: integer, object.studentId, objectStudentindex
    } );

    xdescribe( aTypes.setStudentObject, function () {
        describe( "happy paths", function () {
            //happy path cases:
            //Number
            it( "is number | ", function () {
            } );

        } );
        describe( "sad paths | ", function () {
            //object, even with expected key
            it( "is object | ", function () {
            } );
            //numeric string
            it( "is numeric string | ", function () {
            } );
        } )
    } );

    xdescribe( aTypes.setTime, function () {
        describe( "happy paths ", function () {
            //happy path cases:
            //Number
            it( "is number | ", function () {
            } );

        } );
        describe( "sad paths | ", function () {
            //object, even with expected key
            it( "is object | ", function () {
            } );
            //numeric string
            it( "is numeric string | ", function () {
            } );
        } )
    } );


})
;