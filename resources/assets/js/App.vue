<template>
    <div class="container">
        <div id="app">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <router-link class="nav-item nav-link" :to="{name: 'home'}" exact>
                            Home <span class="sr-only">(current)</span>
                        </router-link>
                        <router-link class="nav-item nav-link" :to="{name: 'example'}" exact>Example</router-link>
                    </div>
                </div>
                <div class="pull-right" v-show="!auth.isloggedIn()">
                    <router-link class="btn btn-outline-success" :to="{name: 'login'}" exact>Login</router-link>
                </div>
                <div class="pull-right" v-show="auth.isloggedIn()">
                    <button class="btn btn-outline-success" @click="auth.logout(instance)">Logout</button>
                </div>
            </nav>
            <section>
                <router-view></router-view>
            </section>
        </div>
    </div>
</template>

<script>
    import Auth from "./models/Auth";
    import Helper from "./utils/Helper";

    export default {
        name: 'app',
        data() {
            return {
                auth: Auth,
                instance: this
            };
        },
        created() {
            if (Helper.empty(this.$session.id())) {
                this.$session.start();
            }
        },
        mounted() {
        }
    }
</script>

<style>
    footer {
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        color: white;
    }
</style>
