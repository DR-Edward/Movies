<template>
  <div class="text-xs-center">
    <v-dialog v-model="localShow" max-width="850px" persistent>
      <v-card>
        <v-toolbar color="#475660" flat>
          <v-toolbar-title class="white--text">Asignar turnos</v-toolbar-title>
          <v-spacer />
          <v-btn flat icon color="light-green" dark @click="closeModal">
            <v-icon>close</v-icon>
          </v-btn>
        </v-toolbar>
        <v-card-text>
          <v-data-table
            :headers="vHeaders"
            disable-initial-sort
            :items="turns.data || []"
            hide-actions
            class="elevation-1"
          >
            <template slot="items" slot-scope="props">
              <td>
                <v-switch
                  :value="props.item.id"
                  class="mt-0"
                  color="#475660"
                  v-model="turnsSelected"
                ></v-switch>
              </td>
              <td>{{ props.item.id }}</td>
              <td class="text-xs-left">{{ props.item.time }}</td>
              <td class="text-xs-left">
                <v-chip
                  :color="
                    props.item.active ? 'purple accent-4' : 'purple darken-4'
                  "
                  text-color="white"
                >
                  {{ props.item.active ? "Activo" : "Inactivo" }}
                </v-chip>
              </td>
            </template>
          </v-data-table>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-spacer></v-spacer>
          <pagination
            :limit="vPaginator.limit"
            :data="turns"
            @pagination-change-page="getData"
          ></pagination>
          <v-btn
            color="light-green"
            @click="storeData"
            flat
            :loading="vBtnSave.loading"
          >
            Guardar
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import moment, { now } from "moment";

export default {
  data: () => ({
    turns: {},
    turnsSelected: [],
    localShow: false,
    vBtnSave: {
      loading: false,
    },
    vPaginator: {
      limit: 10,
    },
    vHeaders: [
      {
        text: "Seleccionados",
        value: "selected",
      },
      {
        text: "Id",
        value: "id",
      },
      {
        text: "Turno",
        value: "time",
      },
      {
        text: "Estado",
        value: "active",
      },
    ],
  }),
  props: {
    show: Boolean,
    id: Number,
  },
  watch: {
    show: function (value) {
      this.localShow = value;
      value && this.getData() && this.getMovieData();
    },
    localShow: function (value) {
      this.$emit("update:show", value);
    },
  },
  methods: {
    getData: async function (page = this.turns.current_page || 1) {
      const response = await client.index(`/turns`, {
        params: { page },
      });
      response && (this.turns = response.data);
    },
    getMovieData: async function (id = this.id || 1) {
      const response = await client.show(`/movies/${id}`);
      if (response) {
        this.turnsSelected = response.data.data.turns.map(
          (element) => element.id
        );
      }
    },
    storeData: async function () {
      this.vBtnSave.loading = true;
      let response = await client.patch(`/movies/turns/${this.id}`, {
        turns_id: this.turnsSelected,
      });
      this.vBtnSave.loading = false;
      if (response) {
        alertify.success(response.data.message_text);
      }
    },
    closeModal: function () {
      this.localShow = false;
      this.turnsSelected = [];
    },
  },
};
</script>
