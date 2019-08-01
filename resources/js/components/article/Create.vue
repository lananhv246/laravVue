<template>
  <form v-on:submit="saveForm()">
    <v-container grid-list-xl>
        <v-layout wrap>
            <v-flex xs6 sm6>
                <v-flex xs12 sm6>
                <router-link to="/articles">Back</router-link>
                </v-flex>
                <v-flex xs12 sm12>
                    <v-select
                        :items="users"
                        item-text="name"
                        item-value="id"
                        v-model="article.authorId"
                        label="label"
                    ></v-select>
                </v-flex>
                <v-flex xs12 sm12>
                <v-text-field
                    maxlength="190"
                    prepend-inner-icon="place"
                    hint="This field uses maxlength attribute"
                    v-validate="'required|max:190'"
                    data-vv-name="title"
                    v-model=article.title
                    counter="190"
                    label="Title"
                    name="title"
                    :rules="[rules.required]"
                ></v-text-field>
                </v-flex>
                <div v-if="error && error.title" class="text-danger">{{ error.title[0] }}</div>

                <v-flex xs12 md12>
                    <v-textarea
                    name="content"
                    label="Default style"
                    v-model=article.content
                    hint="Hint text"
                    ></v-textarea>
                </v-flex>
                <v-flex xs12 sm12>
                    <button class="btn btn-success">Update</button>
                </v-flex>
            </v-flex>
            <v-flex xs6 sm6>
                <div class="center">
                <img class="hero-logo" src="https://vuejs.org/images/logo.png" alt="vue logo">
                </div>
            </v-flex>
        </v-layout>
    </v-container>
  </form>
</template>

<script>
    import axios from 'axios'
    export default {
        name: 'articles',
        data() {
            return {
                rules: {
                required: value => !!value || 'Required.',
                min: v => v.length >= 8 || 'Min 8 characters',
                //emailMatch: () => ('The email and password you entered don\'t match'),
                },
                error: {},
                articleId: null,
                article: {
                    title: '',
                    content: '',
                    authorId: '',
                },
                users: null,
            }
        },
        mounted() {
        axios
            .get('/articles/created')
            .then(res => {
                const {data:{data}} = res;
                this.users = data;
                console.log(this.users);
            })
            .catch(err=> {
                console.log(err)
            });
        },
        methods: {
            saveForm() {
                event.preventDefault();
                let app = this;
                console.log(app.article);
                axios
                    .post('/api/articles', app.article)
                    .then(res => {
                        app.$router.replace('/articles');
                        console.log(res.data);
                    })
                    .catch(err => {
                        if(err.response.status === 422) {
                        console.log(err.response.data.errors);
                                this.error = err.response.data.errors || {};
                                this.rules.required = err.response.data.errors.title[0];
                            }
                    });
            },
        }
    }
</script>