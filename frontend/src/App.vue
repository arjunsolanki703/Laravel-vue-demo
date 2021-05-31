<template>
  <router-view />
</template>

<script>
import axios from "axios";
export default {
  name: "App",
  computed: {
    isLoggedIn: function () {
      return this.$store.getters.isLoggedIn;
    },
  },
  methods: {
    logout() {
      axios
        .post(process.env.VUE_APP_ROOT_API + "/logout")
        .then((response) => {
          console.log(response);
          this.$router.push("/").catch(() => {});
        })
        .catch((error) => {
          console.log(error);
          location.reload();
        });
    },
  },
};
</script>
