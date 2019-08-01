<template>
  <div>

    <a class="btn btn-warning" href="/csv/export">Export User Data</a>
  <form v-on:submit="saveForm" enctype="multipart/form-data" id="upload_form">
    <v-container grid-list-xl>
        <v-layout wrap>
            <input type="file" name="file" v-on:change="onImageChange" multiple class="form-control m-2 ml-0"/>
                <br>
                <button class="btn btn-success">Import User Data</button>
        </v-layout>
    </v-container>
  </form>
  
  <form v-on:submit="saveFormUpdate" enctype="multipart/form-data" id="update_import">
    <v-container grid-list-xl>
        <v-layout wrap>
            <input type="file" name="file" v-on:change="onImageChange" multiple class="form-control m-2 ml-0 border border-danger"/>
                <button class="btn btn-success mb-2">Import Update User Data</button>
            <div v-if="error && error" class="text-danger ml-2 ">{{ error }}</div>
        </v-layout>
    </v-container>
  </form>
     <v-card-title>
      Users
      <v-spacer></v-spacer>
      <v-text-field
        v-model="search"
        append-icon="search"
        label="Search"
        single-line
        hide-details
      ></v-text-field>
    </v-card-title> 
  <v-data-table
    :headers="headers"
    :items="users"
    :search="search"
    :page.sync="page"
    :items-per-page="5"
    class="elevation-1"
    @page-count="pageCount = $event"
  ></v-data-table>
  </div>
</template>

<script>
  export default {
    data () {
      return {
          search:'',
          error:null,
          file:'',
          page: 2,
          pagination:{
            current: 1,
            total: 0
        },
        headers: [
          {
            text: 'Email (100g serving)',
            value: 'email',
          },
          { text: 'User Name', value: 'name' },
        ],
        users: [],
      }
    },
    methods: {
            read() {
                axios
                .get('/csv?page=' + this.pagination.current)
                .then(res => {
                    const {data:{data}} = res;
                    this.users = data;
                    const {data:{meta}} = res;
                    this.pagination.current = meta.current_page;
                    this.pagination.total = meta.last_page;
                    console.log(data)
                })
                .catch(err=> {
                    console.log(err)
                });
            },
            onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);
            },
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.file = e.target.result;
                    //vm.file = e.target.file || e.dataTransfer.file;
                };
                reader.readAsDataURL(file);
            },
            saveForm(){
                let app = this;
                event.preventDefault();
                 var form = document.getElementById('upload_form');
                var formData = new FormData(form);
                axios
                .post('/csv/import', formData)
                .then(res => {
                    this.read();
                }).
                catch(err => {
                    console.log(err);
                });
            },
            saveFormUpdate(){
                let app = this;
                event.preventDefault();
                 var form = document.getElementById('update_import');
                var formData = new FormData(form);
                axios
                .post('/csv/import/update', formData)
                .then(res => {
                    console.log(res.data);
                    this.read();
                }).
                catch(err => {
                    this.error = err.response.data;
                });
            },
            exportFile() {
                event.preventDefault();
                var url = "{{URL::to('/csv/export')}}?"

                window.location = url;
                axios
                .get('/csv/export')
                .then(res => {
                    this.read();
                }).
                catch(err => {
                    console.log(err);
                });
            }
        },
        mounted() {
            this.read();
        },
  }
</script>