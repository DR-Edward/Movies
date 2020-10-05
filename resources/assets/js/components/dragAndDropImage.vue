<template>
  <v-layout wrap>
    <v-flex xs12 sm12>
        <v-card @dragover.prevent @drop="onDrop">
          <div>
            <v-img
              :src="image"
              min-height="200px"
            >
            </v-img>
          </div>
          <v-card-title primary-title>
            <div>
              <span class="grey--text">Arrastra o selecciona una imagen</span>
            </div>
          </v-card-title>
          <v-card-actions>
            <input type="file" name="image" @change="onChange" />
          </v-card-actions>
        </v-card>
    </v-flex>
  </v-layout>
</template>

<script>
  export default {
    data: () => ({
      image: '',
      imageFile: '',
      modal: false,
    }),
    props: [
      "initialImage",
    ],
    watch: {
      initialImage: function (value) {
        typeof value === 'string' && (this.image = value);
        typeof value === 'object' && (this.image = '');
      },
      imageFile: function (value) {
        this.$emit("imageSelected", value);
      }
    },
    methods: {
      onDrop: function(e) {
        e.stopPropagation();
        e.preventDefault();
        const files = e.dataTransfer.files;
        this.createFile(files[0]);
      },
      onChange(e) {
        const files = e.target.files;
        this.createFile(files[0]);
      },
      createFile(file) {
        if (!file.type.match('image.*')) {
          alertify.error('Selecciona una imagen');
          return;
        }
        this.imageFile = file;
        let reader = new FileReader();
        let vm = this;

        reader.onload = function(e) {
          vm.image = e.target.result;
        }
        reader.readAsDataURL(file);
      },
      removeFile() {
        this.image = '';
      },
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