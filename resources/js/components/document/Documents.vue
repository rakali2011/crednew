<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">

          <div class="col-12">
        
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">All Documents</h3>

                <div class="card-tools">
                  
                  <button type="button" class="btn btn-sm btn-primary" @click="newModal">
                      <i class="fa fa-plus-square"></i>
                      Add New
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <vue-good-table
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
                      
                      <a @click="showDocument(props.row)" href="#"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
                      <a href="#"><i class="fa fa-trash red"></i></a>
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
                        <h5 class="modal-title" v-show="!editmode">Add New Document</h5>
                        <h5 class="modal-title" v-show="editmode">Edit Document</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="editmode ? updateDocument() : createDocument()">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group input-group input-group-sm">
                                        <span class="input-group input-group-sm">Select Practice</span>
                                        <multiselect v-model="form.selected_practices" :multiple="false" :options="practices.map(prac => prac.id)" :custom-label="opt => practices.find(x => x.id == opt).practice_name" @input="onChangePractice" placeholder="Select Practice">
                                        <template slot="selection" slot-scope="{ values, search, isOpen }"><span class="multiselect__single" v-if="values.length >3 &amp;&amp; !isOpen">{{ values.length }} practices selected</span></template>
                                        </multiselect>
                                    </div>
                                </div>
                                
                                <div class="col-sm-6">
                                    <div class="form-group input-group input-group-sm">
                                        <span class="input-group input-group-sm">Select Provider
                                            <span v-if="errors && errors.provider_id" class=" text-danger">&nbsp;&nbsp; Provider is reqiured</span>
                                        </span>
                                        <select class="form-control" v-model="form.selected_provider">
                                            <option :value="provider.id" v-for="(provider) in providers" :key="provider.id">{{provider.full_name}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group input-group input-group-sm">
                                        <span class="input-group input-group-sm">Select Document Type</span>                                        
                                        <multiselect v-model="form.selected_doctype" :multiple="false" :options="doctypes.map(prac => prac.id)" :custom-label="opt => doctypes.find(x => x.id == opt).type" placeholder="Assign Practice">
                                        <template slot="selection" slot-scope="{ values, search, isOpen }"><span class="multiselect__single" v-if="values.length >3 &amp;&amp; !isOpen">{{ values.length }} providers selected</span></template>
                                        </multiselect>
                                        <span v-if="errors && errors.document_type_id" class=" text-danger">&nbsp;&nbsp; Document type is reqiured</span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group input-group input-group-sm">
                                        <span class="input-group input-group-sm">Upload</span>
                                        <input type="file" @change="onChange" name="file_name" class="">
                                        <span v-if="errors && errors.file_name" class=" text-danger">&nbsp;&nbsp; Document is reqiured</span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group input-group input-group-sm">
                                        <span class="input-group input-group-sm">Issue Date</span>
                                        <input v-model="form.issue_date" type="date" name="issue_date"
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('issue_date') }">
                                        <has-error :form="form" field="issue_date"></has-error>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group input-group input-group-sm">
                                        <span class="input-group input-group-sm">Expiry Date</span>
                                        <input v-model="form.expiry_date" type="date" name="expiry_date"
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('expiry_date') }">
                                        <has-error :form="form" field="expiry_date"></has-error>
                                    </div>
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
import Multiselect from 'vue-multiselect'
import { VueGoodTable } from 'vue-good-table';

    export default {
        components: { VueGoodTable,Multiselect},
        data () {
            return {
                    columns: [
                        {
                            label: 'Document',
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
                    rows: [],
                    practices: [],
                    providers: [],
                    doctypes: [],
                    editmode: false,
                    file_name:'',
                    errors: {},
                    form: new Form({
                        id : '',
                        file_name : '',
                        selected_provider: [],
                        selected_doctype: [],
                        issue_date:'',
                        expiry_date:'',
                    }),
                    componentKey: 0,
                    testdata:'aaa',
            }
        },
        methods: {
            onChange(e){
            console.log("slected file",e.target.files[0]);
              this.form.file_name = e.target.files[0];
              this.file_name = e.target.files[0];
          },
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

            onChangePractice (id) {
                if(id==null){
                    this.providers=[];
                    form.selected_provider=[];
                }else{
                    axios.get('api/practice/getProviders/'+id).then(function (res) {
                      this.providers = res.data.data;
                    }.bind(this));
                }
            },
            showDocument (row) {
                
                    axios.get('api/document/show/1').then(function (res) {
                      
                    }.bind(this));
                
            },
          
            forceRerender() {
                this.componentKey += 1;
              },
            createDocument(){
              this.errors = {};
              this.$Progress.start();
              let fb = new FormData();
              fb.append('file_name',this.form.file_name);
              fb.append('provider_id',this.form.selected_provider);
              fb.append('document_type_id',this.form.selected_doctype);
              fb.append('issue_date',this.form.issue_date);
              fb.append('expiry_date',this.form.expiry_date);
              axios.post('api/document',fb)
              
              .then((data)=>{
                if(data.data.success){
                  $('#addNew').modal('hide');

                  Toast.fire({
                        icon: 'success',
                        title: data.message
                    });
                  this.$Progress.finish();
                  this.forceRerender();
                } else {
                  Toast.fire({
                      icon: 'error',
                      title: 'Some error occured! Please try again1'
                  });

                  this.$Progress.failed();
                }
              })
              .catch(error=>{
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors || {};
                      }
                  Toast.fire({
                      icon: 'error',
                      title: 'Some error occured! Please try again2!'
                  });
              })
          },
          updateDocument(){
              this.$Progress.start();
              this.form.put('api/document/'+this.form.id)
              .then((response) => {
                  // success
                  $('#addNew').modal('hide');
                  Toast.fire({
                    icon: 'success',
                    title: response.data.message
                  });
                  this.$Progress.finish();
                      //  Fire.$emit('AfterCreate');
                  this.loadDocuments();
              })
              .catch(() => {
                  this.$Progress.fail();
              });

          },
          loadDocuments: function () {
                axios.get('api/document').then(function (res) {
                    this.rows = res.data.data;
                }.bind(this));
            },
          loadPractices: function () {
            axios.get('api/practice/listing').then(function (res) {
            
                this.practices = res.data.data;
            }.bind(this));
            },
                    
          loadDocTypes: function () {
            axios.get('api/document/doctypes').then(function (res) {
            
                this.doctypes = res.data.data;
            }.bind(this));
            },
        },
        created: function () {
           this.loadDocuments();
           this.loadPractices();
           this.loadDocTypes();
            
        }
    }
</script>
