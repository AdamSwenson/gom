/**
 * Created by adam on 6/12/17.
 */


const _ = window._ = require( 'lodash' );
const Vue = require( 'vue' );

import * as mTypes from '../../mutation-types'
import * as aTypes from '../../action-types'
import * as gTypes from '../../getter-types'

import Payload from '../../../models/Payload'
import Item from '../../../models/Item'
import Exam from '../../../models/Exam'
import Node from '../../../models/Node'

let initialExam = new Exam();

module.exports = {
    itemMap: new Node( initialExam.serialNumber, initialExam.serialNumber ),

    /*
     * What we want to have is the ability to store nested
     * tuples which map the item to a position on an exam
     * (which is itself formally an item).
     * order : {
     *      0 : {
     *          id: null,
     *          children: {
     *              0 : {
     *                      id: null.
     *                      children: {}
     *                 }
     *          }
     *      }
     }
     *
     * */
    //the first value in the array is the item's id
    //the second value is an array of children
    // orderMap: new Map(),
    // orderList: [],
    //
    // order: {
    //     0: {
    //         id: null,
    //         children: {
    //             0: {
    //                 id: null,
    //                 children: {}
    //             }
    //         }
    //     }
    // }
    // orderMap: new Map(),
    // order: {}

};
