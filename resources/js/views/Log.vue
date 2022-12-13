<template>
<div class="container">
    <div class="row justify-content-center pt-5">


        <div class="col-12 text-start">
            <h2 class="p-2">Ticket Log</h2>
        </div>

        <div v-if="log" class="col-12 text-start">

            <div v-for="(log,index) in log" :key="index">
                <p>{{index+1}}. You
                    <span v-if="log.title == 'deleted'" class="text-danger">{{log.title}}</span>
                    <span v-if="log.title == 'created'" class="text-success">{{log.title}}</span>
                    <span v-if="log.title == 'updated'" class="text-primary">{{log.title}}</span>
                    a ticket [ <span class="text-primary">{{log.token}}</span> ] {{log.created_at}}.</p>
            </div>

        </div>

        <div v-else class="col-12 text-center">
            <h4 class="text-muted pt-5">Empty Log !</h4>
        </div>

    </div>
</div>
</template>

<script>
import {
    mapGetters
} from 'vuex';
export default {
    computed: mapGetters(['auth', 'authUser', 'log']),
    mounted() {
        this.$store.dispatch('gettingAuthUser').then(() => {
            console.log("Running Here");
            if (this.authUser) this.$store.dispatch('gettingLog');
        }).catch(() => {
            if (this.authUser) this.$store.dispatch('gettingLog');
        });


    },
    methods: {
        clearLog() {
            this.$store.dispatch('clearLog');
        }
    }
}
</script>

<style>

  </style>
