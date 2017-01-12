//test libraries
require('jasmine-jquery');
require('sinon');

//Dependencies
import * as getters from '../../../../resources/assets/js/store/getters.js';

describe("store | getters.js | ", function () {

    describe("getExamId | ", () => {
        it("happy path | ", function () {
            let examId = 12; //todo add random number
            let state = {examId: examId};
            let {getExamId} = getters;
            expect(getExamId(state)).toBe(examId);
        });
    });

    describe("isActive | ", () => {
        describe("state.activeStudentIndex | undefined ", () => {
            it("happy path | ", function () {
                let state = {};
                let {isActive} = getters;
                expect(isActive(state)).toBe(false);
            });
        });
        describe("state.activeStudentIndex | null ", () => {
            it("happy path | ", function () {
                let state = {};
                state.activeStudentIndex = null;
                let {isActive} = getters;
                expect(isActive(state)).toBe(false);
            });
        });
        describe("state.activeStudentIndex | 0 ", () => {
            it("happy path | ", function () {
                let state = {};
                state.activeStudentIndex = 0;
                let {isActive} = getters;
                expect(isActive(state)).toBe(true);
            });
        });
        describe("state.activeStudentIndex | >0 ", () => {
            it("happy path | ", function () {
                let state = {};
                state.activeStudentIndex = 5;
                let {isActive} = getters;
                expect(isActive(state)).toBe(true);
            });
        });
        describe("state.activeStudentIndex | default ", () => {
            it("happy path | ", function () {
                let state = false;
                let {isActive} = getters;
                expect(isActive(state)).toBe(false);
            });
        });

    });


    describe('getNumberGraded', () => {
        //Todo This requires replacing updateExamGrade method on state
        it("happy path | ", function () {
        });

        // it("happy path | ", function () {});
        // it("happy path | ", function () {});
        // it("happy path | ", function () {});it("happy path | ", function () {});
    });


    describe("getTotalExams", () => {
        it("happy path | ", function () {
            let {getTotalExams} = getters;
            let state = {
                examGrades: {
                    key1: {},
                    key2: {}
                }
            };
            expect(getTotalExams(state)).toBe(2);
        });
    });
});