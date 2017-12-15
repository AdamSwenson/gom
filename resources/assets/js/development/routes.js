/**
 * Created by adam on 7/12/17.
 */
import Vue from 'vue'
//Panes (main container for edit tools)


import gradingRoutes from './routes.grading';
import examRoutes from './routes.exam-panel';
import itemRoutes from './routes.item-panel';

export const routes = [
    ...examRoutes,
    ...gradingRoutes,
    ...itemRoutes,

    //exams: change, grade, or new
    {
        name: 'load-exam',
        path: '',
    },

    //external
    { name: 'new-exam', path: '' },
    { name: 'grade-exam', path: '/grade/exam/:id' },


];
