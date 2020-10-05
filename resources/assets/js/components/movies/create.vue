<template>
  <div class="text-xs-center">
    <v-dialog v-model="localShow" max-width="850px" persistent>
      <v-card>
        <v-toolbar color="#475660" flat>
          <v-toolbar-title class="white--text">Crear Película</v-toolbar-title>
          <v-spacer />
          <v-btn flat icon color="light-green" dark @click="closeModal">
            <v-icon>close</v-icon>
          </v-btn>
        </v-toolbar>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout wrap>
              <v-text-field
                color="#475660"
                single-line
                prepend-icon="fa-film"
                label="Nombre"
                v-model="name"
              ></v-text-field>
              <picker-date
                v-on:selected="updateDate"
                :initialDate.sync="publicationDate"
              />
              <v-flex xs12 sm12 md12 lg12 xl12>
                <v-switch
                  class="mt-0"
                  color="#475660"
                  :label="`${active ? 'Activo' : 'Inactivo'}`"
                  v-model="active"
                ></v-switch>
              </v-flex>
              <drag-n-drop-image
                v-on:imageSelected="upadteImage"
                :initialImage.sync="image"
              />
            </v-layout>
          </v-container>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-switch
            color="#475660"
            label="Seguir registrando"
            v-model="keepStoring"
          ></v-switch>
          <v-spacer></v-spacer>
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
    image: "",
    name: "",
    publicationDate: moment().format("YYYY-MM-DD"),
    active: true,
    localShow: false,
    keepStoring: true,
    vBtnSave: {
      loading: false,
    },
  }),
  props: {
    show: Boolean,
  },
  watch: {
    show: function (value) {
      this.localShow = value;
    },
    localShow: function (value) {
      this.$emit("update:show", value);
    },
  },
  methods: {
    storeData: async function () {
      this.vBtnSave.loading = true;
      const formData = new FormData();
      formData.append("name", this.name);
      formData.append("publicationDate", this.publicationDate);
      formData.append("active", this.active);
      formData.append("image", this.image);
      formData.append("updateImage", true);
      let response = await client.store(`/movies`, formData);
      this.vBtnSave.loading = false;
      if (response) {
        this.name = "";
        this.publicationDate = moment().format("YYYY-MM-DD");
        this.active = true;
        this.image = "";
        alertify.success(response.data.message_text);
        !this.keepStoring && this.closeModal();
      }
    },
    closeModal: function () {
      this.localShow = false;
      this.keepStoring = true;
    },
    updateDate: function (item) {
      this.publicationDate = item;
    },
    upadteImage: function (item) {
      this.image = item;
    },
  },
};
</script>
