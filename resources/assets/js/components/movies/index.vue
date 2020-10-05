<template>
  <div>
    <v-toolbar color="#475660" flat>
      <v-toolbar-title class="white--text">Películas</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn class="light-green" @click="openCreateModal" v-if="1+1 ? true : false">Crear</v-btn>
    </v-toolbar>
    <v-data-table :headers="vHeaders" disable-initial-sort :items="movies.data || []" hide-actions class="elevation-1">
        <template slot="items" slot-scope="props">
          <td > {{props.item.id }}</td>
          <td class="text-xs-left"> {{ props.item.name }}</td>
          <td class="text-xs-left"> {{ props.item.publicationDate }}</td>
          <td class="text-xs-left">
            <v-chip :color="props.item.active ? 'purple accent-4' : 'purple darken-4'" text-color="white">
              {{ props.item.active ? 'Activo' : 'Inactivo' }}
            </v-chip>
          </td>
          <td class="justify-left layout px-0">
            <v-tooltip bottom>
              <v-btn icon flat small slot="activator" color="light-green" @click="openUpdateModal(props.item.id)">
                <v-icon>edit</v-icon>
              </v-btn>
              <span>Editar</span>
            </v-tooltip>
            <v-tooltip bottom>
              <v-btn icon flat small slot="activator" color="light-blue darken-4" @click="openUpdateModal(props.item.id)">
                <v-icon>fa-bell</v-icon>
              </v-btn>
              <span>Asignar turnos</span>
            </v-tooltip>
            <v-tooltip bottom v-if="props.item.active">
              <v-btn icon flat small slot="activator" color="purple darken-4" @click="updateFieldData(props.item.id, false)">
                <v-icon>fa-lock</v-icon>
              </v-btn>
              <span>Desactivar</span>
            </v-tooltip>
            <v-tooltip bottom v-else>
              <v-btn icon flat small slot="activator" color="purple accent-4" @click="updateFieldData(props.item.id, true)">
                <v-icon>fa-unlock</v-icon>
              </v-btn>
              <span>Activar</span>
            </v-tooltip>
            <v-tooltip bottom>
              <v-btn icon flat small slot="activator" color="error" @click="deleteData(props.item.id)">
                <v-icon>delete</v-icon>
              </v-btn>
              <span>Eliminar</span>
            </v-tooltip>
          </td>
        </template>
    </v-data-table>
    <v-card-actions>
      <v-spacer></v-spacer>
      <pagination :limit="vPaginator.limit" :data="movies" @pagination-change-page="getData"></pagination>
    </v-card-actions>
    <movies-create :show.sync="showCreateModal" />
    <movies-update :show.sync="showUpdateModal" :id.sync="elementId" />
  </div>
</template>

<script>
export default {
  data: () => ({
    showCreateModal: false,
    showUpdateModal: false,
    elementId: 1,
    movies: {},
    vPaginator: {
      limit: 10
    },
    vHeaders: [
      {
        text: 'Id',
        value: 'id'
      },
      {
        text: 'Nombre',
        value: 'name'
      },
      {
        text: 'Fecha de publicación',
        value: 'publicationDate'
      },
      {
        text: 'Estado',
        value: 'active'
      },
      {
        align: 'left',
        text: 'Acciones',
        value: 'acciones',
        sortable: false
      }
    ],
  }),
  watch: {
    showCreateModal: function (value) {
      !value && (this.getData());
    },
    showUpdateModal: function (value) {
      !value && (this.getData());
    },
  },
  methods: {
    getData: async function (page = this.movies.current_page || 1) {
      const response = await client.index(`/movies`, {
        params: { page, },
      });
      response && (this.movies = response.data);
    },
    updateFieldData: async function(id, state){
      const confirmation = await swal.confirmation();
      if(confirmation){
        const response = await client.patch(`/movies/activator/${id}`,{ active: state });
        response && (alertify.success(response.data.message_text)) && (this.getData());
      }
    },
    deleteData: async function(id){
      const confirmation = await swal.confirmation();
      if(confirmation){
        const response = await client.delete(`/movies/${id}`);
        response && (alertify.success(response.data.message_text)) && (this.getData());
      }
    },
    openCreateModal: function () {
      this.showCreateModal = true;
    },
    openUpdateModal: function (id) {
      this.showUpdateModal = true;
      this.elementId = id;
    },
  },
  mounted() {
    this.getData();
  },
};
</script>
