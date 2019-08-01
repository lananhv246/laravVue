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
                        v-model="defaultSelected"
                        label="label"
                    ></v-select>
                </v-flex>
                <v-flex xs12 sm12>
                <v-text-field
                    maxlength="190"
                    prepend-inner-icon="title"
                    hint="This field uses maxlength attribute"
                    v-validate="'required|max:190'"
                    data-vv-name="title"
                    v-model=article.title
                    counter="190"
                    label="Title"
                    name="title"
                ></v-text-field>
                </v-flex>

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
                articleId: null,
                article: {
                    title: '',
                    content: '',
                    authorId: '',
                    user: '',
                },
                defaultSelected: {
                    name: '',
                    id: '',
                },
                users: null,
            }
        },
        mounted() {
            let app = this;
            let id = app.$route.params.id;
            app.id = id;
            axios
                .get('/articles/' + id)
                .then(res => {
                    //console.log(res.data[0])
                    this.article = res.data[0]
                    //this.items = res.data[1]
                    this.defaultSelected = this.article.user
                    this.users = res.data[1];
                    console.log(this.article);
                })
                .catch(err=> {
                    console.log(err)
                });
        },
        methods: {
            saveForm() {
                event.preventDefault();
                let app = this;
                app.article.authorId = app.defaultSelected;
                axios
                    .patch('/api/articles/' +app.id, app.article)
                    .then(res => {
                        console.log(app.article);
                        app.$router.replace('/articles');
                        //console.log(res.data);
                    })
                    .catch(err => {
                        console.log(err);
                    });
            },
        }
    }
</script>