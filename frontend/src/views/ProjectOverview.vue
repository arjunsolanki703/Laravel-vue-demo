<template>
  <v-container class="grey lighten-5">
    <v-row no-gutters>
      <v-col cols="12" sm="11" md="11">
        <div>
          <p class="font-weight-black">Project #00002 Overview</p>
        </div>
      </v-col>
      <v-col cols="12" sm="1" md="1">
        <div>
          <v-btn
            rounded
            color="success"
            v-if="role !== 'engineer'"
            dark
            :to="/updateProject/ + data.id"
          >
            <v-icon class="mr-2">{{ icons.mdiPencil }}</v-icon> Edit
          </v-btn>
        </div>
      </v-col>
    </v-row>
    <v-row no-gutters>
      <v-col cols="12" sm="6" md="6">
        <v-card class="pa-2" outlined tile>
          <!-- start -->
          <v-card class="my-auto mb-3" max-width="250" outlined>
            <v-list-item three-line>
              <v-list-item-content>
                <div class="overline mb-4 project-status">Project Status</div>
                <v-list-item-title
                  class="mb-1"
                  v-if="data.status == 'in_process'"
                  >{{ "In Process" }}</v-list-item-title
                >
                <v-list-item-title
                  class="mb-1"
                  v-if="data.status == 'assigned_to_engineer'"
                  >{{ "Assigned To Engineer" }}</v-list-item-title
                >
                <v-list-item-title
                  class="mb-1"
                  v-if="data.status == 'archived'"
                  >{{ "Archived" }}</v-list-item-title
                >
                <v-list-item-title
                  class="mb-1"
                  v-if="data.status == 'completed'"
                  >{{ "Completed" }}</v-list-item-title
                >
              </v-list-item-content>
            </v-list-item>
          </v-card>
          <!-- end -->
          <!-- table view -->
          <v-container class="grey lighten-5">
            <v-row no-gutters>
              <v-col cols="12">
                <v-simple-table>
                  <template v-slot:default>
                    <tbody>
                      <tr>
                        <th class="text-left">ID</th>
                        <td class="text-left">0000{{ data.id }}</td>
                      </tr>
                      <tr>
                        <th class="text-left">Project Name</th>
                        <td class="text-left">{{ data.project_name }}</td>
                      </tr>
                      <tr>
                        <th class="text-left">PO Number</th>
                        <td class="text-left">{{ data.client_po }}</td>
                      </tr>
                      <tr>
                        <th class="text-left">Project Type</th>
                        <td class="text-left">{{ data.type }}</td>
                      </tr>
                      <tr>
                        <th class="text-left">Engineer</th>
                        <td class="text-left">
                          {{
                            data.engineer_name
                              ? data.engineer_name
                              : "Unassigned"
                          }}
                        </td>
                      </tr>
                      <tr>
                        <th class="text-left">Date Created</th>
                        <td class="text-left">
                          {{
                            data.created_at | moment("MMMM D, YYYY H:mm:ss ")
                          }}
                        </td>
                      </tr>
                    </tbody>
                  </template>
                </v-simple-table>
              </v-col>
            </v-row>
          </v-container>
          <!-- assign to me -->
          <v-col v-if="role === 'engineer'">
            <v-row>
              <v-btn
                x-small
                color="orange"
                class="white--text mt-6"
                v-if="
                  data.status !== 'assigned_to_engineer' &&
                  data.status !== 'completed'
                "
                @click="markProjectComplete(data.id, 'assigned_to_engineer')"
              >
                Assign to me
              </v-btn>
            </v-row>
          </v-col>
          <!-- mark as completed -->
          <v-col v-if="role === 'engineer'">
            <v-row>
              <v-btn
                x-small
                color="orange"
                class="white--text mt-6"
                v-if="data.status != 'completed'"
                @click="markProjectComplete(data.id, 'completed')"
              >
                Mark as completed
              </v-btn>
            </v-row>
          </v-col>
          <!-- end table view -->
        </v-card>
      </v-col>
      <v-col cols="6" md="6">
        <v-card class="pa-2" outlined tile>
          <p class="comment-title">Comments</p>
          <v-row
            class="px-2 mb-6"
            v-for="comment in comments_data"
            :key="comment.id"
          >
            <v-col cols="9" md="9">
              <v-avatar>
                <img
                  src="https://cdn.vuetifyjs.com/images/john.jpg"
                  :alt="comment.user_name"
                />
              </v-avatar>
              {{ comment.user_name }}
              <p class="mb-0">
                {{ comment.created_at | moment("hh:mmA MMMM Do, YYYY") }}
              </p>
            </v-col>
            <v-col class="text-right" cols="3" md="3">
              <v-btn
                @click="removeComment(comment.id)"
                class="remove-link"
                color="red"
                >Remove</v-btn
              >
            </v-col>
            <p class="px-3 w-100 comment-content">
              {{ comment.content }}
            </p>
            <v-btn
              v-if="comment.filename[0]"
              :href="comment.path + comment.filename[0]"
              download
              color="white"
              class="ma-2 dark--text resume-btn"
              ><v-icon right color="red" class="pr-6"> mdi-file </v-icon>
              Resume.pdf
              <v-icon right dark> mdi-cloud-download </v-icon>
            </v-btn>
          </v-row>
          <!-- start -->
          <v-row three-line class="mt-6 add-comment-section">
            <v-col cols="8">
              <label class="login-label" for="">Add Comments</label>
              <v-text-field
                v-model="content"
                label="Add comments"
                solo
              ></v-text-field>
            </v-col>
            <v-col cols="1" class="mt-6 add-comment-btn" style="padding: 6px">
              <v-file-input
                class="browse-file"
                accept="doc/*"
                label="File input"
                v-model="files"
                multiple
                clearable
                small-chips
                show-size
                ><v-icon class="mt-2" outlined color="indigo">{{
                  icons.mdiShareVariant
                }}</v-icon></v-file-input
              >
            </v-col>
            <v-col cols="3" class="mt-6 add-comment-btn">
              <v-btn color="orange" class="white--text" @click="submitComment">
                Submit
              </v-btn>
            </v-col>
          </v-row>
          <!-- end -->
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
import { mdiShareVariant, mdiPencil } from "@mdi/js";
import axios from "axios";
export default {
  name: "ProjectOverview",
  data() {
    return {
      role: localStorage.getItem("user_role"),
      content: "",
      files: [],
      data: {},
      comments_data: [],
      icons: {
        mdiShareVariant,
        mdiPencil,
      },
    };
  },
  mounted() {
    this.getCommentsByProjectId();
    this.getRecordById();
  },
  methods: {
    getRecordById() {
      var that = this;
      let edit_id = this.$route.params.id;
      axios
        .get(process.env.VUE_APP_ROOT_API + "/get-project/" + edit_id, {
          headers: { Authorization: "Bearer " + localStorage.token },
        })
        .then(function (response) {
          console.log(response.data.data);
          that.data = response.data.data;
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    getCommentsByProjectId() {
      var comments = this;
      let project_id = this.$route.params.id;
      axios
        .get(
          process.env.VUE_APP_ROOT_API +
            "/get-comment-by-project-id/" +
            project_id,
          {
            headers: { Authorization: "Bearer " + localStorage.token },
          }
        )
        .then(function (response) {
          comments.comments_data = response.data.data;
          console.log(comments.comments_data);
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    submitComment() {
      let formData = new FormData();
      formData.append("project_id", this.$route.params.id);
      formData.append("content", this.content);
      for (var i = 0; i < this.files.length; i++) {
        let file = this.files[i];
        formData.append("file[" + i + "]", file);
      }

      axios({
        url: process.env.VUE_APP_ROOT_API + "/add-comment",
        data: formData,
        method: "POST",
        headers: {
          "Content-Type": "multipart/form-data",
        },
      })
        .then((resp) => {
          console.log(resp);
          window.location.reload();
        })
        .catch((err) => {
          console.log(err);
        });
    },
    removeComment(id) {
      this.$swal({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.value) {
          axios({
            url: process.env.VUE_APP_ROOT_API + "/delete-comment/" + id,
            method: "DELETE",
            headers: {
              "Content-Type": "multipart/form-data",
            },
          })
            .then((resp) => {
              console.log(resp);
              this.$swal(
                "Delete!",
                "Comment deleted successfully..!",
                "success"
              );
              window.location.reload();
            })
            .catch((err) => {
              console.log(err);
            });
        }
      });
    },
    markProjectComplete(id, status) {
      let project_status = {
        engineer_user_id: localStorage.getItem("id"),
        status: status,
      };
      axios({
        url: process.env.VUE_APP_ROOT_API + "/change-project-status/" + id,
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
    },
  },
};
</script>
<style scss>
p.comment-title {
  border-bottom: 1px solid #e8e8e8;
  padding-bottom: 15px;
}
.row.mt-6.add-comment-section {
  margin-top: 27% !important;
}
.project-status {
  color: orange;
}
.add-comment-btn {
  margin-top: 7% !important;
}
.v-application .grey {
  color: #000;
}
.v-input.browse-file {
  background-color: #161d63;
  color: #fff !important;
  height: 37px;
  width: 100%;
  border-radius: 10px;
  padding: 3px 6px;
}
button.v-icon.notranslate.v-icon--link.mdi.mdi-paperclip.theme--light {
  color: #ffffff;
}
.v-application .mt-6 {
  margin-top: 28px !important;
}
.mt-6.add-comment-btn.col.col-1 {
  overflow: hidden;
}
a.ma-2.dark--text.resume-btn.v-btn.v-btn--is-elevated.v-btn--has-bg.theme--light.v-size--default.white {
  background-color: #fff !important;
}
.comment-content {
  width: 100%;
}
button.remove-link.v-btn.v-btn--is-elevated.v-btn--has-bg.theme--light.v-size--default.red {
  color: #f70527 !important;
  font-weight: bold;
  text-decoration: none;
  background-color: #fff !important;
  box-shadow: none;
}
</style>