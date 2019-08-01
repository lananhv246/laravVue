import Vue from 'vue';
import VueRouter from 'vue-router';
import Home from '@/js/components/Home';
import About from '@/js/components/About';
import Articles from '@/js/components/article/Index';
import ContactForm from '@/js/components/ContactForm';
import EditArticle from '@/js/components/article/Edit';
import CreateArticle from '@/js/components/article/Create';
import ShowArticle from '@/js/components/article/Show';
import Upload from '@/js/components/Upload';
import User from '@/js/components/user/Index';
Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/about',
            name: 'about',
            component: About
        },
        {
            path: '/contact',
            name: 'contact',
            component: ContactForm
        },
        {
            path: '/articles',
            name: 'articles',
            component: Articles
        },
        {
            path: '/articles/create',
            name: 'createArticle',
            component: CreateArticle
        },
        {
            path: '/articles/edit/:id',
            name: 'editArticle',
            component: EditArticle
        },
        {
            path: '/articles/show/:id',
            name: 'showArticle',
            component: ShowArticle
        },
        {
            path: '/upload',
            name: 'upload',
            component: Upload
        },
        {
            path: '/users',
            name: 'users',
            component: User
        },
    ]
});
export default router;