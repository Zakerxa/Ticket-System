<template>
<div class="container">

    <div class="row justify-content-center d-flex align-items-center" style="min-height: 85vh">
        <div class="col-11 col-sm-8 col-md-6 col-lg-4 text-center position-relative">
            <div v-show="loginLoading" class="overlayLoading">
                <div class="row">
                    <p class="text-muted">Loading . . .</p>
                </div>
            </div>
            <form @submit.prevent="login" class="card p-3 pt-4 pb-4">
                <h3 class="fw-bold pb-3">Login</h3>
                <!-- Login Errors -->
                <p v-if="loginErrors" class="alert alert-danger small p-2">
                    {{ loginErrors }}
                </p>
                <!-- GlobalNoti -->
                <div class="form-floating mb-3">
                    <input type="email" v-model="email" @keyup="checkPass" class="form-control" id="floatingInput" placeholder="name@example.com" required />
                    <label for="floatingInput">Email address</label>
                </div>
                <div class="form-floating">
                    <input :type="checkPassword" v-model="password" @keyup="checkPass" class="form-control" id="floatingPassword" placeholder="Password" autocomplete="off" required />
                    <font-awesome-icon v-show="showicon" @click="eyecheck()" :icon="checkIcon" class="text-end position-absolute pt-2 pb-2" style="margin-right: 10px;cursor: pointer;bottom: 5px;right: 0;"></font-awesome-icon>
                    <label for="floatingPassword">Password</label>
                </div>
                <div class="mt-3">
                    <button :disabled="disPassword" class="btn btn-primary w-100" type="submit">
                        Login
                    </button>
                </div>
                <div class="mt-2">
                    <router-link class="btn btn-dark w-100" to="/register">Register</router-link>
                </div>
            </form>
        </div>
    </div>

</div>
</template>

<script>
import {
    mapGetters
} from 'vuex';
export default {
    data() {
        return {
            showicon: false,
            loginLoading: false,
            checkPassword: 'password',
            checkIcon: 'fa-solid fa-eye-slash',
            checkState: true,
            disPassword: true,
            password: 'helloworld',
            email: 'staff@gmail.com',
        }
    },
    methods: {
        eyecheck() {
            this.checkState = !this.checkState
            if (this.checkState) {
                this.checkPassword = 'password'
                this.checkIcon = 'fa-solid fa-eye-slash'
            } else {
                this.checkPassword = 'text'
                this.checkIcon = 'fa-solid fa-eye'
            }
        },
        checkPass() {
            if (this.password.length >= 1) {
                this.disPassword = false
                this.showicon = true
            } else {
                this.disPassword = true
                this.showicon = false
            }
        },
        login(e) {
            if (this.disPassword) return;
            e.preventDefault();
            this.loginLoading = true

            this.$store.dispatch('login', {
                    email: this.email,
                    password: this.password
                })
                .then(() => this.authRedirect())
                .catch(() => this.clearData())
        },
        authRedirect() {
            this.loginLoading = false
            if (this.$store.state.auth) {
                this.clearData()
                this.$router.push(this.$route.query.redirect || '/')
            }
        },
        clearData() {
            this.loginLoading = false
            this.showicon = false
            this.password = ''
            this.email = ''
        }
    },
    watch: {
        $route(to, from) {
            // console.log("Now i'm leave Login page");
            this.$store.commit('clearLoginError');
        }
    },
    computed: mapGetters(['auth', 'loginErrors']),
    mounted() {
        this.checkPass()
    }
}
</script>

<style lang="scss">
.overlayLoading {
    position: absolute;
    height: 100%;
    width: 100%;
    z-index: 9999;
    border: none;
    border-radius: 5px;
    background: rgba(255, 255, 255, 0.749);

    div {
        justify-content: center;
        position: absolute;
        align-items: center;
        height: 100%;
        width: 100%;
        margin: 0;
        padding: 0;
    }
}
</style>
