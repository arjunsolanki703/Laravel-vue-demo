//Login.vue
<template>
  <section class="section-container">
    <v-row class="signin">
      <v-col cols="3"> </v-col>
      <v-col cols="6" class="right">
        <h2>LOGIN TO DASHBOARD</h2>
        <v-alert v-if="loginError" dense outlined type="error">
          Username and password does not match..!
        </v-alert>
        <v-form @submit.prevent="login">
          <label class="login-label" for="">Username</label>
          <v-text-field
            v-model="name"
            :error-messages="nameErrors"
            :counter="10"
            label="Username"
            required
            @input="$v.name.$touch()"
            @blur="$v.name.$touch()"
            solo
          ></v-text-field>
          <label class="login-label" for="">Password</label>
          <v-text-field
            v-model="password"
            :error-messages="passwordErrors"
            :append-icon="show1 ? 'mdi-eye' : 'mdi-eye-off'"
            :rules="[rules.required, rules.min]"
            :type="show1 ? 'text' : 'password'"
            name="input-10-1"
            label="Password"
            hint="At least 8 characters"
            counter
            @click:append="show1 = !show1"
            @input="$v.password.$touch()"
            @blur="$v.password.$touch()"
            solo
          ></v-text-field>

          <v-checkbox
            v-model="checkbox"
            label="Keep me login"
            @change="$v.checkbox.$touch()"
            @blur="$v.checkbox.$touch()"
          ></v-checkbox>

          <v-btn
            class="signin-btn"
            type="submit"
            rounded
            color="white"
            @click="login"
            light
          >
            Sign In
          </v-btn>
        </v-form>
      </v-col>
    </v-row>
  </section>
</template>

<script>
import { validationMixin } from "vuelidate";
import { required, maxLength } from "vuelidate/lib/validators";
import axios from "axios";

export default {
  mixins: [validationMixin],

  validations: {
    name: { required, maxLength: maxLength(10) },
    password: { required },
    select: { required },
    checkbox: {
      checked(val) {
        return val;
      },
    },
  },

  data: () => ({
    loginError: 0,
    loginErrorMessage: "",
    // dataObj: {},
    show1: false,
    name: "admin",
    checkbox: false,
    password: "12345678",
    rules: {
      required: (value) => !!value || "Required.",
      min: (v) => v.length >= 8 || "Min 8 characters",
    },
  }),

  computed: {
    nameErrors() {
      const errors = [];
      if (!this.$v.name.$dirty) return errors;
      !this.$v.name.maxLength &&
        errors.push("Username must be at most 10 characters long");
      !this.$v.name.required && errors.push("Username is required.");
      return errors;
    },
    passwordErrors() {
      const errors = [];
      if (!this.$v.password.$dirty) return errors;
      !this.$v.password.maxLength &&
        errors.push("Password must be at most 8 characters long");
      !this.$v.password.required && errors.push("Password is required.");
      return errors;
    },
    csrf_token() {
      let token = document.head.querySelector('meta[name="csrf-token"]');
      return token.content;
    },
  },

  methods: {
    login({ commit }) {
      let user = {
        username: this.name,
        password: this.password,
      };
      return new Promise((resolve, reject) => {
        this.$store.commit("auth_request");
        axios({
          url: process.env.VUE_APP_ROOT_API + "/login",
          data: user,
          method: "POST",
        })
          .then((resp) => {
            const token = resp.data.data.token;
            const name = resp.data.data.username;
            const id = resp.data.data.id;
            const role = resp.data.data.role;
            // console.log(resp.data.data);
            localStorage.setItem("token", token);
            localStorage.setItem("id", id);
            localStorage.setItem("user_role", role);
            axios.defaults.headers.common["Authorization"] = token;
            this.$store.commit("auth_success", token, name);
            resolve(resp);
            this.$router.push("/projects").catch(() => {});
            /* if (role == "engineer") {
              this.$router.push("/projects").catch(() => {});
            } else {
              this.$router.push("/dashboard").catch(() => {});
            } */
          })
          .catch((err) => {
            this.loginError = 1;
            commit("auth_error");
            localStorage.removeItem("token");
            reject(err);
          });
      });
    },
  },
};
</script>
<style scss>
.theme--light.v-btn.v-btn--has-bg {
  background-color: #fb8c00 !important;
}
.v-alert.v-sheet.v-sheet--outlined.theme--light.v-alert--dense.v-alert--outlined.error--text {
  color: red;
}
.v-text-field.v-text-field--enclosed {
  margin-top: 10px !important;
  padding: 0;
}
</style>