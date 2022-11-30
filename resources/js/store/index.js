import { createStore } from 'vuex';
import Login from './modules/login';
import Logout from './modules/logout';
import Register from './modules/register';
import User from './modules/user';
import Ticket from './modules/ticket';
import Log from './modules/Log';

const store = createStore({
    modules: { Login, Logout, Register, User, Ticket, Log },
    state() {
        return {
            auth: localStorage.getItem('auth') || null,
            globalNoti: '',
            authUser: null,
            userTickets: null,
            log: null
        }
    },
    getters: {
        auth(state) {
            return state.auth;
        },
        authUser(state) {
            return state.authUser;
        },
        globalNoti(state) {
            return state.globalNoti;
        },
        userTickets(state) {
            return state.userTickets;
        },
        log(state) {
            return state.log;
        }
    },
    mutations: {
        updateAuthorize(state, payload) {
            if (payload) localStorage.setItem('auth', payload);
            state.auth = localStorage.getItem('auth') || null;
        },
        removeAuthorize(state) {
            localStorage.removeItem('auth');
            state.auth = null;
            state.authUser = null;
        },
        globalMessage(state, payload) {
            state.globalNoti = payload
        }
    }
});


export default store;
