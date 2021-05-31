<template>
    <v-card elevation="6">
        <v-form>
        <v-container class="pa-5">
            <h5 class="headline font-weight-bold mb-3">
            Select Shipping Profile
            </h5>
            <v-switch
                v-model="isSameAs"
                cols="12"
                inset
                :label="`Same as my billing address`"
            ></v-switch>
            <v-row>
            <v-col
                cols="12"
            >
            <v-list flat>
                <v-list-item-group
                    v-model="selectedItem"
                    color="primary"
                >
                    <v-list-item
                    v-for="(item, i) in items"
                    :key="i"
                    @click="getSelecte(item.id)"
                    >
                    <v-list-item-icon>
                        <v-btn
                            fab
                            dark
                            small
                            color="indigo"
                            v-if="selectedItem == item.id"
                        >
                            <v-icon dark>
                                mdi-check
                            </v-icon>
                        </v-btn>
                        <v-btn
                            fab
                            dark
                            small
                            outlined
                            color="indigo"
                            v-else
                            >
                            <v-icon dark>
                                
                            </v-icon>
                        </v-btn>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title v-text="item.text"></v-list-item-title>
                        <v-list-item-subtitle v-html="item.desc"></v-list-item-subtitle>
                    </v-list-item-content>
                    <v-list-item-icon>
                        <v-btn
                        class="pa-0"
                        dark
                        small
                        color="indigo"
                        >
                        <v-icon dark>
                            mdi-pencil
                        </v-icon>
                        </v-btn>
                    </v-list-item-icon>
                    </v-list-item>
                </v-list-item-group>
            </v-list>
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
    name: 'Shipping',
    data () {
      return {
        isSameAs: false,
        selectedItem: 0,
        items: [
            { id: 0, text: 'Address1', desc: '987 calif' },
            { id: 1, text: 'Adderss2', desc: '987 calif' },
            { id: 2, text: 'Address3', desc: '987 calif' },
        ],
      }
    },

    methods: {
        getSelecte(id) {
            this.selectedItem = id;
        }
    }
}
</script>
