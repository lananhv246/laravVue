<template>
    <div>
        <h5 class="mb-1">{{article.title}}</h5>
        <p class="mb-1">{{article.content}}</p>    
    </div>
</template>

<script>
export default {
    data() {
        return {
            article: {
                    title: '',
                    content: '',
                    authorId: '',
                    user: '',
                },
        }
    },
    mounted() {
        let app = this;
        let id = app.$route.params.id;
        app.id = id;
        axios
            .get('/api/articles/' + id)
            .then(res => {
                //console.log(res.data[0])
                this.article = res.data
                console.log(this.article);
            })
            .catch(err=> {
                console.log(err)
            });
    }
}
</script>
