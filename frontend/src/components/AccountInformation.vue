<template>
  <v-card elevation="6">
    <v-form>
      <v-container class="pa-5">
        <h5 class="headline font-weight-bold mb-3">Account Information</h5>
        <v-row>
          <v-col class="pb-0" cols="12" md="6">
            <v-text-field class="purple-input" label="First Name" />
          </v-col>

          <v-col class="pb-0" cols="12" md="6">
            <v-text-field label="Last Name" class="purple-input" />
          </v-col>

          <v-col class="pb-0" cols="12" md="12">
            <v-text-field label="Company" class="purple-input" />
          </v-col>

          <v-col class="pb-0" cols="12" md="12">
            <v-text-field label="Email" class="purple-input" />
          </v-col>

          <v-col class="pb-0" cols="12">
            <v-text-field label="Street Adress" class="purple-input" />
          </v-col>

          <v-col class="pb-0" cols="12" md="5">
            <v-text-field label="City" class="purple-input" />
          </v-col>

          <v-col class="pb-0" cols="12" md="3">
            <v-text-field label="State" class="purple-input" />
          </v-col>

          <v-col class="pb-0" cols="12" md="4">
            <v-text-field class="purple-input" label="Zip Code" type="number" />
          </v-col>

          <v-col class="pb-0" cols="12">
            <v-text-field label="Phone Number" class="purple-input" />
          </v-col>

          <v-col class="pb-0" cols="12">
            <v-text-field label="Website" class="purple-input" />
          </v-col>

          <v-col class="pb-0" cols="12" md="6">
            <v-text-field class="purple-input" label="Password" />
          </v-col>

          <v-col class="pb-0" cols="12" md="6">
            <v-text-field label="Confirm Password" class="purple-input" />
          </v-col>

          <v-col cols="12" class="text-center">
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
export default {};
</script>
