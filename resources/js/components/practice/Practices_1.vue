<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">

          <div class="col-12">
        
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Practice List</h3>

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
                      
                      <a @click="profileModal(props.row)" href="#"><i class="fa fa-info-circle" aria-hidden="true"></i></a>
                      <a @click="editModal(props.row)" href="#"><i class="fa fa-edit blue"></i></a>
                      <a @click="docModal(props.row)" href="#"><i class="nav-icon fas fa-file"></i></a>
                      
                      <a href="#" @click="deletePractice(props.row.id)">
                        <i class="fa fa-trash red"></i>
                      </a>
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

        <!-- Modal -->
        <div class="modal fade" id="docNew" tabindex="-1" role="dialog" aria-labelledby="docNew" aria-hidden="true">
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
                                        <span class="input-group input-group-sm">Select Document Type</span>                                        
                                        <multiselect v-model="docform.selected_doctype" :multiple="false" :options="doctypes.map(prac => prac.id)" :custom-label="opt => doctypes.find(x => x.id == opt).type" placeholder="Select Doc Type">
                                        <template slot="selection" slot-scope="{ values, search, isOpen }"><span class="multiselect__single" v-if="values.length >3 &amp;&amp; !isOpen">{{ values.length }} types selected</span></template>
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
                                        <input v-model="docform.issue_date" type="date" name="issue_date"
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('issue_date') }">
                                        <has-error :form="form" field="issue_date"></has-error>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group input-group input-group-sm">
                                        <span class="input-group input-group-sm">Expiry Date</span>
                                        <input v-model="docform.expiry_date" type="date" name="expiry_date"
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
            <profile :listdata="profiledata"/>
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode">Add New Practice</h5>
                    <h5 class="modal-title" v-show="editmode">Edit Practice</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>



                <form @submit.prevent="editmode ? updatePractice() : createPractice()">
                    <div class="modal-body">

<div class="row">
    <div class="col-sm-6">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">Practice Name</span>
            <input v-model="form.practice_name" type="text" name="practice_name"
                class="form-control" :class="{ 'is-invalid': form.errors.has('practice_name') }">
            <has-error :form="form" field="practice_name"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">Practice Code</span>
            <input v-model="form.practice_code" type="text" name="practice_code"
                class="form-control" :class="{ 'is-invalid': form.errors.has('practice_code') }">
            <has-error :form="form" field="practice_code"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">Client Name</span>
            <input v-model="form.client_name" type="text" name="client_name"
                class="form-control" :class="{ 'is-invalid': form.errors.has('client_name') }">
            <has-error :form="form" field="client_name"></has-error>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">Group NPI</span>
            <input v-model="form.group_npi" type="text" name="group_npi"
                class="form-control" :class="{ 'is-invalid': form.errors.has('group_npi') }">
            <has-error :form="form" field="group_npi"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">Practice Tax ID</span>
            <input v-model="form.practice_tax_id" type="text" name="practice_tax_id"
                class="form-control" :class="{ 'is-invalid': form.errors.has('practice_tax_id') }">
            <has-error :form="form" field="practice_tax_id"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">Speciality</span>
            <input v-model="form.speciality" type="text" name="speciality"
                class="form-control" :class="{ 'is-invalid': form.errors.has('speciality') }">
            <has-error :form="form" field="speciality"></has-error>
        </div>
    </div>
    
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">Taxnomy</span>
            <input v-model="form.taxnomy" type="text" name="taxnomy"
                class="form-control" :class="{ 'is-invalid': form.errors.has('taxnomy') }">
            <has-error :form="form" field="taxnomy"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">CLIA</span>
            <input v-model="form.clia" type="text" name="clia"
                class="form-control" :class="{ 'is-invalid': form.errors.has('clia') }">
            <has-error :form="form" field="clia"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">CLIA Expiry</span>
            <input v-model="form.clia_expiry" type="date" name="clia_expiry"
                class="form-control" :class="{ 'is-invalid': form.errors.has('clia_expiry') }">
            <has-error :form="form" field="clia_expiry"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">DBA Name</span>
            <input v-model="form.dba_name" type="text" name="dba_name"
                class="form-control" :class="{ 'is-invalid': form.errors.has('dba_name') }">
            <has-error :form="form" field="dba_name"></has-error>
        </div>
    </div>
    
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">Practice Classification</span>
            <select v-model="form.prac_classification" name="prac_classification"  class="form-control">
                <option value="Sole Proproiter">Sole Proproiter</option>
                <option value="S.Corp">S.Corp</option>
                <option value="C.Corp">C.Corp</option>
                <option value="Partnership">Partnership</option>
            </select>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">Grp Medicaid ID</span>
            <input v-model="form.grp_madicaid_id" type="text" name="grp_madicaid_id"
                class="form-control" :class="{ 'is-invalid': form.errors.has('grp_madicaid_id') }">
            <has-error :form="form" field="grp_madicaid_id"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">Group MRC ID</span>
            <input v-model="form.grp_mrc_id" type="text" name="grp_mrc_id"
                class="form-control" :class="{ 'is-invalid': form.errors.has('grp_mrc_id') }">
            <has-error :form="form" field="grp_mrc_id"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">Rail Road group</span>
            <input v-model="form.rail_road_group" type="text" name="rail_road_group"
                class="form-control" :class="{ 'is-invalid': form.errors.has('rail_road_group') }">
            <has-error :form="form" field="rail_road_group"></has-error>
        </div>
    </div>
    
