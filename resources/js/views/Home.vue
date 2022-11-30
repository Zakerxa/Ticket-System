<template>
<div class="container">
    <!-- Public -->

    <!-- Auth User -->
    <div v-if="auth" class="row justify-content-center pt-4">
        <ul class="nav nav-tabs">
            <li class="nav-item" @click="slideShow=true">
                <a class="nav-link" :class="slideShow ? 'active' : ''" aria-current="page" href="#">Profile</a>
            </li>
            <li class="nav-item" @click="slideShow=false">
                <a class="nav-link" :class="slideShow ? '' : 'active'" href="#">Create Ticket</a>
            </li>
        </ul>
    </div>

    <!-- Unauthorize -->
    <div v-else class="row justify-content-center">

        <div class="col-12 text-center mt-5 fw-bold">
            You need to login create ticket.
        </div>

    </div>

    <div class="row justify-content-center pb-5 pt-5">

        <div v-if="slideShow" class="col-12 col-md-8 col-lg-6 text-start">

            <table v-if="authUser" class="table border">
                <thead>

                </thead>
                <tbody>
                    <tr>
                        <th scope="row">Name</th>
                        <td>~ {{authUser.name}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Email</th>
                        <td>~ {{authUser.email}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Phone</th>
                        <td>~ {{authUser.phone}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Role</th>
                        <td>~ {{authUser.role.name}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Start Date</th>
                        <td>~ {{authUser.created_at}}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <form v-else @submit.prevent="createTicket" class="col-11 col-md-8 col-lg-4 pt-2 shadow card">
            <h3 class="p-3 fw-bold">Create Ticket</h3>
            <div class="mb-3">
                <label for="titleId" class="form-label">Title</label>
                <input type="text" v-model="ticket.title" class="form-control" id="titleId" placeholder="Title" required>
            </div>
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                <textarea class="form-control" v-model="ticket.description" spellcheck="false" id="exampleFormControlTextarea1" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-outline-success">Submit</button>
            </div>
        </form>
    </div>

    <!-- Toast Noti -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto text-success">Ticket Created</strong>
                <small>just now</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Your ticket is successfully created.
            </div>
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
            ticket: {
                title: 'Web Developement',
                description: 'Here is description'
            },
            slideShow: true
        }
    },
    methods: {
        createTicket() {
            const toast = new bootstrap.Toast(document.getElementById('liveToast'))
            if (this.auth && this.authUser) {
                this.$store.dispatch('createTicket', this.ticket).then(() => {
                        toast.show()
                        this.ticket.title = '';
                        this.ticket.description = '';
                        setTimeout(() => toast.hide(), 2000);
                    })
                    .catch(() => console.log("Error Occour"))

            } else this.$router.push(this.$route.query.redirect || '/login');
        }
    },
    computed: {
        ...mapGetters(['auth', 'authUser'])
    },
    mounted() {

    }
}
</script>
