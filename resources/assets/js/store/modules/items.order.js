/**
 * This pulls together the various parts of
 * handling item order.
 * If there was something which required multiple
 * portions of the tools to be used, it would
 * be defined in this file
 *
 * Otherwise, it just makes the locations of
 * methods more intelligible and helps clean
 * up the items.js file where everything comes
 * together
 *
 * Created by adam on 4/11/17.
 */



import mutations from './items.order.mutations'
import actions from './items.order.actions'
import getters from './items.order.getters'
import state from './items.order.state'



export default {
    actions,
    getters,
    mutations,
    state
}