</div>

<div class="row addr_panel">
    <div class="col-sm-4">
        <div class="form-group input-group input-group-sm">
            <label class="input-group input-group-sm">Service Address</label>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="form-group input-group input-group-sm">
            <input v-model="form.service_address" type="text" name="service_address"
                class="form-control" :class="{ 'is-invalid': form.errors.has('service_address') }">
            <has-error :form="form" field="service_address"></has-error>
        </div>
    </div>

    <div class="col-sm-2">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">City</span>
            <input v-model="form.service_city" type="text" name="service_city"
                class="form-control" :class="{ 'is-invalid': form.errors.has('service_city') }">
            <has-error :form="form" field="service_city"></has-error>
        </div>
    </div>
    <div class="col-sm-2">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">State</span>
            <input v-model="form.service_state" type="text" name="service_state"
                class="form-control" :class="{ 'is-invalid': form.errors.has('service_state') }">
            <has-error :form="form" field="service_state"></has-error>
        </div>
    </div>
    <div class="col-sm-2">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">Zip</span>
            <input v-model="form.service_zip" type="text" name="service_zip"
                class="form-control" :class="{ 'is-invalid': form.errors.has('service_zip') }">
            <has-error :form="form" field="service_zip"></has-error>
        </div>
    </div>
    <div class="col-sm-2">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">Fax</span>
            <input v-model="form.service_fax" type="text" name="service_fax"
                class="form-control" :class="{ 'is-invalid': form.errors.has('service_fax') }">
            <has-error :form="form" field="service_fax"></has-error>
        </div>
    </div>
    <div class="col-sm-2">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">Phone</span>
            <input v-model="form.service_phone" type="text" name="service_phone"
                class="form-control" :class="{ 'is-invalid': form.errors.has('service_phone') }">
            <has-error :form="form" field="service_phone"></has-error>
        </div>
    </div>
    <div class="col-sm-2">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">County</span>
            <input v-model="form.service_county" type="text" name="service_county"
                class="form-control" :class="{ 'is-invalid': form.errors.has('service_county') }">
            <has-error :form="form" field="service_county"></has-error>
        </div>
    </div>
