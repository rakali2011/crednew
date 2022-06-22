<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">

          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Update Provider's Enrollment</h3>
                

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
                                        <span class="input-group input-group-sm">Select Provider
                                            <span v-if="errors && errors.provider_id" class=" text-danger">&nbsp;&nbsp; Provider is reqiured</span>
                                        </span>
                                        <select class="form-control" v-model="form.selected_provider" @change="onChangeProvider($event)">
                                            <option :value="provider.id" v-for="(provider) in providers" :key="provider.id">{{provider.full_name}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">&nbsp;</div>
                            <div class="row">
                                <div class="col-sm-2">
                                    <button type="button" v-on:click="addNewApartment" class="btn btn-block btn-success">
                                        Add +
                                    </button>
                                </div>
                                <div class="col-sm-10">
                                    Would you like add more applications?
                                </div>
                            </div>
                            <div v-for="(apartment, index) in apartments">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <label>&nbsp;</label>
                                        <button type="button" v-on:click="removeApartment(index)" class="btn btn-block btn-danger">
                                            Rem -
                                        </button>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label>Payer Name</label>
                                        <multiselect v-model="apartment.app_name" :multiple="false" :options="payers.map(prac => prac.id)" :custom-label="opt => payers.find(x => x.id == opt).name" placeholder="Select Payer">
                                        <template slot="selection" slot-scope="{ values, search, isOpen }"><span class="multiselect__single" v-if="values.length >3 &amp;&amp; !isOpen">{{ values.length }} providers selected</span></template>
                                        </multiselect>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label>Status</label>
                                        <select v-model="apartment.appstatus" name="apartments[][appstatus]"  class="form-control">
                                            <option value="new">New</option>
                                            <option value="participating">Participating</option>
                                            <option value="non-participating">Non-Participating</option>
                                            <option value="in-process">In Process</option>
                                            <option value="pending-prg">Pending PRG</option>
                                            <option value="pending-provider">Pending Provider</option>
                                            <option value="rejected">Rejected</option>
                                            <option value="not-eligible">Not Eligible</option>
                                            <option value="panel-closed">Panel Closed</option>
                                            <option value="approved">Approved</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label>Effective Date</label>
                                        <input v-model="apartment.appeffective_date" type="date"
                                               name="apartments[][appeffective_date]" class="form-control" placeholder="appeffective date">
                                    </div>

                                    <div class="form-group col-sm-2">
                                        <label>Provider Identifier</label>
                                        <input v-model="apartment.provider_identifier" type="text"
                                               name="apartments[][provider_identifier]" class="form-control" placeholder="Provider Identifier">
                                    </div>
                                    <div class="form-group col-sm-2">
                                        <label>Initiated Date</label>
                                        <input v-model="apartment.appinitiated_date" type="date"
                                               name="apartments[][appinitiated_date]" class="form-control" placeholder="Initiated Date">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label>Remarks</label>
                                        <input v-model="apartment.app_remarks" type="text"
                                               name="apartments[][app_remarks]" class="form-control" placeholder="Remarks">
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" v-on:click.prevent="updateApplications" class="btn btn-primary">Save</button>
                            </div>

        
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
                    editmode:false,
                    errors: {},
                    form: new Form({
                        id : '',
                        selected_provider: [],
                        selected_payer: [],
                        provider_identifier: [],
                        status: [],
                        effective_date: [],
                        initiated_date: [],
                        remarks: [],
                    }),
                    
                    apartment: {
                        appstatus:'',
                        appeffective_date:'',
                        app_name:'',
                        provider_identifier: '',
                        appinitiated_date: '',
                        app_remarks: ''
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
                        
                    },
            
            onChangePractice (id) {
                if(id==null){
                    this.providers=[];
                    this.form.provider_id='';
                    this.form.selected_provider='';
                    
                }else{
                    this.apartments=[];
                    
                    axios.get('api/practice/getProviders/'+id).then(function (res) {
                      this.providers = res.data.data;
                    }.bind(this));
                }
            },
            onChangeProvider (event) {
                let id=event.target.value;
                if(id==null){
                    id=0;
                }
                axios.get('api/provider/show/'+id).then(function (res) {
                    this.apartments = res.data.data
                        console.log(res.data);
                    }.bind(this));
            },
            
            updateApplications(){
              this.errors = {};
              this.$Progress.start();
              let fb = new FormData();
              fb.append('applications',JSON.stringify(this.apartments));
                        fb.append('provider_id',this.form.selected_provider);
                        axios.post('api/quickupdate-form-submit',fb)
              .then((data)=>{
                if(data.data.success){

                  Toast.fire({
                        icon: 'success',
                        title: data.message
                    });
                  this.$Progress.finish();
                  
                } else {
                  Toast.fire({
                      icon: 'error',
                      title: 'Some error occured! Please try again.'
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
                  
              })
              .catch(() => {
                  this.$Progress.fail();
              });

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
           
           this.loadPractices();
           this.loadPayers();
            
        }
    }
</script>
