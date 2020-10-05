<template>
  <div class="text-xs-center">
    <v-dialog v-model="localShow" max-width="850px" persistent>
      <v-card>
        <v-toolbar color="#475660" flat>
          <v-toolbar-title class="white--text">Crear Turno</v-toolbar-title>
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
          <v-switch color="#475660" label="Seguir registrando" v-model="keepStoring"></v-switch>
          <v-spacer></v-spacer>
          <v-btn color="light-green" @click="storeData" flat :loading="vBtnSave.loading"> Guardar </v-btn>
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
      let response = await client.store(`/turns`, {
        time: this.time, 
        active: this.active,
      });
      this.vBtnSave.loading = false;
      if(response){
        this.time = '00:00:00';
        this.active = true;
        alertify.success(response.data.message_text)
        !this.keepStoring && (this.closeModal());
      }
    },
    closeModal: function () {
      this.localShow = false;
      this.keepStoring = true;
    },
    updateTime: function (item) {
      this.time = item;
    },
  },
};
</script>