</div>
<div class="row addr_panel">
    <div class="col-sm-4">
        <div class="form-group input-group input-group-sm">
            <label class="input-group input-group-sm">Pay Address</label>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="form-group input-group input-group-sm">
            <input v-model="form.pay_address" type="text" name="pay_address"
                class="form-control" :class="{ 'is-invalid': form.errors.has('pay_address') }">
            <has-error :form="form" field="pay_address"></has-error>
        </div>
    </div>
    

    <div class="col-sm-2">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">City</span>
            <input v-model="form.pay_city" type="text" name="pay_city"
                class="form-control" :class="{ 'is-invalid': form.errors.has('pay_city') }">
            <has-error :form="form" field="pay_city"></has-error>
        </div>
    </div>
    <div class="col-sm-2">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">State</span>
            <input v-model="form.pay_state" type="text" name="pay_state"
                class="form-control" :class="{ 'is-invalid': form.errors.has('pay_state') }">
            <has-error :form="form" field="pay_state"></has-error>
        </div>
    </div>
    <div class="col-sm-2">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">Zip</span>
            <input v-model="form.pay_zip" type="text" name="pay_zip"
                class="form-control" :class="{ 'is-invalid': form.errors.has('pay_zip') }">
            <has-error :form="form" field="pay_zip"></has-error>
        </div>
    </div>
    <div class="col-sm-2">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">Fax</span>
            <input v-model="form.pay_fax" type="text" name="pay_fax"
                class="form-control" :class="{ 'is-invalid': form.errors.has('pay_fax') }">
            <has-error :form="form" field="pay_fax"></has-error>
        </div>
    </div>
    <div class="col-sm-2">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">Phone</span>
            <input v-model="form.pay_phone" type="text" name="pay_phone"
                class="form-control" :class="{ 'is-invalid': form.errors.has('pay_phone') }">
            <has-error :form="form" field="pay_phone"></has-error>
        </div>
    </div>
    <div class="col-sm-2">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">County</span>
            <input v-model="form.pay_county" type="text" name="pay_county"
                class="form-control" :class="{ 'is-invalid': form.errors.has('pay_county') }">
            <has-error :form="form" field="pay_county"></has-error>
        </div>
    </div>
    
