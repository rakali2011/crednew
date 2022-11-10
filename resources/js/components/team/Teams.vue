<template>
    <section class="content">
      <div class="container-fluid">
          <div class="row">
  
            <div class="col-12">
          
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">All Teams</h3>
  
                  <div class="card-tools">
                    
                    <button type="button" class="btn btn-sm btn-primary" @click="newModal">
                        <i class="fa fa-plus-square"></i>
                        Add New
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                  <vue-good-table ref="table"
                    :key="componentKey"
                    :columns="columns"
                    :rows="rows"
                    :pagination-options="{
                      enabled: true
                    }"
                    :search-options="{
                          enabled: true
                    }">
                    <template slot="table-row" slot-scope="props">
                      <span v-if="props.column.field == 'action'">
                        
                        <a @click="editModal(props.row)" href="#"><i class="fa fa-edit blue"></i></a>
                        
                      </span>
                      <span v-else>
                        {{props.formattedRow[props.column.field]}}
                      </span>
                    </template>
                  </vue-good-table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    
                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
      </div>
  <!-- Modal -->
          
          <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" v-show="!editmode">Add New Team</h5>
                          <h5 class="modal-title" v-show="editmode">Edit Team</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                          <form @submit.prevent="editmode ? updateTeam() : createTeam()">
                              <div class="row">
                                  <div class="col-sm-3">
                                      <div class="form-group input-group input-group-sm">
                                          <span class="input-group input-group-sm">Name</span>
                                          <input v-model="form.name" type="text" name="name"
                                              class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                          <has-error :form="form" field="name"></has-error>
                                      </div>
                                  </div>
                              </div>
                              <div class="col-sm-12">
                                <div class="form-group input-group input-group-sm">
                                    <span class="input-group input-group-sm">Assign Users</span>
                                    <multiselect v-model="form.selected_users" :multiple="true" :max-height="200" :options="users.map(user => user.id)" :custom-label="opt => users.find(x => x.id == opt).user_name" placeholder="Assign User">
                                    <template slot="selection" slot-scope="{ values, search, isOpen }"><span class="multiselect__single" v-if="values.length >3 &amp;&amp; !isOpen">{{ values.length }} users selected</span></template>
                                    </multiselect>
                                </div>
                              </div>
                              <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                  <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                                  <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
          </div>
    </section>
  </template>
  <script>
  import { VueGoodTable } from 'vue-good-table';
  import Multiselect from 'vue-multiselect'
      export default {
          components: { VueGoodTable,Multiselect},
          data () {
              return {
        columns: [
          {
            label: 'Name',
            field: 'name',
          },
          {
            label: 'Created On',
            field: 'created_at',
            type: 'date',
            dateInputFormat: 'yyyy-MM-dd\'T\'HH:mm:ss.SSSSSSXXX',
            
            dateOutputFormat: 'MMM do yy',
          },
          {
            label: 'Action',
            field: 'action',
          },
        ],
        users : [],
        rows: [],
                  editmode: false,
                  form: new Form({
                      id : '',
                      name : '',
                      selected_users: [],
                  }),
                  componentKey: 0,
                  testdata:'aaa',
      }
          },
          methods: {
              editModal(row){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(row);
            },
              newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
              forceRerender() {
                  this.componentKey += 1;
                },
              createTeam(){
                this.$Progress.start();
                this.form.post('api/team')
                .then((data)=>{
                  if(data.data.success){
                    $('#addNew').modal('hide');
  
                    Toast.fire({
                          icon: 'success',
                          title: data.message
                      });
                    this.$Progress.finish();
                    this.loadTeams();
                    this.forceRerender();
                  } else {
                    Toast.fire({
                        icon: 'error',
                        title: 'Some error occured! Please try again1'
                    });
  
                    this.$Progress.failed();
                  }
                })
                .catch(()=>{
                    Toast.fire({
                        icon: 'error',
                        title: 'Some error occured! Please try again2!'
                    });
                })
            },
            updateTeam(){
                this.$Progress.start();
                this.form.put('api/team/'+this.form.id)
                .then((response) => {
                    // success
                    $('#addNew').modal('hide');
                    Toast.fire({
                      icon: 'success',
                      title: response.data.message
                    });
                    this.$Progress.finish();
                        //  Fire.$emit('AfterCreate');
                    this.loadTeams();
                })
                .catch(() => {
                    this.$Progress.fail();
                });
  
            },
            
          loadUsers: function () {
                  axios.get('api/user').then(function (res) {
                    console.log(res);
                      this.users = res.data.data.data;
                  }.bind(this));
              },
            loadTeams: function () {
                  axios.get('api/team').then(function (res) {
                    console.log(res);
                      this.rows = res.data.data.data;
                  }.bind(this));
              },
          },
          created: function () {
             this.loadTeams();
             this.loadUsers();
              
          }
      }
  </script>
  