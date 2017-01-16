//test libraries
require('jasmine-jquery');
require('sinon');

//Dependencies
import * as active from '../../../../../resources/assets/js/store/modules/activestudent';
import * as mTypes from '../../../../../resources/assets/js/store/mutation-types'
import * as aTypes from '../../../../../resources/assets/js/store/action-types'

import {makeState, makeRootState, testAction, description} from '../../../helpers/vuex.spec.helpers';
// import {makeRootState} from './helpers';
// import {testAction} from './helpers';
// import {description} from './helpers';

describe("store | modules | ", () => {
    describe("grade.activestudent | ", () => {

        describe("mutations | ", () => {

            describe(mTypes.setIndex, () => {
                describe("happy paths | ", () => {
                    //happy path cases:
                    //Number
                    it("is number | ", () => {
                    });

                });

                describe("sad paths | ", () => {
                    //object, even with expected key
                    it("is object | ", () => {
                    });
                    //numeric string
                    it("is numeric string | ", () => {
                    });
                })
            });

            describe(mTypes.setId, () => {
                describe("happy paths | ", () => {
                    //happy path cases:
                    //Number
                    it("is number | ", () => {
                    });

                });

                describe("sad paths | ", () => {
                    //object, even with expected key
                    it("is object | ", () => {
                    });
                    //numeric string
                    it("is numeric string | ", () => {
                    });
                })
//cases: integer, object.studentId, objectStudentindex
            });

            describe(mTypes.setStudentObject, () => {
                describe("happy paths | ", () => {
                    //happy path cases:
                    //Number
                    it("is number | ", () => {
                    });

                });
                describe("sad paths | ", () => {
                    //object, even with expected key
                    it("is object | ", () => {
                    });
                    //numeric string
                    it("is numeric string | ", () => {
                    });
                })
            });

            describe(mTypes.setTime, () => {
                describe("happy paths | ", () => {
                    //happy path cases:
                    //Number
                    it("is number | ", () => {
                    });

                });
                describe("sad paths | ", () => {
                    //object, even with expected key
                    it("is object | ", () => {
                    });
                    //numeric string
                    it("is numeric string | ", () => {
                    });
                })
            });
        });

        describe("actions | ", () => {
            describe(aTypes.setActiveStudent + " | ", () => {
                //todo
            });

            describe(aTypes.setActiveStudentId + " | ", () => {
                describe("is number | ", () => {
                    it("happy path | ", () => {
                        let test = 6; //todo make random
                        let state = makeState(); //{Index: null, Id: null, student: null};
                        let action = active.default.actions[aTypes.setActiveStudentId];

                        testAction(action, test, state, [
                            {type: mTypes.setId, payload: test}
                        ]);

                        expect(state.Index).toBeNull();
                        // expect(state.Id).toBe(test);
                        expect(state.student).toBeNull();
                    });

                });

                describe("is object w expected key | ", () => {
                    it("happy path | ", () => {
                        //todo
                    });
                });

                describe("is numeric string | ", () => {
                    it("happy path | ", () => {
                        //todo
                    });
                });
            });


            describe(aTypes.setActiveStudentIndex + " | ", () => {
                describe("is number | ", () => {
                    it("happy path | ", () => {
                        //todo
                    });
                });

                describe("is object with expected key | ", () => {
                    it("happy path | ", () => {
                        //todo
                    });
                });

                describe("is numeric string | ", () => {
                    it("happy path | ", () => {
                        //todo
                    });
                });

            });

            describe(aTypes.setActiveStudentObject + " | ", () => {
                describe("is number | ", () => {
                    xit("happy path | ", () => {
                        //todo
                    });
                });

                describe("is object w expected key | ", () => {
                    xit("happy path | ", () => {
                        //todo
                    });
                });

                describe("is numeric string | ", () => {
                    xit("happy path | ", () => {
                        //todo
                    });
                });

            });

            describe(aTypes.setActiveStudentTime + " | ", () => {
                describe("is number | ", () => {
                    xit("happy path | ", () => {
                        //todo
                    });
                });

                describe("is object w expected key| ", () => {
                    xit("happy path | ", () => {
                        //todo
                    });
                });

                describe("is numeric string | ", () => {
                    xit("happy path | ", () => {
                        //todo
                    });
                });

            });


        });

        describe("getters | ", () => {

            describe("getActiveStudentId | ", () => {
                it("happy path | ", () => {
                    let test = 5; //todo make random
                    let state = {Id: test};
                    // let {getActiveStudentId} = active;
                    expect(active.default.getters.getActiveStudentId(state, {}, {})).toBe(test);
                });
            });

            describe("getActiveStudentIndex", () => {
                it("happy path | ", () => {
                    let test = 6; //todo make random
                    let state = {Index: test};
                    // let {getActiveStudentIndex} = active;
                    expect(active.default.getters.getActiveStudentIndex(state)).toBe(test);
                });
            });


            describe("getActiveStudent", () => {
                it("happy path | ", () => {
                    let test = 9; //todo make random
                    let state = {};
                    state.student = test;
                    state.getStudent = (v) => {
                        return v;
                    };
                    // let {getActiveStudent} = active;
                    expect(active.default.getters.getActiveStudent(state)).toBe(test);
                });
            });
        });

    });

})
;