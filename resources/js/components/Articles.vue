<template>
    <div>
        <div class="mb-2">
            <div class="left">
                <router-link :to="{name: 'createArticle'}"><v-btn small> Create</v-btn></router-link>
                <!-- start dialog -->
                <strong>/</strong>
                <v-dialog
                    v-model="dialog"
                    persistent
                    max-width="80%"
                    transition="dialog-transition"
                >
                    <template v-slot:activator="{ on }">
                        <v-btn color="red lighten-2" v-on="on" small>Create modal</v-btn>
                    </template>
                    <v-card>
                        <v-card-title primary-title>
                            <h3>Create Article</h3>
                        </v-card-title>
                        <v-card-text>
                            <!-- start submit form -->
                            <form v-on:submit="saveForm()">
                                <v-container grid-list-xl>
                                    <v-layout wrap>
                                        <v-flex xs6 sm6>
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
                                            ></v-text-field>
                                            </v-flex>
                                            <div v-if="error && error.title" class="text-danger">{{ error.title[0] }}</div>

                                            <v-flex xs12 md12>
                                                <v-textarea
                                                name="content"
                                                label="Content Article"
                                                v-model=article.content
                                                hint="Hint text"
                                                prepend-inner-icon="text_format"
                                                ></v-textarea>
                                            </v-flex>
                                            <v-flex xs12 sm12>
                                                <button class="btn btn-success">Update</button>
                                            </v-flex>
                                        </v-flex>
                                        <v-flex xs6 sm6>
                                            <div class="right"><h2 class="vue">Vue.js</h2> <h1>
                                            The Progressive<br>JavaScript Framework
                                        </h1> <p><a id="modal-player" href="javascript:;" class="button has-icon"><svg aria-labelledby="simpleicons-play-icon" role="img" viewBox="0 0 100 125" fill="#FFFFFF"><title id="simpleicons-play-icon" lang="en">Play icon</title><path d="M50,3.8C24.5,3.8,3.8,24.5,3.8,50S24.5,96.2,50,96.2S96.2,75.5,96.2,50S75.5,3.8,50,3.8z M71.2,53.3l-30.8,18  c-0.6,0.4-1.3,0.5-1.9,0.5c-0.6,0-1.3-0.1-1.9-0.5c-1.2-0.6-1.9-1.9-1.9-3.3V32c0-1.4,0.8-2.7,1.9-3.3c1.2-0.6,2.7-0.6,3.8,0  l30.8,18c1.2,0.6,1.9,1.9,1.9,3.3S72.3,52.7,71.2,53.3z"></path></svg>

                                            WHY VUE.JS?</a> <a href="/articles" class="button white"> ARTICLES </a> <a href="https://github.com/vuejs/vue" target="_blank" class="button gray has-icon"><svg aria-labelledby="simpleicons-github-dark-icon" lang="" role="img" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title id="simpleicons-github-icon" lang="en">GitHub Dark icon</title><path fill="#7F8C8D" d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"></path></svg>

                                            GITHUB</a></p></div>
                                        </v-flex>
                                    </v-layout>
                                </v-container>
                            </form>
                            <!-- end -->
                        </v-card-text>
                        <v-divider></v-divider>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn text @click="dialog = false" class="text-primary">Close</v-btn>
                        </v-card-actions>
                    </v-card>
                </v-dialog>
                <!-- end -->
            </div>
            <div>
                <v-layout wrap>
                <v-flex xs10 sm10>
                    <v-text-field
                        name="title"
                        label="Title"
                        id="titleSearch"
                        v-model=article.searchTitle
                    ></v-text-field>
                </v-flex>
                <v-flex xs2 sm2 class="bottom">
                    <button @click="searchForm()" class="mt-4"><v-icon>search</v-icon></button>
                </v-flex>
                </v-layout>
            </div>
            
        </div>

        <!-- start list -->
        <div v-if="success" class="text-success"><v-icon color="success">check_circle_outline</v-icon> {{ success }}</div>
        <ul v-for="(item, index) in articles" :key="index">
            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">{{item.title}}</h5>
                    <small>{{item.created_at}}</small>
                    <span class="badge badge-pill">
                        <router-link :to="{name: 'editArticle', params: {id: item.id}}" color="red lighten-2" class="btn btn-sm btn-outline-primary right">Edit </router-link>
                        <!-- <a href="#"
                            class="btn btn-sm btn-danger right mr-1"
                            v-on:click="del(item.id, index)">
                            Delete
                        </a> -->
                        <v-btn color="lighten-2" v-on:click="del(item.id, index)" small>Delete</v-btn>
                    </span>
                    </div>
                    <p class="mb-1">{{item.content}}</p>
                    <small class="text-danger">{{item.author.name}}</small>
                </a>
                
            </div>
        </ul>
        <!-- end -->
        <!-- start paging -->
        <div class="text-center">
            <v-pagination
            v-model="pagination.current"
            :length="pagination.total"
            circle
            :total-visible="7"
            @input="onPageChange"
            ></v-pagination>
        </div>
        <!-- end -->
    </div>
    
</template>
<script>
    import axios from 'axios'
import { setTimeout } from 'timers';
    export default {
        name: 'articles',
        data() {
            return {
                url: '',
                value: false,
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
                    searchTitle: ''
                },
                dialog: false,
                pagination:{
                    current: 1,
                    total: 0
                },
                articles: null,
                success: false
            }
        },
        methods: {
            read() {
                axios
                .get((this.url.length > 0)? this.url:'/api/articles?page=' + this.pagination.current + '&searchTitle=' + this.article.searchTitle)
                .then(res => {
                    console.log(this.url.length)
                    const {data:{data}} = res;
                    this.articles = data;
                    const {data:{meta}} = res;
                    this.pagination.current = meta.current_page;
                    this.pagination.total = meta.last_page;
                    console.log(meta)
                })
                .catch(err=> {
                    console.log(err)
                });
            },
            onPageChange() {
                this.read();
            },
            saveForm() {
                event.preventDefault();
                let app = this;
                axios
                    .post('/api/articles', app.article)
                    .then(res => {
                        console.log(res.data);
                        this.dialog = false;
                        this.read();
                        let app = this;
                        this.success = 'successsssss!!!!!!!!!';
                        setTimeout(function() {
                            app.success = false;
                        }, 2000);
                    })
                    .catch(err => {
                        console.log(err.response);
                        if(err.response.status === 422) {
                        console.log(err.response.data.errors);
                                this.error = err.response.data.errors || {};
                                this.rules.required = err.response.data.errors.title[0];
                                
                            }
                    });
            },
            del(id, index) {
                if(confirm('Do you really want to delete')) {  
                    axios.delete('/api/articles/' + id)
                        .then(res => {
                            this.articles.splice(index, 1);
                            console.log(res);
                        })
                        .catch(err => {
                            console.log(err);
                        });
                }
            },
            searchForm(){
                this.pagination.current = 1;
                this.url = '/api/articles/search?page=' + this.pagination.current + '&searchTitle=' + this.article.searchTitle;
                this.read();
            }
        },
        mounted() {
            this.read();
        },
    }
</script>