</div>
<div class="row">
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">Manager Name</span>
            <input v-model="form.contact1_name" type="text" name="contact1_name"
                class="form-control" :class="{ 'is-invalid': form.errors.has('contact1_name') }">
            <has-error :form="form" field="contact1_name"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">Email</span>
            <input v-model="form.contact1_email" type="text" name="contact1_email"
                class="form-control" :class="{ 'is-invalid': form.errors.has('contact1_email') }">
            <has-error :form="form" field="contact1_email"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">Phone</span>
            <input v-model="form.contact1_phone" type="text" name="contact1_phone"
                class="form-control" :class="{ 'is-invalid': form.errors.has('contact1_phone') }">
            <has-error :form="form" field="contact1_phone"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">Mobile</span>
            <input v-model="form.contact1_mobile" type="text" name="contact1_mobile"
                class="form-control" :class="{ 'is-invalid': form.errors.has('contact1_mobile') }">
            <has-error :form="form" field="contact1_mobile"></has-error>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">Owner Name</span>
            <input v-model="form.owner_name" type="text" name="owner_name"
                class="form-control" :class="{ 'is-invalid': form.errors.has('owner_name') }">
            <has-error :form="form" field="owner_name"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">Email</span>
            <input v-model="form.owner_email" type="text" name="owner_email"
                class="form-control" :class="{ 'is-invalid': form.errors.has('owner_email') }">
            <has-error :form="form" field="owner_email"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">Phone</span>
            <input v-model="form.owner_phone" type="text" name="owner_phone"
                class="form-control" :class="{ 'is-invalid': form.errors.has('owner_phone') }">
            <has-error :form="form" field="owner_phone"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">Mobile</span>
            <input v-model="form.owner_mobile" type="text" name="owner_mobile"
                class="form-control" :class="{ 'is-invalid': form.errors.has('owner_mobile') }">
            <has-error :form="form" field="owner_mobile"></has-error>
        </div>
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
    import { VueGoodTable } from 'vue-good-table';
    import Multiselect from 'vue-multiselect'
    import profile from "../../components/practice/Profile";
    export default {
      components: {
          VueGoodTable,profile,Multiselect
        },
        data () {
            return {
                columns: [
                            {
                              label: 'No',
                              field: 'id',
                            },
                            {
                              label: 'Practice Name',
                              field: 'practice_name',
                            },
                            {
                              label: 'Client Name',
                              field: 'client_name',
                            },
                            {
                              label: 'Group NPI',
                              field: 'group_npi',
                            },
                            {
                              label: 'Tax ID',
                              field: 'practice_tax_id',
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
                editmode: false,
                practices : {},
                doctypes: [],
                errors: {},
                docform: new Form({
                    id : '',
                    file_name : '',
                    selected_practice: [],
                    selected_doctype: [],
                    issue_date:'',
                    expiry_date:'',
                }),
                form: new Form({
                    id : '',
                    practice_name : '',
                    practice_code: '',
                    client_name: '',
                    group_npi: '',
                    practice_tax_id: '',
                    speciality: '',
                    taxnomy: '',
                    clia: '',
                    clia_expiry: '',
                    dba_name:'',
                    prac_classification:'',
                    grp_madicaid_id : '',
                    grp_mrc_id : '',
                    rail_road_group : '',
                    service_address: '',
                    service_city: '',
                    service_state: '',
                    service_fax: '',
                    service_zip: '',
                    service_phone: '',
                    service_county: '',
                    pay_address: '',
                    pay_city: '',
                    pay_state: '',
                    pay_fax: '',
                    pay_zip: '',
                    pay_phone: '',
                    pay_county: '',
                    contact1_name: '',
                    contact1_email: '',
                    contact1_phone: '',
                    contact1_mobile: '',
                    owner_name: '',
                }),
                profiledata:'',
                autocompleteItems: [],
            }
        },
        methods: {
            onChange(e){
            console.log("slected file",e.target.files[0]);
              this.docform.file_name = e.target.files[0];
          },
          profileModal(row){
              $('#infoNew').modal('show');
              this.getProProfile(row);
            },
            getProProfile(row){
            this.profiledata=row;
            },
          docModal(row){
              this.editmode = false;
              this.docform.reset();
              this.docform.selected_practice=row.id;
              $('#docNew').modal('show');
              
          },
          loadPractices(){
                axios.get('api/practice').then(function (res) {
                    this.rows = res.data.data;
                }.bind(this));

            // if(this.$gate.isAdmin()){
            //  axios.get("api/practice").then(({ data }) => (this.practices = data.data));
            // }
          },
          loadDocTypes: function () {
            axios.get('api/document/doctypes').then(function (res) {
            
                this.doctypes = res.data.data;
            }.bind(this));
            },
          
          editModal(practice){
              this.editmode = true;
              this.form.reset();
              $('#addNew').modal('show');
              this.form.fill(practice);
          },
          newModal(){
              this.editmode = false;
              this.form.reset();
              $('#addNew').modal('show');
          },
          createDocument(){
              this.errors = {};
              this.$Progress.start();
              let fb = new FormData();
              fb.append('file_name',this.docform.file_name);
              fb.append('practice_id',this.docform.selected_practice);
              fb.append('document_type_id',this.docform.selected_doctype);
              fb.append('issue_date',this.docform.issue_date);
              fb.append('expiry_date',this.docform.expiry_date);
              axios.post('api/practicedoc',fb)
              
              .then((data)=>{
                if(data.data.success){
                  $('#docNew').modal('hide');

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
          createPractice(){
              this.$Progress.start();

              this.form.post('api/practice')
              .then((data)=>{
                if(data.data.success){
                  $('#addNew').modal('hide');

                  Toast.fire({
                        icon: 'success',
                        title: data.data.message
                    });
                  this.$Progress.finish();
                  this.loadPractices();

                } else {
                  Toast.fire({
                      icon: 'error',
                      title: 'Some error occured! Please try again'
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
          updatePractice(){
              this.$Progress.start();
              this.form.put('api/practice/'+this.form.id)
              .then((response) => {
                  // success
                  $('#addNew').modal('hide');
                  Toast.fire({
                    icon: 'success',
                    title: response.data.message
                  });
                  this.$Progress.finish();
                      //  Fire.$emit('AfterCreate');

                  this.loadPractices();
              })
              .catch(() => {
                  this.$Progress.fail();
              });

          },
          deletePractice(id){
              Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  showCancelButton: true,
                  confirmButtonColor: '#d33',
                  cancelButtonColor: '#3085d6',
                  confirmButtonText: 'Yes, delete it!'
                  }).then((result) => {

                      // Send request to the server
                        if (result.value) {
                              this.form.delete('api/practice/'+id).then(()=>{
                                      Swal.fire(
                                      'Deleted!',
                                      'Your file has been deleted.',
                                      'success'
                                      );
                                  // Fire.$emit('AfterCreate');
                                  this.loadPractices();
                              }).catch((data)=> {
                                  Swal.fire("Failed!", data.message, "warning");
                              });
                        }
                  })
          },

        },
        mounted() {
            
        },
        created() {
            this.$Progress.start();

            this.loadPractices();
            this.loadDocTypes();
            this.$Progress.finish();
        },
        filters: {
            truncate: function (text, length, suffix) {
                return text.substring(0, length) + suffix;
            },
        },
        computed: {
          filteredItems() {
            return this.autocompleteItems.filter(i => {
              return i.text.toLowerCase().indexOf(this.tag.toLowerCase()) !== -1;
            });
          },
        },
    }
</script>
