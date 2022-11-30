<template>
<div class="container">
    <div class="row justify-content-center pt-5">
        <div class="col-12 text-start">
            <h2 class="p-2">My Ticket</h2>
        </div>
    </div>
    <div class="row d-flex align-items-center justify-content-center">
        <div v-if="auth" class="table-responsive">
            <table v-if="userTickets && userTickets.data.length >= 1" class="table">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col" class="text-start">Ticket</th>
                        <th scope="col" class="text-start">Subject</th>
                        <th scope="col" class="">Start</th>
                        <th scope="col">Status</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Del</th>
                    </tr>
                </thead>
                <tbody v-for="(ticket,index) in userTickets.data" :key="index">
                    <tr>
                        <th scope="row">{{index+1}}</th>
                        <td class="text-start">{{ticket.ticket}}</td>
                        <td class="text-start">{{ticket.title}}</td>
                        <td class="text-start">{{ticket.created_at}}</td>
                        <td v-if="ticket.status == 0" class="text-warning">Waiting</td>
                        <td v-else-if="ticket.status == 1" class="text-danger">Rejected</td>
                        <td v-else-if="ticket.status == 2" class="text-primary"> Checked</td>
                        <td v-else class="text-success">Approved</td>
                        <td>
                            <font-awesome-icon v-if="(ticket.status != 3 && ticket.status != 2)" :class="(ticket.status == 0) ? 'disabled' : '' " @click="editTk(ticket)" class="btn btn-sm btn-outline-dark" icon="fa-solid fa-pen-to-square" />
                        </td>
                        <td>
                            <font-awesome-icon @click="delTicket(ticket.id)" class="btn btn-sm btn-outline-danger" icon="fa-solid fa-remove" />
                        </td>
                    </tr>
                </tbody>
            </table>

            <div v-else class="col-12 text-center">
                <h4 class="text-muted pt-5">Empty Ticket !</h4>
            </div>

        </div>
        <div v-else class="col-12 text-center pb-5" style="min-height:80vh">
            <h3 class="pt-3 pb-4">Here is an example Ticket.</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Ticket</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Status</th>
                        <th scope="col">Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Ticket#985930</td>
                        <td>Testing</td>
                        <td>Waiting</td>
                        <td>
                            <font-awesome-icon icon="fa-solid fa-pen-to-square" />
                        </td>
                    </tr>
                </tbody>
            </table>
            <p class="text-muted fw-bold pt-3">Please login first to see your tickets.</p>
        </div>
    </div>

    <!-- Modal SuccessForm -->
    <div class="col-12">
        <div class="modal fade" id="modalSuccessForm" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content boxshadow border-0">
                    <div class="modal-header">
                        <h3 class="modal-title fs-5 fw-bold" style="letter-spacing:1px;" id="staticBackdropLabel">
                            <font-awesome-icon icon="fa-solid fa-pen-to-square" class="text-success" /> Edit Ticket </h3>
                    </div>
                    <div class="modal-body">
                        <div class="">
                            <div class="mb-3">
                                <label for="titleId" class="form-label">Title</label>
                                <input type="text" v-model="ticket.title" class="form-control" id="titleId" placeholder="Title" required>
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                                <textarea class="form-control" v-model="ticket.description" spellcheck="false" id="exampleFormControlTextarea1" rows="3" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click="editTicket(ticket.id)" class="btn btn-success mr-3">Update</button>
                        <button type="button" data-bs-dismiss="modal" class="btn btn-danger">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</template>

<script>
import {
    mapGetters
} from 'vuex'
export default {
    data() {
        return {
            ticket: {
                title: '',
                description: ''
            },
            temTicket: {
                title: '',
                description: ''
            }
        }
    },
    computed: {
        ...mapGetters(['auth', 'authUser', 'userTickets'])
    },
    methods: {
        delTicket(id) {
            this.$store.dispatch('delTicket', id).then(() => console.log("success"))
                .catch(err => console.log("Error"));
        },
        editTk(e) {
            this.$http.post(`api/user/ticket/${e.id}`).then(res => {
                if (res.data.response == 'success') {
                    this.temTicket = {
                        ...res.data.tickets
                    }
                    this.ticket = {
                        ...res.data.tickets
                    }
                    $('#modalSuccessForm').modal('show');
                }
            })
        },
        editTicket() {
            if ((this.ticket.title == this.temTicket.title) && (this.ticket.description == this.temTicket.description))
                return $('#modalSuccessForm').modal('hide');

            this.$store.dispatch('editTicket', this.ticket).then(() => $('#modalSuccessForm').modal('hide'))
                .catch(() => $('#modalSuccessForm').modal('hide'));
        }
    },
    mounted() {
        this.$store.dispatch('gettingAuthUser').then(() => {
            if (this.authUser) this.$store.dispatch('getMyTicket');
        }).catch(() => {
            if (this.authUser) this.$store.dispatch('getMyTicket');
        })
    }
}
</script>

<style>

  </style>
