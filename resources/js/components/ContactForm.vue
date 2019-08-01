<template>
<v-container grid-list-xs>
    <v-layout wrap>
        <v-flex xs6 sm6>
            <div>
                <form @submit.prevent="submit">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" id="name" v-model="field.name" />
                        <div v-if="error && error.name" class="text-danger">{{ error.name[0] }}</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" name="email" id="email" v-model="field.email" />
                        <div v-if="error && error.email" class="text-danger">{{ error.email[0] }}</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea name="message" class="form-control" id="message" cols="30" rows="10" v-model="field.message"></textarea>
                        <div v-if="error && error.message" class="text-danger">{{ error.message[0] }}</div>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                </form>
            </div>
        </v-flex>
        <v-flex xs6 sm6>
            <div class="center">
            <img class="hero-logo" src="https://vuejs.org/images/logo.png" alt="vue logo">
            </div>
        </v-flex>
    </v-layout>
</v-container>
    
</template>

<script>
    import axios from 'axios'
    export default {
        data() {
            return {
                field: {
                    name: '',
                    email: '',
                    message: '',
                },
                error: {},
                success: false,
                loaded: true,
            }
        },
        methods: {
            submit() {
                if(this.loaded) {
                    this.loaded = false;
                    this.success = false;
                    this.error = {};
                    let app = this;
                    event.preventDefault();
                    axios
                    .post('api/contact/submit', app.field)
                        .then(response => {
                            // this.field ={};
                            this.success = true;
                            this.loaded = true;
                            alert('Message sent!');
                        })
                        .catch(error => {
                            this.loaded = true;
                            if(error.response.status === 422) {
                                this.error = error.response.data.errors || {};
                            }
                        });
                }
            },
        },
    }
</script>