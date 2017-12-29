//
// createItemTag: (item)=>{ return TAGS_BASE_ROUTE + '/item/' + item.id},
//     createExamTag: (exam)=>{ return TAGS_BASE_ROUTE + '/exam/' + exam.id},
//     updateTag: (tag)=>{return TAGS_BASE_ROUTE  + '/' + tag.id},
//     destroyTag: (tag)=>{return TAGS_BASE_ROUTE + '/' + tag.id},
//     getTagsForItem: (item)=>{return TAGS_BASE_ROUTE + '/item/' + item.id},
//     getTagsForExam: (exam) =>{return TAGS_BASE_ROUTE+ '/item/' + exam.id }
//    
//
import { REQUEST_VERSION, POLL_TIMEOUT, ID_WAIT_TIMEOUT, Routes } from '../apiSettings';

import * as aTypes from '../../store/action-types';
import * as mTypes from '../../store/mutation-types';
import * as gTypes from '../../store/getter-types';

import Payload from '../../models/Payload'
import Exam from '../../models/Exam'
import Item from '../../models/Item'
import Student from '../../models/Student'

import Tag from '../../models/Tag'

import { errorHandling, handleResponse } from '../responseHandlers';
import { holdForIdLoading } from '../apiHelpers';


let out = {
    requestVersion: REQUEST_VERSION
};

const preferencesBaseRoute = 'dev/preferences/';

module.exports = {
    getGradePreferences: () => {
        let route = preferencesBaseRoute + 'grade';
        return window.axios
            .get( route, out )
            .then( ( response ) => {
                return response.data.preferences
            } )
            .catch( function ( error ) {
                errorHandling( error );
            } );
    },

    getSetupPreferences: () => {
        let route = preferencesBaseRoute + 'setup';
        return window.axios
            .get( route, out )
            .then( ( response ) => {
                return response.data.preferences
            } )
            .catch( function ( error ) {
                errorHandling( error );
            } );
    },

    getUserPreferences: () => {
        let route = preferencesBaseRoute + 'user';
        return window.axios
            .get( route, out )
            .then( ( response ) => {
                return response.data.preferences
            } )
            .catch( function ( error ) {
                errorHandling( error );
            } );
    },

    setGradePreferences: ( toSend ) => {
        let route = preferencesBaseRoute + 'grade';
        out[ 'payload' ] = toSend;
        return window.axios
            .post( route, out )
            .then( ( response ) => {
                return response.data
            } )
            .catch( function ( error ) {
                errorHandling( error );
            } );
    },


    setSetupPreferences: ( toSend ) => {
        let route = preferencesBaseRoute + 'setup';
        out[ 'preferences' ] = toSend;
        return window.axios
            .post( route, out )
            .then( ( response ) => {
                return response.data
            } )
            .catch( function ( error ) {
                errorHandling( error );
            } );
    },

    setUserPreferences: ( toSend ) => {
        let route = preferencesBaseRoute + 'user';
        out[ 'preferences' ] = toSend;
        return window.axios
            .post( route, out )
            .then( ( response ) => {
                return response.data
            } )
            .catch( function ( error ) {
                errorHandling( error );
            } );
    },
}