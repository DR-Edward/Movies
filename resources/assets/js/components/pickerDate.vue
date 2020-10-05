<template>
  <v-flex xs12 sm12>
    <v-dialog
      ref="dialog"
      v-model="modal"
      persistent
      lazy
      full-width
      width="290px"
    >
      <template v-slot:activator="{ on }">
        <v-text-field
          v-model="date"
          label="Fecha de publicación"
          prepend-icon="event"
          readonly
          v-on="on"
        ></v-text-field>
      </template>
      <v-date-picker color="#475660" v-model="date" :max="today">
        <v-spacer></v-spacer>
        <v-btn flat color="light-green" @click="selectDate">OK</v-btn>
      </v-date-picker>
    </v-dialog>
  </v-flex>
</template>

<script>
import moment, { now } from "moment";

export default {
  data: () => ({
    modal: false,
    today: "",
    date: "",
  }),
  props: {
    initialDate: String,
  },
  watch: {
    initialDate: function (value) {
      this.date = value;
    },
  },
  methods: {
    now: function () {
      return moment().format("YYYY-MM-DD");
    },
    closeModal: function () {
      this.modal = false;
    },
    selectDate: function () {
      this.$emit("selected", this.date);
      this.closeModal();
    },
  },
  mounted() {
    this.today = this.now();
    this.date = this.today;
  },
};
</script>
