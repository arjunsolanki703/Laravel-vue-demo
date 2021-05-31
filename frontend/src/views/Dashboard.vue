<template>
  <v-container
    v-if="this.role !== 'engineer'"
    id="dashboard"
    fluid
    tag="section"
  >
    Account Dashboard
    <v-row>
      <v-col cols="12" md="6">
        <v-card>
          <template v-slot:heading>
            <div class="display-2 font-weight-light">Employees Stats</div>

            <div class="subtitle-1 font-weight-light">
              New employees on 15th September, 2016
            </div>
          </template>
          <v-card-text>
            <v-data-table :headers="headers" :items="items" />
          </v-card-text>
        </v-card>
      </v-col>

      <v-col cols="12" md="6">
        <v-card>
          <v-timeline align-top dense>
            <v-timeline-item color="orange" small>
              <v-row class="pt-1">
                <v-col>
                  Updated the accounts <strong>name, address and zip</strong>
                  <div class="caption">July 12, 2019 , 4:13PM UTC</div>
                </v-col>
              </v-row>
            </v-timeline-item>
            <v-timeline-item color="orange" small>
              <v-row class="pt-1">
                <v-col>
                  Updated the accounts <strong>name, address and zip</strong>
                  <div class="caption">July 12, 2019 , 4:13PM UTC</div>
                </v-col>
              </v-row>
            </v-timeline-item>
            <v-timeline-item color="orange" small>
              <v-row class="pt-1">
                <v-col>
                  Archived <strong>Project #02131</strong>
                  <div class="caption">July 12, 2019 , 4:13PM UTC</div>
                </v-col>
              </v-row>
            </v-timeline-item>
            <v-timeline-item color="orange" small>
              <v-row class="pt-1">
                <v-col>
                  Archived <strong>Project #02131</strong>
                  <div class="caption">July 12, 2019 , 4:13PM UTC</div>
                </v-col>
              </v-row>
            </v-timeline-item>
            <v-timeline-item color="orange" small>
              <v-row class="pt-1">
                <v-col>
                  Updated the <strong>shipping detail</strong>
                  <div class="caption">July 12, 2019 , 4:13PM UTC</div>
                </v-col>
              </v-row>
            </v-timeline-item>
            <v-timeline-item color="orange" small>
              <v-row class="pt-1">
                <v-col>
                  Archived <strong>Project #02131</strong>
                  <div class="caption">July 12, 2019 , 4:13PM UTC</div>
                </v-col>
              </v-row>
            </v-timeline-item>
          </v-timeline>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: "DashboardDashboard",

  data() {
    return {
      role: localStorage.getItem("user_role"),
      dailySalesChart: {
        data: {
          labels: ["M", "T", "W", "T", "F", "S", "S"],
          series: [[12, 17, 7, 17, 23, 18, 38]],
        },
        options: {
          low: 0,
          high: 50, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
          chartPadding: {
            top: 0,
            right: 0,
            bottom: 0,
            left: 0,
          },
        },
      },
      dataCompletedTasksChart: {
        data: {
          labels: ["12am", "3pm", "6pm", "9pm", "12pm", "3am", "6am", "9am"],
          series: [[230, 750, 450, 300, 280, 240, 200, 190]],
        },
        options: {
          low: 0,
          high: 1000, // creative tim: we recommend you to set the high sa the biggest value + something for a better look
          chartPadding: {
            top: 0,
            right: 0,
            bottom: 0,
            left: 0,
          },
        },
      },
      emailsSubscriptionChart: {
        data: {
          labels: [
            "Ja",
            "Fe",
            "Ma",
            "Ap",
            "Mai",
            "Ju",
            "Jul",
            "Au",
            "Se",
            "Oc",
            "No",
            "De",
          ],
          series: [
            [542, 443, 320, 780, 553, 453, 326, 434, 568, 610, 756, 895],
          ],
        },
        options: {
          axisX: {
            showGrid: false,
          },
          low: 0,
          high: 1000,
          chartPadding: {
            top: 0,
            right: 5,
            bottom: 0,
            left: 0,
          },
        },
        responsiveOptions: [
          [
            "screen and (max-width: 640px)",
            {
              seriesBarDistance: 5,
              axisX: {
                labelInterpolationFnc: function (value) {
                  return value[0];
                },
              },
            },
          ],
        ],
      },
      headers: [
        {
          sortable: false,
          text: "ID",
          value: "id",
        },
        {
          sortable: false,
          text: "Name",
          value: "name",
        },
        {
          sortable: false,
          text: "Salary",
          value: "salary",
          align: "right",
        },
        {
          sortable: false,
          text: "Country",
          value: "country",
          align: "right",
        },
        {
          sortable: false,
          text: "City",
          value: "city",
          align: "right",
        },
      ],
      items: [
        {
          id: 1,
          name: "Dakota Rice",
          country: "Niger",
          city: "Oud-Tunrhout",
          salary: "$35,738",
        },
        {
          id: 2,
          name: "Minerva Hooper",
          country: "Curaçao",
          city: "Sinaai-Waas",
          salary: "$23,738",
        },
        {
          id: 3,
          name: "Sage Rodriguez",
          country: "Netherlands",
          city: "Overland Park",
          salary: "$56,142",
        },
        {
          id: 4,
          name: "Philip Chanley",
          country: "Korea, South",
          city: "Gloucester",
          salary: "$38,735",
        },
        {
          id: 5,
          name: "Doris Greene",
          country: "Malawi",
          city: "Feldkirchen in Kārnten",
          salary: "$63,542",
        },
      ],
      tabs: 0,
      tasks: {
        0: [
          {
            text:
              'Sign contract for "What are conference organizers afraid of?"',
            value: true,
          },
          {
            text:
              "Lines From Great Russian Literature? Or E-mails From My Boss?",
            value: false,
          },
          {
            text:
              "Flooded: One year later, assessing what was lost and what was found when a ravaging rain swept through metro Detroit",
            value: false,
          },
          {
            text: "Create 4 Invisible User Experiences you Never Knew About",
            value: true,
          },
        ],
        1: [
          {
            text:
              "Flooded: One year later, assessing what was lost and what was found when a ravaging rain swept through metro Detroit",
            value: true,
          },
          {
            text:
              'Sign contract for "What are conference organizers afraid of?"',
            value: false,
          },
        ],
        2: [
          {
            text:
              "Lines From Great Russian Literature? Or E-mails From My Boss?",
            value: false,
          },
          {
            text:
              "Flooded: One year later, assessing what was lost and what was found when a ravaging rain swept through metro Detroit",
            value: true,
          },
          {
            text:
              'Sign contract for "What are conference organizers afraid of?"',
            value: true,
          },
        ],
      },
      list: {
        0: false,
        1: false,
        2: false,
      },
    };
  },

  methods: {
    complete(index) {
      this.list[index] = !this.list[index];
    },
  },
};
</script>
