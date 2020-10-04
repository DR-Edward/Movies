<template>
  <v-flex xs12 sm12 >
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
          v-model="time"
          label="Elija la hora"
          prepend-icon="fa-clock"
          readonly
          v-on="on"
        ></v-text-field>
      </template>
      <v-time-picker
        color="#475660"
        v-model="time"
        format="24hr" 
        use-seconds
      >
        <v-spacer></v-spacer>
        <v-btn flat color="error" @click="closeModal">Cancel</v-btn>
        <v-btn flat color="light-green" @click="selectTime">OK</v-btn>
      </v-time-picker>
    </v-dialog>
  </v-flex>
</template>

<script>
export default {
  data: () => ({
    modal: false,
    time: "00:00:00",
  }),
  props: {
    initialTime: String,
  },
  watch: {
    initialTime: function (value) {
      this.time = value;
    },
  },
  methods: {
    closeModal: function () {
      this.modal = false;
    },
    selectTime: function(){
      this.$emit("selected", this.time);
      this.closeModal();
    }
  }
};
</script>
