<template>
    <v-card class="overflow-hidden">
    <v-app-bar
    absolute
      color="#43a047"
      dark
      shrink-on-scroll
      prominent
      src="https://picsum.photos/1920/1080?random"
      fade-img-on-scroll
    >
      <template v-slot:img="{ props }">
        <v-img
          v-bind="props"
          gradient="to top right, rgba(19,84,122,.5), rgba(128,208,199,.8)"
        ></v-img>
      </template>

      <v-app-bar-nav-icon></v-app-bar-nav-icon>
      <router-link class="nav-link" tag="li" to="/">Home</router-link>
      <router-link class="nav-link" tag="li" to="/about"> About</router-link>
      <router-link class="nav-link" tag="li" to="/articles"> Article</router-link>
      <router-link class="nav-link" tag="li" to="/contact"> Contact</router-link>
      <router-link class="nav-link" tag="li" to="/upload"> Upload</router-link>
      <router-link class="nav-link" tag="li" to="/users"> User</router-link>
      <v-spacer></v-spacer>

      <v-btn icon>
        <v-icon>search</v-icon>
      </v-btn>

      <v-btn icon>
        <v-icon>favorite</v-icon>
      </v-btn>

      <v-btn icon>
        <v-icon>more_vert</v-icon>
      </v-btn>
    </v-app-bar>
  <v-app>
    
      <v-container style="height: 1500px;">
        <router-view style="margin-top: 150px;"></router-view>
      </v-container>
  </v-app>
  </v-card>
</template>

<style>
    /* Make the cursor a hand when a user hovers over a list item */
    li.nav-link {
            cursor: pointer;
    }
</style>

<script>
export default {
  name: 'HelloWorld',
  data() {
    return {
      msg: 'Welcome to Your Vue.js App'
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h1,
h2 {
  font-weight: normal;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
</style>