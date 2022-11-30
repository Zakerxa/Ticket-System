import authorize from "../../authorize"
export default {
    actions: {
        gettingLog({ state, commit, rootState }) {
            return new Promise((resolve, reject) => {
                authorize('api/user/log').then(res => {
                        if (res.data.response == 'success' && res.data.log.length >= 1) resolve(rootState.log = res.data.log)
                        else resolve(rootState.log = null)
                    })
                    .catch(err => reject(err))
            })
        },
        clearLog({ state, commit, rootState }) {
            return new Promise((resolve, reject) => {
                authorize.post('api/user/clear/log').then(res => resolve(rootState.log = null))
                    .catch(err => reject(err))
            })
        }
    }
}