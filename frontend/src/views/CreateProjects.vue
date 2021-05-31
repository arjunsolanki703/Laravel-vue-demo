<template>
  <v-container id="dashboard" fluid tag="section">
    <v-row justify="center">
      <v-col cols="10" offset-md="0">
      <v-col cols="12" class="text-right pr-0">
        <v-btn
        rounded
      color="#f44336"
      dark
      v-if="edit_id!==0"
      @click="archiveProject()"
      ><v-icon color="gray">mdi-delete</v-icon>Archive</v-btn>
      </v-col>
        <v-card>
          <v-tabs vertical>
            <v-toolbar dark style="background: #2a015e; width: 300px;">
              <v-toolbar-title justify="center">User Profile</v-toolbar-title>
            </v-toolbar>

            <v-tab
              ripple
              class="pa-2 tab-button"
              href="#tab-1"
              @click="changeTab('tab-1')"
              v-bind:class="{ active: tab === 'tab-1' }"
            >
              <v-icon left> mdi-account </v-icon>
              Location
            </v-tab>
            <v-tab
            :disabled="this.projectTab"
              ripple
              class="pa-2 tab-button"
              href="#tab-2"
              @click="changeTab('tab-2')"
              v-bind:class="{ active: tab === 'tab-2' }"
            >
              <v-icon left> mdi-lock </v-icon>
              Project Info
            </v-tab>
            <v-tab
            :disabled="this.optionTab"
              ripple
              class="pa-2 tab-button"
              href="#tab-3"
              @click="changeTab('tab-3')"
              v-bind:class="{ active: tab === 'tab-3' }"
            >
              <v-icon left> mdi-access-point </v-icon>
              Select Options
            </v-tab>
            <!-- <v-form> -->
            <v-tab-item value="tab-1" v-if="tab === 'tab-1'">
              <v-card flat>
                <v-container>
                  <p class="error-msgs" v-if="errors.length">
                    <b>Please correct the following error(s):</b>
                    <ul>
                      <li v-for="error in errors" :key="error">{{ error }}</li>
                    </ul>
                  </p>

                  <v-toolbar-title justify="center"
                    >Address Information</v-toolbar-title
                  >
                  <v-row>
                    <v-col cols="12" md="12">
                      <v-text-field
                        v-model="address"
                        label="Type Address"
                        required
                        solo
                      ></v-text-field>
                    </v-col>

                    <v-col cols="12" md="6">
                      <v-text-field
                        v-model="city"
                        label="Type City"
                        required
                        solo
                      ></v-text-field>
                    </v-col>

                    <v-col cols="12" md="6">
                      <v-select
                        :items="items"
                        v-model="state"
                        label="-- Select --"
                        solo
                      ></v-select>
                    </v-col>

                    <v-col cols="12" md="6">
                      <v-text-field
                        v-model="zip"
                        label="Zip"
                        required
                        solo
                      ></v-text-field>
                    </v-col>

                    <v-col cols="12" md="6">
                      <v-text-field
                        v-model="county"
                        label="Country"
                        required
                        solo
                      ></v-text-field>
                    </v-col>

                    <v-col cols="12" md="12" class="text-center">
                      <v-btn
                        rounded
                        color="gray"
                        depressed
                        @click="changeTab('tab-2')"
                      >
                        Next
                      </v-btn>
                    </v-col>
                  </v-row>
                </v-container>
              </v-card>
            </v-tab-item>
            <v-tab-item value="tab-2" v-if="tab === 'tab-2'">
              <v-card flat>
                <v-container>
                  <p class="error-msgs" v-if="errors1.length">
                    <b>Please correct the following error(s):</b>
                    <ul>
                      <li v-for="error in errors1" :key="error">{{ error }}</li>
                    </ul>
                  </p>
                  <v-toolbar-title justify="center"
                    >Project Information</v-toolbar-title
                  >
                  <v-row>
                    <v-col cols="12" md="6">
                      <v-text-field
                        v-model="project_name"
                        label="Enter Project Name"
                        required
                        solo
                      ></v-text-field>
                    </v-col>

                    <v-col cols="12" md="6">
                      <v-text-field
                        v-model="client_po"
                        label="Enter client PO"
                        required
                        solo
                      ></v-text-field>
                    </v-col>

                    <v-col cols="12" md="6">
                      <v-toolbar-title justify="center"
                        >Project Number</v-toolbar-title
                      >
                      <v-text-field
                        v-model="project_number"
                        label="Enter Project Number"
                        required
                        solo
                      ></v-text-field>
                    </v-col>

                    <v-col cols="12" md="12">
                      <v-toolbar-title justify="center"
                        >Project Notes</v-toolbar-title
                      >
                      <v-textarea
                        v-model="project_notes"
                        label="Type Project Notes"
                        required
                        solo
                      ></v-textarea>
                    </v-col>

                    <v-col cols="12" md="12" class="text-center">
                      <v-btn rounded color="yellow" @click="changeTab('tab-1')">
                        Privious
                      </v-btn>
                      <v-btn
                        rounded
                        color="gray"
                        depressed
                        @click="changeTab('tab-3')"
                      >
                        Next
                      </v-btn>
                    </v-col>
                  </v-row>
                </v-container>
              </v-card>
            </v-tab-item>
            <v-tab-item value="tab-3" v-if="tab === 'tab-3'">
              <v-card flat>
                <v-container>
                <p class="error-msgs" v-if="errors2.length">
                  <b>Please correct the following error(s):</b>
                  <ul>
                    <li v-for="error in errors2" :key="error">{{ error }}</li>
                  </ul>
                </p>
                  <v-row>
                    <!-- item -->
                    <v-col cols="12" md="4">
                      <v-card
                        elevation="7"
                        outlined
                        shaped
                        tile
                        class="card-items"
                        v-bind:class="{
                          active:
                            selectedItem === 'iesc_letter' ||
                            this.type === 'iesc_letter',
                        }"
                        @click="selectItem('iesc_letter')"
                      >
                        <v-list-item class="card-items" three-line>
                          <v-list-item-avatar tile size="80" color="grey"
                            >IESC Letter
                          </v-list-item-avatar>
                        </v-list-item>
                      </v-card>
                    </v-col>
                    <!-- item -->
                    <v-col cols="12" md="4">
                      <v-card
                        elevation="7"
                        outlined
                        shaped
                        tile
                        class="card-items"
                        v-bind:class="{
                          active:
                            selectedItem === 'full_structural' ||
                            this.type === 'full_structural',
                        }"
                        @click="selectItem('full_structural')"
                      >
                        <v-list-item class="card-items" three-line>
                          <v-list-item-avatar tile size="80" color="grey"
                            >Full Structural</v-list-item-avatar
                          >
                        </v-list-item>
                      </v-card>
                    </v-col>
                    <v-col cols="12" md="4">
                      <v-card
                        elevation="7"
                        outlined
                        shaped
                        tile
                        class="card-items"
                        v-bind:class="{
                          active:
                            selectedItem === 'electrical' ||
                            this.type === 'electrical',
                        }"
                        @click="selectItem('electrical')"
                      >
                        <v-list-item class="card-items" three-line>
                          <v-list-item-avatar tile size="80" color="grey"
                            >Electrical Stamp</v-list-item-avatar
                          >
                        </v-list-item>
                      </v-card>
                    </v-col>
                    <v-col cols="12" md="4">
                      <v-card
                        elevation="7"
                        outlined
                        shaped
                        tile
                        class="card-items"
                        v-bind:class="{
                          active:
                            selectedItem === 'electrical_fault_study' ||
                            this.type === 'electrical_fault_study',
                        }"
                        @click="selectItem('electrical_fault_study')"
                      >
                        <v-list-item class="card-items" three-line>
                          <v-list-item-avatar tile size="80" color="grey"
                            >Electrical Fault Study</v-list-item-avatar
                          >
                        </v-list-item>
                      </v-card>
                    </v-col>
                    <v-col cols="12" md="12" class="text-center">
                      <v-btn rounded color="yellow" @click="changeTab('tab-2')">
                        Privious
                      </v-btn>
                      <v-btn
                        rounded
                        color="gray"
                        depressed
                        @click="saveProjects"
                        v-if="!this.$route.params.id"
                      >
                        Done
                      </v-btn>
                      <v-btn
                        rounded
                        color="gray"
                        depressed
                        @click="updateProjects"
                        v-if="this.$route.params.id"
                      >
                        Done
                      </v-btn>
                    </v-col>
                  </v-row>
                </v-container>
              </v-card>
            </v-tab-item>
            <!-- </v-form> -->
          </v-tabs>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
