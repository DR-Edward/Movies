<template>
  <div class="text-xs-center">
    <v-dialog v-model="localShow" max-width="850px" persistent>
      <v-card>
        <v-toolbar color="#475660" flat>
          <v-toolbar-title class="white--text">Actualizar Turno</v-toolbar-title>
          <v-spacer />
          <v-btn flat icon color="light-green" dark @click="closeModal">
            <v-icon>close</v-icon>
          </v-btn>
        </v-toolbar>
        <v-card-text>
          <v-container grid-list-md>
            <v-layout wrap>
              <picker-time v-on:selected="updateTime" :initialTime.sync="time"/>
              <v-switch color="#475660" :label="`${ active ? 'Activo' : 'Inactivo' }`" v-model="active"></v-switch>
            </v-layout>
          </v-container>
        </v-card-text>
        <v-divider></v-divider>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="light-green" @click="updateData" flat :loading="vBtnSave.loading"> Guardar </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
export default {
  data: () => ({
    time: "00:00:00",
    active: true,
    localShow: false,
    vBtnSave: {
      loading: false,
    },
  }),
  props: {
    show: Boolean,
    id: Number,
  },
  watch: {
    show: function (value) {
      this.localShow = value;
      value && (this.getData());
    },
    localShow: function (value) {
      this.$emit("update:show", value);
    },
  },
  methods: {
    getData: async function (id = this.id || 1) {
      let response = await client.show(`/turns/${id}`);
      if(response) {
        let { data: { data: { time, active } } } = response;
        this.time = time;
        this.active = active;
      }
    },
    updateData: async function () {
      this.vBtnSave.loading = true;
      let response = await client.update(`/turns/${this.id}`, {
        time: this.time, 
        active: this.active,
      });
      this.vBtnSave.loading = false;
      response && (alertify.success(response.data.message_text)) && (this.closeModal());
    },
    closeModal: function () {
      this.localShow = false;
    },
    updateTime: function (item) {
      this.time = item;
    },
  },
};
</script>
