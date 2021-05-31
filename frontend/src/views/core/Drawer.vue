<template>
  <v-navigation-drawer
    id="core-navigation-drawer"
    v-model="drawer"
    dark
    :style="{ background: '#161d63' }"
    :expand-on-hover="expandOnHover"
    :right="$vuetify.rtl"
    mobile-break-point="960"
    app
    :mini-variant.sync="mini"
    permanent
  >
    <v-divider class="mb-1" />

    <v-list-item dense nav class="pa-0">
      <v-list-item>
        <v-list-item-content>
          <v-icon v-if="mini"> mdi-menu </v-icon>
          <v-btn icon v-if="!mini" @click="mini = !mini">
            <v-icon>mdi-chevron-left</v-icon>
          </v-btn>
        </v-list-item-content>
      </v-list-item>
    </v-list-item>

    <v-divider class="mb-2" />

    <v-list expand nav>
      <div />
      <v-list-item-group>
        <v-list-item v-for="(item, i) in computedItems" :key="i" :to="item.to">
          <v-list-item-icon :style="{ marginLeft: 'auto !important' }">
            <v-icon v-text="item.icon"></v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title v-text="item.title"></v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item @click="logout()">
          <v-list-item-icon :style="{ marginLeft: 'auto !important' }">
            <v-icon>mdi-logout</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title @click="logout()">
              <router-link to="/"> Logout</router-link></v-list-item-title
            >
          </v-list-item-content>
        </v-list-item>
      </v-list-item-group>
      <div />
    </v-list>
  </v-navigation-drawer>
</template>

<script>
// Utilities
import { mapState } from "vuex";
// import axios from "axios";
export default {
  name: "DashboardCoreDrawer",

  props: {
    expandOnHover: {
      type: Boolean,
      default: false,
    },
  },

  data: () => ({
    items: [
      /*  {
        icon: "mdi-view-dashboard",
        title: "dashboard",
        to: "/dashboard",
      }, */
      /*  {
        icon: "mdi-account",
        title: "user",
        to: "/account",
      }, */
      {
        title: "projects",
        icon: "mdi-clipboard-outline",
        to: "/projects",
      },
      /* {
        title: "typography",
        icon: "mdi-format-font",
        to: "/type",
      },
      {
        title: "icons",
        icon: "mdi-chart-bubble",
        to: "/icon",
      },
      {
        title: "google",
        icon: "mdi-map-marker",
        to: "/map",
      },
      {
        title: "notifications",
        icon: "mdi-bell",
        to: "/noti",
      }, */
    ],
    mini: true,
  }),

  computed: {
    ...mapState(["barColor", "barImage"]),
    drawer: {
      get() {
        return this.$store.state.drawer;
      },
      set(val) {
        this.$store.commit("SET_DRAWER", val);
      },
    },
    computedItems() {
      return this.items.map(this.mapItem);
    },
    profile() {
      return {
        avatar: true,
        title: "avatar",
      };
    },
  },

  methods: {
    mapItem(item) {
      return {
        ...item,
        children: item.children ? item.children.map(this.mapItem) : undefined,
        title: item.title,
      };
    },
    logout() {
      localStorage.removeItem("token");
      window.location.href = "/";
    },
  },
};
</script>

<style lang="sass">
@import '~vuetify/src/styles/tools/_rtl.sass'

#core-navigation-drawer
  .v-list-group__header.v-list-item--active:before
    opacity: .24

    .v-list-item
      &__icon--text,
      &__icon:first-child
        justify-content: center
        text-align: center
        width: 20px

        +ltr()
          margin-right: 24px
          margin-left: 12px !important

        +rtl()
          margin-left: 24px
          margin-right: 12px !important

    .v-list--dense
      .v-list-item
        &__icon--text,
        &__icon:first-child
          margin-top: 10px

    .v-list-group--sub-group
      .v-list-item
        +ltr()
          padding-left: 8px

        +rtl()
          padding-right: 8px

      .v-list-group__header
        +ltr()
          padding-right: 0

        +rtl()
          padding-right: 0

        .v-list-item__icon--text
          margin-top: 19px
          order: 0

        .v-list-group__header__prepend-icon
          order: 2

          +ltr()
            margin-right: 8px

          +rtl()
            margin-left: 8px
</style>