import axios from "axios";
export default {
  name: "CreateProjects",
  data() {
    return {
      errors: [],
      errors1: [],
      errors2: [],
      projectTab: true,
      optionTab: true,
      tab: "tab-1",
      selectedItem: "",
      ex7: "red",
      ex8: "primary",
      address: "",
      city: "",
      state: "",
      zip: "",
      county: "",
      project_name: "",
      client_po: "",
      project_number: "",
      project_notes: "",
      type: "",
      selected_type: "",
      items: ["AK - Alaska"],
      edit_id: this.$route.params.id ? this.$route.params.id : 0,
    };
  },
  mounted() {
    this.getRecordById();
  },
  methods: {
    changeTab(tab) {
      // console.log(tab);
      if (tab === "tab-1") {
        this.tab = tab;
        this.projectTab = true;
        this.optionTab = true;
      }
      if (tab === "tab-2") {
        if (
          this.address &&
          this.city &&
          this.state &&
          this.zip &&
          this.county
        ) {
          this.projectTab = false;
          this.optionTab = true;
          this.errors = [];
          this.tab = tab;
          return true;
        }
        this.errors = [];
        if (!this.address) {
          this.errors.push("address required.");
        }
        if (!this.city) {
          this.errors.push("city required.");
        }
        if (!this.state) {
          this.errors.push("state required.");
        }
        if (!this.zip) {
          this.errors.push("zip required.");
        }
        if (!this.county) {
          this.errors.push("country required.");
        }
      }
      if (tab === "tab-3") {
        if (
          this.project_name &&
          this.client_po &&
          this.project_number &&
          this.project_notes
        ) {
          this.optionTab = false;
          this.errors1 = [];
          this.tab = tab;
          return true;
        }
        this.errors1 = [];
        if (!this.project_name) {
          this.errors1.push("project name required.");
        }
        if (!this.client_po) {
          this.errors1.push("client po required.");
        }
        if (!this.project_number) {
          this.errors1.push("project number required.");
        }
        if (!this.project_notes) {
          this.errors1.push("project notes required.");
        }
      }
    },
    selectItem(item) {
      this.selectedItem = item;
      this.type = item;
    },
    saveProjects() {
      if (!this.selectedItem) {
        this.errors2.push("option is  required.");
        return false;
      }
      let project = {
        address: this.address,
        city: this.city,
        state: this.state,
        zip: this.zip,
        county: this.county,
        project_name: this.project_name,
        client_po: this.client_po,
        project_number: this.project_number,
        project_notes: this.project_notes,
        type: this.selectedItem,
        user_id: localStorage.getItem("id"),
        status: "in_process",
      };
      // console.log(project);
      axios({
        url: process.env.VUE_APP_ROOT_API + "/add-project",
        data: project,
        method: "POST",
        headers: { Authorization: "Bearer " + localStorage.token }
      })
        .then((resp) => {
          console.log(resp);
          this.$router.push("/projects").catch(() => {});
        })
        .catch((err) => {
          console.log(err);
        });
    },
    getRecordById() {
      var that = this;
      let edit_id = this.$route.params.id;
      axios
        .get(process.env.VUE_APP_ROOT_API + "/get-project/" + edit_id, {
          headers: { Authorization: "Bearer " + localStorage.token },
        })
        .then(function (response) {
          that.project_name = response.data.data.project_name;
          that.address = response.data.data.address;
          that.city = response.data.data.city;
          that.state = response.data.data.state;
          that.zip = response.data.data.zip;
          that.county = response.data.data.county;
          // that.project_name = response.data.data.project_name;
          that.client_po = response.data.data.client_po;
          that.project_number = response.data.data.project_number;
          that.project_notes = response.data.data.project_notes;
          that.items["items"] = response.data.data.state;
          that.type = that.selected_type = response.data.data.type;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    updateProjects() {
      let project = {
        address: this.address,
        city: this.city,
        state: this.state,
        zip: this.zip,
        county: this.county,
        project_name: this.project_name,
        client_po: this.client_po,
        project_number: this.project_number,
        project_notes: this.project_notes,
        type: this.selectedItem ? this.selectedItem : this.selected_type,
        status: "in_process",
        user_id: localStorage.getItem("id"),
      };
      axios({
        url:
          process.env.VUE_APP_ROOT_API +
          "/update-project/" +
          this.$route.params.id,
        data: project,
        method: "PUT",
      })
        .then((resp) => {
          console.log(resp);
          this.$router.push("/projects").catch(() => {});
        })
        .catch((err) => {
          console.log(err);
        });
    },
    archiveProject() {
      let project_status = {
        status: "archived",
      };
      this.$swal({
        title: "Are you sure?",
        // text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, archive it!",
      }).then((result) => {
        if (result.value) {
          axios({
            url:
              process.env.VUE_APP_ROOT_API +
              "/change-project-status/" +
              this.$route.params.id,
            data: project_status,
            method: "PUT",
          })
            .then((resp) => {
              console.log(resp);
              window.location.reload();
              /* this.$router
            .push("/projectOverview/" + this.$route.params.id)
            .catch(() => {}); */
            })
            .catch((err) => {
              console.log(err);
            });
          this.$swal("Archive!", "Project archived successfully..!", "success");
        }
      });
    },
  },
};
</script>
<style>
.v-card--reveal {
  bottom: 0;
  opacity: 1 !important;
  position: absolute;
  width: 100%;
}
.card-items.v-list-item {
  display: block !important;
  text-align: center !important;
}
.v-avatar.v-list-item__avatar.rounded-0.v-avatar--tile.grey {
  margin: 40px !important;
}
.tab-button.active {
  background: #f5a801;
  color: #1976d2;
}
.card-items.active {
  background-color: #eee !important;
}
.v-application .grey {
  background-color: #d5e209 !important;
  border-color: #d5e209 !important;
  color: #fff;
}
.v-toolbar__content {
  height: 100% !important;
  justify-content: space-around;
}
p.error-msgs {
  color: red;
}
.v-tab--active.active, .active {
  background: #fff !important;
  color: #2a015e !important;
}
.v-tab--disabled {
  background: #2a015e !important;
  color: #fff !important;
  opacity: 1 !important;
}
.v-tab--disabled .v-icon{
  color: #fff !important;
}
</style>