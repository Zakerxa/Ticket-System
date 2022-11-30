<template>
<div class="container">
    <div class="row justify-content-center d-flex align-items-center" style="min-height:85vh">
        <div class="col-11 col-sm-8 col-md-6 col-lg-4 text-center">

            <form v-if="stateOne" class="card p-3 pt-4 pb-4">
                <h3 class="fw-bold pb-3">Register</h3>
                <p v-if="errors" class="alert alert-danger small p-2">{{errors}}</p>
                <div class="form-floating mb-3">
                    <input v-model="form.username" type="email" class="form-control" id="username" autocomplete="off" placeholder="Username" />
                    <label for="username">Username</label>
                </div>
                <div class="form-floating mb-3">
                    <input v-model="form.email" type="email" class="form-control" id="email" autocomplete="off" placeholder="name@example.com" />
                    <label for="email">Email address</label>
                </div>
                <div class="mt-2">
                    <button @click="stateOne=false" class="btn btn-primary w-100" type="button">Next</button>
                </div>
            </form>

            <form v-else @submit.prevent="register" class="card p-3 pt-4 pb-4">
                <h3 class="fw-bold pb-3">Register</h3>
                <div class="form-floating mb-3">
                    <input v-model="form.phone" type="phone" class="form-control" id="Phone" autocomplete="off" placeholder="Phone" />
                    <label for="Phone">Phone</label>
                </div>
                <div class="form-floating mb-3">
                    <input v-model="form.password" type="password" class="form-control" id="floatingPassword" autocomplete="off" placeholder="Password" />
                    <label for="floatingPassword">Password</label>
                </div>
                <div class="mt-2">
                    <button @click="register" class="btn btn-success w-100" type="submit">Register</button>
                </div>
                <div class="mt-2">
                    <button @click="stateOne=true" class="btn btn-dark w-100" type="button">Back</button>
                </div>
            </form>
        </div>
    </div>
</div>
</template>


<script>
import { mapGetters } from 'vuex';
export default {
    data() {
        return {
            registerLoading : false,
            stateOne: true,
            form:{
                username: '',
                email : '',
                phone : '',
                password:''
            }
        }
    },
    methods:{
        register(e){
            e.preventDefault();
            this.registerLoading = true;

            this.$store.dispatch('register',this.form)
            .then(()=>  this.authRedirect())
            .catch(() => this.clearData())
        },
        authRedirect () {
            this.clearData();
            this.$router.push(this.$route.query.redirect || '/login')
        },
        clearData() {
            this.registerLoading = false;
            this.stateOne = true;
            this.forms = {};
        },
    },
    watch:{
        $route (to, from){
        // console.log("Now i'm leave register page");
        this.$store.commit('clearRegisterError')
       }
    },
    computed:mapGetters({errors:'registerErrors'})
}
</script>


<style></style>
