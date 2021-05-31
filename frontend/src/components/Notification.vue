<template>
    <v-card elevation="6">
        <v-form>
        <v-container class="pa-5">
            <h5 class="headline font-weight-bold mb-3">
            Notification Settings
            </h5>
            <v-row>

            <v-col
                class="pb-0"
                cols="12"
                md="5"
            >
                <v-switch
                v-model="email"
                inset
                :label="`Email Notifications`"
                ></v-switch>
            </v-col>

            <v-col
                class="pb-0"
                cols="12"
                md="5"
            >
                <v-switch
                v-model="internal"
                inset
                :label="`Internal Notifications`"
                ></v-switch>
            </v-col>

            <v-col
                cols="12"
                class="text-center"
            >
                <v-btn
                color="#0f1b51"
                class="mr-0"
                rounded
                dark
                width="200"
                height="45"
                >
                Save Changes
                </v-btn>
            </v-col>
            </v-row>
        </v-container>
        </v-form>
    </v-card>
</template>

<script>
export default {
    name: 'Notification',
    data () {
      return {
        email: false,
        internal: false,
      }
    }
}
</script>
