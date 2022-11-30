<template>
<div class="d-md-block" style="min-height: 5px;background-color: #232;"></div>
<nav class="navbar navbar-expand-lg bg-light">

    <div class="container-fluid">
        <a class="navbar-brand text-dark fw-bold" href="#">Ticket System</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarScroll">
            <ul class="me-auto"> </ul>
            <ul class="navbar-nav me-auto my-2 my-lg-0" style="--bs-scroll-height: 100px;">
                <router-link v-for="(route,i) in router" :key="i" class="nav-link fw-bold pt-2 pb-2" tag="li" active-class="active" aria-current="page" :to="route.path">
                    {{route.name}}
                </router-link>
            </ul>
           <div v-if="auth && authUser" class="d-none d-lg-block">
               <button class="btn btn-secondary fw-bold">{{authUser.name}}</button>
           </div>
            <ul class="navbar-nav my-2 my-lg-0" style="--bs-scroll-height: 100px;">
                <button  v-if="auth" @click="logout" class="btn border-0 pt-2 pb-2 fw-bold nav-link"  active-class="active" aria-current="page">Logout</button>
                <router-link v-else class="nav-link pt-2 pb-2 fw-bold"  active-class="active" aria-current="page" to="/login">Login</router-link>
            </ul>
        </div>
    </div>
</nav>
</template>

<script>
import {
    mapGetters
} from 'vuex';
export default {
    data() {
        return {
            title: "<Zakerxa/>",
            navIcon: 'navbar-toggler-icon',
            navTran: 'transform: rotateZ(0deg);',
            navCheck: false,
            bsOffcanvas: '',
            router: [{
                    name: "Home",
                    path: "/"
                },
                {
                    name: "Ticket",
                    path: "/tickets"
                },
                {
                    name: "Log",
                    path: "/log"
                }
            ]
        }
    },
    methods: {
        logout(){
           this.$store.dispatch('logout')
           .then(()=>  this.$router.push(this.$route.query.redirect || '/login'))
           .catch(()=> console.log("Unauthorize User"));
        }
    },
    computed:{...mapGetters(['auth','authUser'])}
}
</script>


<style lang="scss" scoped>
.navigation {
    position: fixed;
    background: #fff;
    top: 0;
    padding: 0;
    z-index: 9999;
    width: 100%;
}

@media screen and (min-width:768px) {
    .nav-link {

        &:active {
            transition: border-bottom .2s;
            color: #d6f0ff;
        }
    }

    .exact-active {
        font-weight: bold;
        cursor: pointer;
        color: #7fb4ff!important;
    }
}
</style>
