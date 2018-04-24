<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="#" @submit.prevent="submit">
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email"
                               v-model="email.value"
                               :class="{'form-control': true, 'col-md-8': true, 'is-danger': errors.has('email') }"
                               id="email"
                               name="email"
                               aria-describedby="emailHelp"
                               placeholder="Enter email"
                               v-validate="email.rule">
                        <span v-if="errors.has('email')"
                              class="help is-danger"
                              style="color: red"
                              v-text="errors.first('email')"></span>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password"
                               v-model="password.value"
                               :class="{'form-control': true, 'col-md-8': true, 'is-danger': errors.has('email') }"
                               id="password"
                               name="password"
                               placeholder="Password"
                               v-validate="password.rule">
                        <span v-if="errors.has('password')" style="color: red" v-text="errors.first('password')"></span>
                    </div>
                    <button :disabled="errors.items.length > 0" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import Auth from "../models/Auth";

    export default {
        name: "Login",
        data() {
            return {
                email: {
                    value: "",
                    rule: {required: true, email: true}
                },
                password: {
                    value: "",
                    rule: {required: true}
                },
            }
        },
        mounted() {
        },
        methods: {
            submit() {
                Auth.login(this, {email: this.email.value});
            }
        }
    }
</script>

<style scoped>
</style>