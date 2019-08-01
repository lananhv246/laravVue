<template>
<form v-on:submit="saveForm" enctype="multipart/form-data">
    <v-container grid-list-xl>
        <v-layout wrap>
            <v-flex xs6 sm6>
            <v-flex xs6 sm6>
                <v-img
                :src="image"
                lazy-src="https://picsum.photos/id/11/10/6"
                aspect-ratio="1"
                class="grey lighten-2"
                max-width="500"
                max-height="300"
                ></v-img>
            </v-flex>
                <v-flex xs12 sm12>
                    <input type="file" name="image" v-on:change="onImageChange" multiple class="form-control"/>
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
export default {
        data(){
            return {
                image: 'https://picsum.photos/id/11/500/300',
                file: {
                    name: '',
                    size: '',
                    type: '',
                },
            }
        },
        methods: {
            onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                console.log(files);
                this.file = files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.image = e.target.result;
                    console.log(file);
                    vm.file.name = file.name;
                    vm.file.size = file.size;
                    vm.file.type = file.type;
                    //vm.file = e.target.file || e.dataTransfer.file;
                };
                reader.readAsDataURL(file);
            },
            saveForm(){
                
                let app = this;
                event.preventDefault();
                axios
                .post('/uploads',{image: app.image, file: app.file})
                .then(res => {
                    this.image = res.path;
                        console.log(res);
                    })
                .catch(err => {
                    console.log(err.response);
                });
            }
        }
    }
</script>