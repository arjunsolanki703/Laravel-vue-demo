<template>
  <v-container id="dashboard" fluid tag="section">
    <v-row justify="center">
      <v-col md="5" offset-md="0">
        <v-card
          class="d-flex justify-space-between justify-center mb-6"
          flat
          tile
        >
          <button
            class="pa-2 tab-button"
            v-bind:class="{ active: tab === 'account' }"
            @click="getActiveTab('account')"
          >
            ACCOUNT INFORMATION
          </button>
          <button
            class="pa-2 tab-button"
            v-bind:class="{ active: tab === 'notification' }"
            @click="getActiveTab('notification')"
          >
            NOTIFICATIONS
          </button>
          <button
            class="pa-2 tab-button"
            v-bind:class="{ active: tab === 'shipping' }"
            @click="getActiveTab('shipping')"
          >
            SHIPPING PROFILES
          </button>
        </v-card>
        <account-information v-if="tab === 'account'"></account-information>
        <notification v-if="tab === 'notification'"></notification>
        <shipping v-if="tab === 'shipping'"></shipping>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: "Account",

  data() {
    return {
      tab: "account",
    };
  },

  components: {
    AccountInformation: () => import("../components/AccountInformation"),
    Notification: () => import("../components/Notification"),
    Shipping: () => import("../components/Shipping"),
  },

  methods: {
    getActiveTab(tab) {
      this.tab = tab;
    },
  },
};
</script>

<style scoped>
.button {
  background: #0f1b51;
  color: #fff;
}
.tab-button {
  background: #e8e8e8;
  padding: 5px;
  font-size: 13px;
  height: fit-content;
  border-radius: 6px;
  width: 32%;
  outline: none;
}
.tab-button.active {
  background: #f5a801;
  color: #fff;
}
</style>
