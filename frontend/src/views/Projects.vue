<template>
  <v-container>
    <p>Projects</p>
    <div class="my-2">
      <v-btn
        to="/CreateProjects"
        v-if="role !== 'engineer'"
        class="create-btn"
        color="success"
      >
        Create
      </v-btn>
      <v-btn color="gray" @click="projects()" class="reload-btn">
        Reload
      </v-btn>
    </div>
    <!-- <v-row> -->
    <v-card>
      <v-data-table :headers="headers" :items="items" :search="search">
        <template v-slot:item="props">
          <tr>
            <td>0000{{ props.item.id }}</td>
            <td>{{ props.item.project_name }}</td>
            <td>{{ props.item.type }}</td>
            <td>
              <v-label class="mb-1" v-if="props.item.status == 'in_process'">{{
                "In Process"
              }}</v-label>
              <v-label
                class="mb-1"
                v-if="props.item.status == 'assigned_to_engineer'"
                >{{ "Assigned To Engineer" }}</v-label
              >
              <v-label class="mb-1" v-if="props.item.status == 'archived'">{{
                "Archived"
              }}</v-label>
              <v-label class="mb-1" v-if="props.item.status == 'completed'">{{
                "Completed"
              }}</v-label>
            </td>
            <td>
              {{
                props.item.engineer_name
                  ? props.item.engineer_name
                  : "Unassigned"
              }}
            </td>
            <td>{{ props.item.user_id }}</td>
            <td>
              {{ props.item.created_at | moment("YYYY-MM-D H:mm:ss") }}
            </td>
            <td width="15%">
              <v-btn
                class="ma-2 action-overview-btn"
                outlined
                color="indigo"
                :to="/projectOverview/ + props.item.id"
              >
                <v-icon color="gray">mdi-magnify</v-icon>
              </v-btn>
              <v-btn
                v-if="role !== 'engineer'"
                class="ma-2 action-update-btn"
                outlined
                color="indigo"
                :to="/updateProject/ + props.item.id"
              >
                <v-icon color="gray">mdi-pencil</v-icon>
              </v-btn>
              <v-btn
                v-if="role !== 'engineer'"
                class="ma-2 action-delete-btn"
                outlined
                color="indigo"
                @click="archiveProject(props.item.id)"
              >
                <v-icon color="gray">mdi-delete</v-icon>
              </v-btn>
            </td>
          </tr>
        </template>
      </v-data-table>
    </v-card>
    <!-- </v-row> -->
  </v-container>
</template>
<script>
import axios from "axios";
export default {
  data() {
    return {
      role: localStorage.getItem("user_role"),
      search: "",
      headers: [
        { text: "ID", value: "id" },
        { text: "Project Name", value: "project_name" },
        { text: "Project Type", value: "type" },
        { text: "Status", value: "status" },
        { text: "Assign To", value: "assign_to" },
        { text: "Created By", value: "user_id" },
        { text: "Created Date", value: "created_at" },
        { text: "Action", value: "" },
      ],
      items: [],
    };
  },
  mounted() {
    this.projects();
  },
  methods: {
    projects() {
      var self = this;
      this.items = [];
      axios
        .get(process.env.VUE_APP_ROOT_API + "/get-project", {
          headers: { Authorization: "Bearer " + localStorage.token },
        })
        .then(function (response) {
          self.items = response.data.data.map((item) => {
            return {
              id: item.id,
              project_name: item.project_name,
              type: item.type,
              status: item.status,
              assign_to: item.status,
              user_id: item.user_name,
              engineer_name: item.engineer_name,
              created_at: item.created_at,
            };
          });
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    updateRecord(id) {
      this.$router.push("/updateProject/" + id).catch(() => {});
    },
    archiveProject(id) {
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
            url: process.env.VUE_APP_ROOT_API + "/change-project-status/" + id,
            data: project_status,
            method: "PUT",
          })
            .then((resp) => {
              console.log(resp);
              window.location.reload();
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
<style scss>
.ma-2.action-overview-btn {
  height: 30px !important;
  min-width: 30px !important;
  padding: 3px !important;
  color: gray !important;
}
.ma-2.action-update-btn {
  height: 30px !important;
  min-width: 30px !important;
  padding: 3px !important;
  color: rgb(42 22 208) !important;
}
.ma-2.action-delete-btn {
  height: 30px !important;
  min-width: 30px !important;
  padding: 3px !important;
  color: red !important;
}

.v-application .ma-2 {
  margin: 3px !important;
}
.create-btn {
  background-color: #4caf50 !important;
  border-color: #4caf50 !important;
}
.reload-btn {
  background-color: #f5f5f5 !important;
  border-color: #f5f5f5 !important;
}
</style>