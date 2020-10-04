<template>
<v-layout>
  <v-container>
    <v-flex xs12>
      <v-toolbar color="#475660" flat>
        <v-toolbar-title class="white--text">Turnos</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn class="light-green" @click="openCreateModal" v-if="1+1 ? true : false">Crear</v-btn>
      </v-toolbar>
      <v-data-table :headers="vHeaders" disable-initial-sort :items="turns.data || []" hide-actions class="elevation-1">
        <template slot="items" slot-scope="props">
          <td > {{props.item.id }}</td>
          <td class="text-xs-left"> {{ props.item.time }}</td>
          <td class="text-xs-left"> {{ props.item.active ? 'Activo' : 'Inactivo' }}</td>
          <td class="justify-left layout px-0">
            <v-tooltip bottom>
              <v-btn icon flat small slot="activator" color="light-green" @click="openUpdateModal(props.item.id)">
                <v-icon>edit</v-icon>
              </v-btn>
              <span>Editar</span>
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
        <pagination :limit="vPaginator.limit" :data="turns" @pagination-change-page="getData"></pagination>
      </v-card-actions>
    </v-flex>
    <!-- Modal -->
    <turns-create :show.sync="showCreateModal" />
    <turns-update :show.sync="showUpdateModal" :id.sync="elementId" />
  </v-container>
</v-layout>
</template>

<script>
export default {
  data: () => ({
    showCreateModal: false,
    showUpdateModal: false,
    elementId: 1,
    turns: {},
    vPaginator: {
      limit: 10
    },
    vHeaders: [
      {
        text: 'Id',
        value: 'id'
      },
      {
        text: 'Turno',
        value: 'time'
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
    getData: async function (page = this.turns.current_page || 1) {
      const response = await client.index(`/turns`, {
        params: { page, },
      });
      response && (this.turns = response.data);
    },
    updateFieldData: async function(id, state){
      const confirmation = await swal.confirmation();
      if(confirmation){
        const response = await client.patch(`/turns/activator/${id}`,{ active: state });
        response && (alertify.success(response.data.message_text)) && (this.getData());
      }
    },
    deleteData: async function(id){
      const confirmation = await swal.confirmation();
      if(confirmation){
        const response = await client.delete(`/turns/${id}`);
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
