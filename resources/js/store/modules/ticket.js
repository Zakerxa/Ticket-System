import authorize from '../../authorize';
export default {
    state: {

    },
    actions: {
        createTicket({ state, commit, rootState }, forms) {
            return new Promise((resolve, reject) => {
                authorize.post('api/user/create/ticket', forms)
                    .then(res => {
                        if (res.data.response == 'success') resolve(res);
                    })
                    .catch(err => reject())
            })
        },
        delTicket({ commit, dispatch }, id) {
            return new Promise((resolve, reject) => {
                authorize.post(`api/user/delete/ticket/${id}`)
                    .then(res => {
                        if (res.data.response == 'success') resolve(dispatch('getMyTicket'))
                        else reject();
                    })
                    .catch(err => reject(err))
            })
        },
        getMyTicket({ state, commit, rootState }) {
            return new Promise((resolve, reject) => {
                authorize('api/user/tickets')
                    .then(res => {
                        if (res.data.response == 'success') resolve(rootState.userTickets = res.data.tickets);
                    })
                    .catch(err => reject(err))
            })
        },
        editTicket({ state, commit, dispatch }, form) {
            return new Promise((resolve, reject) => {
                authorize.post(`api/user/edit/ticket/${form.id}`, form)
                    .then(res => {
                        if (res.data.response == 'success') resolve(dispatch('getMyTicket'))
                        else reject();
                    })
                    .catch(err => {
                        console.log("Error in editTicket");
                    })
            })
        }
    }
}