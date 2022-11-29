<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">

          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Update Applications</h3>
                
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <div class="modal-body">
                        <form @submit.prevent="editmode ? updateDocument() : updateApplications()">
                            
                            <div class="row quickupdate_headerbox">
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
                                        <span class="input-group input-group-sm">Select Provider</span>
                                        <multiselect v-model="form.selected_provider" :multiple="false" :options="providers.map(pro => pro.id)" :custom-label="opt => providers.find(x => x.id == opt).first_name" placeholder="Select Provider">
                                        <template slot="selection" slot-scope="{ values, search, isOpen }"><span class="multiselect__single" v-if="values.length >3 &amp;&amp; !isOpen">{{ values.length }} providers selected</span></template>
                                        </multiselect>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group input-group input-group-sm">
                                        <span class="input-group input-group-sm">Payer Name</span>
                                        
                                        <multiselect v-model="form.selected_payer" :multiple="false" :options="payers.map(prac => prac.id)" :custom-label="opt => payers.find(x => x.id == opt).name" placeholder="Select Payer">
                                        <template slot="selection" slot-scope="{ values, search, isOpen }"><span class="multiselect__single" v-if="values.length >3 &amp;&amp; !isOpen">{{ values.length }} providers selected</span></template>
                                        </multiselect>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group input-group input-group-sm">
                                        <span class="input-group input-group-sm">Status</span>
                                        <select name="status[]" v-model="form.status" id="type" class="form-control" :class="{ 'is-invalid': form.errors.has('status') }">
                                            <option value="new">New</option>
                                            <option value="participating">Participating</option>
                                            <option value="non-participating">Non-Participating</option>
                                            <option value="in-process">In Process</option>
                                            <option value="pending-bm">Pending BM</option>
                                            <option value="pending-provider">Pending Provider</option>
                                            <option value="rejected">Rejected</option>
                                            <option value="not-eligible">Not Eligible</option>
                                            <option value="panel-closed">Panel Closed</option>
                                            <option value="approved">Approved</option>
                                        </select>
                                        <has-error :form="form" field="status"></has-error>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group input-group input-group-sm">
                                        <span class="input-group input-group-sm">Provider ID</span>
                                        <input v-model="form.provider_identifier" type="text" name="provider_identifier"
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('provider_identifier') }">
                                            <has-error :form="form" field="provider_identifier"></has-error>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group input-group input-group-sm">
                                        <span class="input-group input-group-sm">Effective Date</span>
                                        <input v-model="form.effective_date" type="date" name="effective_date"
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('effective_date') }">
                                        <has-error :form="form" field="effective_date"></has-error>
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <div class="form-group input-group input-group-sm">
                                        <span class="input-group input-group-sm">Remarks</span>
                                        <input v-model="form.remarks" type="text" name="remarks"
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('remarks') }">
                                            <has-error :form="form" field="remarks"></has-error>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                                <button v-show="!editmode" type="submit" class="btn btn-primary">Save</button>
                            </div>

<div class="row">
            <div class="col-xs-2">
                <button type="button" v-on:click="addNewApartment" class="btn btn-block btn-success">
                    Add +
                </button>
            </div>
            <div class="col-xs-10">
                Would you like add more apartments?
            </div>
        </div>
        <div v-for="(apartment, index) in apartments">
            <div class="row">
                <div class="col-xs-2">
                    <label>&nbsp;</label>
                    <button type="button" v-on:click="removeApartment(index)" class="btn btn-block btn-danger">
                        Rem -
                    </button>
                </div>
                <div class="form-group col-xs-5">
                    <label>Price (HUF)</label>
                    <input v-model="apartment.price" type="number"
                           name="apartments[][price]" class="form-control" placeholder="Price">
                </div>
                <div class="form-group col-xs-5">
                    <label>Rooms (PCS)</label>
                    <input v-model="apartment.rooms" type="number"
                           name="apartments[][rooms]" class="form-control" placeholder="Rooms">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-2">
                <button type="submit" v-on:click.prevent="sumbitForm" class="btn btn-block btn-primary">
                    Submit
                </button>
            </div>
            <div class="col-xs-10">
                Open the console (F12) and see the result
            </div>
        </div>
        <hr>
        <pre>{{ $data }}</pre>


                        </form>
                    </div>
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
                    rows: [],
                    practices: [],
                    providers: [],
                    payers: [],
                    editmode: false,
                    file_name:'',
                    form: new Form({
                        id : '',
                        selected_provider: [],
                        selected_payer: [],
                        provider_identifier: [],
                        status: [],
                        effective_date: [],
                        remarks: [],
                    }),
                    componentKey: 0,
                    apartment: {
                        price: '',
                        rooms: ''
                    },
                    apartments: [],
            }
        },
        methods: {
                    addNewApartment: function () {
                        this.apartments.push(Vue.util.extend({}, this.apartment))
                    },
                    removeApartment: function (index) {
                        Vue.delete(this.apartments, index);
                    },
                    sumbitForm: function () {
                        /*
                         * You can remove or replace the "submitForm" method.
                         * Remove: if you handle form sumission on server side.
                         * Replace: for example you need an AJAX submission.
                         */
                        console.info('<< Form Submitted >>')
                        console.info('Vue.js apartments object:', this.apartments)
                        window.testSumbit()
                    },
            
            onChangePractice (id) {
                if(id==null){
                    this.providers=[];
                }else{
                    axios.get('api/practice/getProviders/'+id).then(function (res) {
                      this.providers = res.data.data;
                    }.bind(this));
                }
            },
            
          
            forceRerender() {
                this.componentKey += 1;
              },
            updateApplications(){
              this.$Progress.start();
              this.form.post('api/quickupdate-form-submit')
              .then((data)=>{
                if(data.data.success){

                  Toast.fire({
                        icon: 'success',
                        title: data.message
                    });
                  this.$Progress.finish();
                  this.forceRerender();
                } else {
                  Toast.fire({
                      icon: 'error',
                      title: 'Some error occured! Please try again.'
                  });

                  this.$Progress.failed();
                }
              })
              .catch(()=>{
                  Toast.fire({
                      icon: 'error',
                      title: 'Some error occured! Please try again'
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
                    this.rows = res.data.data.data;
                }.bind(this));
            },
          loadPractices: function () {
            axios.get('api/practice/listing').then(function (res) {
            
                this.practices = res.data.data;
            }.bind(this));
            },
                    
          loadPayers: function () {
            axios.get('api/payer/listing').then(function (res) {
            
                this.payers = res.data.data;
            }.bind(this));
            },
        },
        created: function () {
           this.loadDocuments();
           this.loadPractices();
           this.loadPayers();
            
        }
    }
</script>
