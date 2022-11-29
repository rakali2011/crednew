<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">

          <div class="col-12">
        
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">All Providers</h3>

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
                  :fixed-header="true"
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
                      
                      <a href="#" @click="deleteProduct(props.row.id)">
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
                                        <input type="file" @change="onChange" multiple="multiple" ref="inputFile" name="file_name[]" class="">
                                        <span v-if="errors && errors.file_name" class=" text-danger">&nbsp;&nbsp; Document is reqiured</span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group input-group input-group-sm">
                                        <span class="input-group input-group-sm">Issue Date</span>
                                        <datepicker placeholder="Select Date" v-model="docform.issue_date" :format="customFormatter" input-class ="my-picker-class" name="issue_date" 
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('issue_date') }" >
                                        </datepicker>
                                        <has-error :form="form" field="issue_date"></has-error>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group input-group input-group-sm">
                                        <span class="input-group input-group-sm">Expiry Date</span>
                                        <datepicker placeholder="Select Date" v-model="docform.expiry_date" :format="customFormatter" input-class ="my-picker-class" name="expiry_date" 
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('expiry_date') }" >
                                        </datepicker>
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
        <profile @clicked="onClickChild" :listdata="profiledata"/>
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNew" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editmode">Add New Provider</h5>
                        <h5 class="modal-title" v-show="editmode">Edit Provider</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>


                    <div class="modal-body">
                        <form @submit.prevent="editmode ? updateProvider() : createProvider()">
<div class="row">
    <div class="col-sm-12">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">Assign Practice</span>
            <multiselect v-model="form.selected_practices" :multiple="true" :options="practices.map(prac => prac.id)" :custom-label="opt => practices.find(x => x.id == opt).practice_name" placeholder="Assign Practice">
            <template slot="selection" slot-scope="{ values, search, isOpen }"><span class="multiselect__single" v-if="values.length >3 &amp;&amp; !isOpen">{{ values.length }} practices selected</span></template>
            </multiselect>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">Individual NPI</span>
            <masked-input v-model="form.individual_npi" mask="1111111111" name="individual_npi" class="form-control" :class="{ 'is-invalid': form.errors.has('individual_npi') }" />
            <!-- <input v-model="form.individual_npi" type="text" name="individual_npi"
                class="form-control" :class="{ 'is-invalid': form.errors.has('individual_npi') }"> -->
            <has-error :form="form" field="individual_npi"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">Full Name</span>
            <input v-model="form.full_name" type="text" name="full_name"
                class="form-control" :class="{ 'is-invalid': form.errors.has('full_name') }">
            <has-error :form="form" field="full_name"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">Tax ID</span>
            <masked-input v-model="form.tax_id" mask="111111111" name="tax_id" class="form-control" :class="{ 'is-invalid': form.errors.has('tax_id') }" />
            <!-- <input v-model="form.tax_id" type="text" name="tax_id"
                class="form-control" :class="{ 'is-invalid': form.errors.has('tax_id') }"> -->
            <has-error :form="form" field="tax_id"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">SSN</span>
            <masked-input v-model="form.ssn" mask="111111111" name="ssn" class="form-control" :class="{ 'is-invalid': form.errors.has('ssn') }" />
            <!-- <input v-model="form.ssn" type="text" name="ssn"
                class="form-control" :class="{ 'is-invalid': form.errors.has('ssn') }"> -->
            <has-error :form="form" field="ssn"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">Specialty</span>
            <input v-model="form.speciality" type="text" name="speciality"
                class="form-control" :class="{ 'is-invalid': form.errors.has('speciality') }">
            <has-error :form="form" field="speciality"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">Taxonomy</span>
            <input v-model="form.taxonomy" type="text" name="taxonomy"
                class="form-control" :class="{ 'is-invalid': form.errors.has('taxonomy') }">
            <has-error :form="form" field="taxonomy"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">DOB</span>
            <datepicker placeholder="Select Date" v-model="form.dob" :format="customFormatter" input-class ="my-picker-class" name="dob" 
            class="form-control" :class="{ 'is-invalid': form.errors.has('dob') }" >
            </datepicker>
            <!-- <input v-model="form.dob" type="date" name="dob"
                class="form-control" :class="{ 'is-invalid': form.errors.has('dob') }"> -->
            <has-error :form="form" field="dob"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">Ph/Cell</span>
            <masked-input v-model="form.cell" mask="\+\1 (111) 111-1111" name="cell" class="form-control" :class="{ 'is-invalid': form.errors.has('cell') }" />
            <!-- <input v-model="form.cell" type="text" name="cell"
                class="form-control" :class="{ 'is-invalid': form.errors.has('cell') }"> -->
            <has-error :form="form" field="cell"></has-error>
        </div>
    </div>
</div>
<div class="row addr_panel">
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">Home Street</span>
            <input v-model="form.home_street" type="text" name="home_street"
                class="form-control" :class="{ 'is-invalid': form.errors.has('home_street') }">
            <has-error :form="form" field="home_street"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">City</span>
            <input v-model="form.home_city" type="text" name="home_city"
                class="form-control" :class="{ 'is-invalid': form.errors.has('home_city') }">
            <has-error :form="form" field="home_city"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">State</span>
            <input v-model="form.home_state" type="text" name="home_state"
                class="form-control" :class="{ 'is-invalid': form.errors.has('home_state') }">
            <has-error :form="form" field="home_state"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">Zip</span>
            <masked-input v-model="form.home_zip" mask="11111" name="home_zip" class="form-control" :class="{ 'is-invalid': form.errors.has('home_zip') }" />
            <!-- <input v-model="form.home_zip" type="text" name="home_zip"
                class="form-control" :class="{ 'is-invalid': form.errors.has('home_zip') }"> -->
            <has-error :form="form" field="home_zip"></has-error>
        </div>
    </div>
    
    
    
    
</div>
<div class="row">
    
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">Gender</span>
            <input v-model="form.gender" type="text" name="gender"
                class="form-control" :class="{ 'is-invalid': form.errors.has('gender') }">
            <has-error :form="form" field="gender"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">Provider Email</span>
            <input v-model="form.email" type="text" name="email"
                class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
            <has-error :form="form" field="email"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">Ind Medicare ID</span>
            <input v-model="form.medicare_id" type="text" name="medicare_id"
                class="form-control" :class="{ 'is-invalid': form.errors.has('medicare_id') }">
            <has-error :form="form" field="medicare_id"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">Ind Medicad ID</span>
            <input v-model="form.medicaid_id" type="text" name="medicaid_id"
                class="form-control" :class="{ 'is-invalid': form.errors.has('medicaid_id') }">
            <has-error :form="form" field="medicaid_id"></has-error>
        </div>
    </div>
    
    
    <!-- <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">Medicaid User</span>
            <input v-model="form.medicaid_user" type="text" name="medicaid_user"
                class="form-control" :class="{ 'is-invalid': form.errors.has('medicaid_user') }">
            <has-error :form="form" field="medicaid_user"></has-error>
        </div>
    </div> -->
    
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">Individual PTAN</span>
            <input v-model="form.ptan" type="text" name="ptan"
                class="form-control" :class="{ 'is-invalid': form.errors.has('ptan') }">
            <has-error :form="form" field="ptan"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">Office Mgr Name</span>
            <input v-model="form.manager_name" type="text" name="manager_name"
                class="form-control" :class="{ 'is-invalid': form.errors.has('manager_name') }">
            <has-error :form="form" field="manager_name"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">Office Mgr Email</span>
            <input v-model="form.manager_email" type="text" name="manager_email"
                class="form-control" :class="{ 'is-invalid': form.errors.has('manager_email') }">
            <has-error :form="form" field="manager_email"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">Office Mgr Contact#</span>
            <input v-model="form.manager_contact" type="text" name="manager_contact"
                class="form-control" :class="{ 'is-invalid': form.errors.has('manager_contact') }">
            <has-error :form="form" field="manager_contact"></has-error>
        </div>
    </div>
</div>
<!--CAQH Web portal -->
<div class="row addr_panel">
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">CAQH User</span>
            <input v-model="form.caqh_user" type="text" name="caqh_user"
                class="form-control" :class="{ 'is-invalid': form.errors.has('caqh_user') }">
            <has-error :form="form" field="caqh_user"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">CAQH Pass</span>
            <input v-model="form.caqh_pass" type="text" name="caqh_pass"
                class="form-control" :class="{ 'is-invalid': form.errors.has('caqh_pass') }">
            <has-error :form="form" field="caqh_pass"></has-error>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">CAQH ID</span>
            <input v-model="form.caqh_id" type="text" name="caqh_id"
                class="form-control" :class="{ 'is-invalid': form.errors.has('caqh_id') }">
            <has-error :form="form" field="caqh_id"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">PECOS User</span>
            <input v-model="form.pecos_user" type="text" name="pecos_user"
                class="form-control" :class="{ 'is-invalid': form.errors.has('pecos_user') }">
            <has-error :form="form" field="pecos_user"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">PECOS Pass</span>
            <input v-model="form.pecos_pass" type="text" name="pecos_pass"
                class="form-control" :class="{ 'is-invalid': form.errors.has('pecos_pass') }">
            <has-error :form="form" field="pecos_pass"></has-error>
        </div>
    </div>
</div>
<!--CAQH Web portal ends-->
<!--Web portal starts-->
    <div class="row">
        <div class="col-sm-3">
            <button type="button" v-on:click="addNewLogin" class="btn btn-sm btn-success">
                Add Web Portals
            </button>
        </div>
        <div class="col-sm-9">
            You can add multiple web portals.
        </div>
    </div>
    <div class="row">&nbsp;</div>
    <div v-for="(login, index) in logins">
        <div class="row webportal_panel">
            <div class="col-sm-2">
                <div class="form-group input-group input-group-sm">
                <span class="input-group input-group-sm">&nbsp;</span>
                <button type="button" v-on:click="removeLogin(index)" class="btn btn-sm btn-danger">
                    Remove
                </button>
                </div>
            </div>
            <div class="form-group col-sm-4">
                <div class="form-group input-group input-group-sm">
                    <span class="input-group input-group-sm">Web Portal Name</span>
                        <input v-model="login.loginweb" type="text" name="logins[][loginweb]"
                        class="form-control">            
                </div>
            </div>
            <div class="form-group col-sm-3">
                <div class="form-group input-group input-group-sm">
                    <span class="input-group input-group-sm">User Name</span>
                        <input v-model="login.loginuser" type="text"
                        name="logins[][loginuser]" class="form-control">
                </div>
            </div>
            <div class="form-group col-sm-3">
                <div class="form-group input-group input-group-sm">
                    <span class="input-group input-group-sm">Password</span>
                        <input v-model="login.loginpass" type="text"
                        name="logins[][loginpass]" class="form-control">
                </div>
            </div>
            <div class="form-group col-sm-12">
                <div class="form-group input-group input-group-sm">
                    <span class="input-group input-group-sm">Security Question/Notes</span>
                        <input v-model="login.additional_information" type="text"
                        name="logins[][additional_information]" class="form-control">
                </div>
            </div>
            
        </div>
    </div>
<div class="row">
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">DEA</span>
            <input v-model="form.dea" type="checkbox" name="dea"
                class="" :class="{ 'is-invalid': form.errors.has('dea') }">
            <has-error :form="form" field="dea"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">DEA Certification #</span>
            <input v-model="form.dea_certification_number" type="text" name="dea_certification_number"
                class="form-control" :class="{ 'is-invalid': form.errors.has('dea_certification_number') }">
            <has-error :form="form" field="dea_certification_number"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">DEA Effective</span>
            <datepicker placeholder="Select Date" v-model="form.dea_effective_date" :format="customFormatter" name="dea_effective_date" input-class ="my-picker-class" 
            class="form-control" :class="{ 'is-invalid': form.errors.has('dea_effective_date') }" >
            </datepicker>
            <!-- <input v-model="form.dea_effective_date" type="date" name="dea_effective_date"
                class="form-control" :class="{ 'is-invalid': form.errors.has('dea_effective_date') }"> -->
            <has-error :form="form" field="dea_effective_date"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">DEA Expiry</span>
            <datepicker placeholder="Select Date" v-model="form.dea_expiry_date" :format="customFormatter" name="dea_expiry_date" input-class ="my-picker-class" 
            class="form-control" :class="{ 'is-invalid': form.errors.has('dea_expiry_date') }" >
            </datepicker>
            <!-- <input v-model="form.dea_expiry_date" type="date" name="dea_expiry_date"
                class="form-control" :class="{ 'is-invalid': form.errors.has('dea_expiry_date') }"> -->
            <has-error :form="form" field="dea_expiry_date"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">CDS License</span>
            <input v-model="form.cds_license_option" type="checkbox" name="cds_license_option"
                class="" :class="{ 'is-invalid': form.errors.has('cds_license_option') }">
            <has-error :form="form" field="cds_license_option"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">CDS License #</span>
            <input v-model="form.cds_license_number" type="text" name="cds_license_number"
                class="form-control" :class="{ 'is-invalid': form.errors.has('cds_license_number') }">
            <has-error :form="form" field="cds_license_number"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">CDS Effective</span>
            <datepicker placeholder="Select Date" v-model="form.cds_effective_date" :format="customFormatter" name="cds_effective_date" input-class ="my-picker-class" 
            class="form-control" :class="{ 'is-invalid': form.errors.has('cds_effective_date') }" >
            </datepicker>
            <!-- <input v-model="form.cds_effective_date" type="date" name="cds_effective_date"
                class="form-control" :class="{ 'is-invalid': form.errors.has('cds_effective_date') }"> -->
            <has-error :form="form" field="cds_effective_date"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">CDS Expiry</span>
            <datepicker placeholder="Select Date" v-model="form.cds_expiry_date" :format="customFormatter" name="cds_expiry_date" input-class ="my-picker-class" 
            class="form-control" :class="{ 'is-invalid': form.errors.has('cds_expiry_date') }" >
            </datepicker>
            <!-- <input v-model="form.cds_expiry_date" type="date" name="cds_expiry_date"
                class="form-control" :class="{ 'is-invalid': form.errors.has('cds_expiry_date') }"> -->
            <has-error :form="form" field="cds_expiry_date"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">State License</span>
            <input v-model="form.state_license_option" type="checkbox" name="state_license_option"
                class="" :class="{ 'is-invalid': form.errors.has('state_license_option') }">
            <has-error :form="form" field="state_license_option"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">State License#</span>
            <input v-model="form.state_license_number" type="text" name="state_license_number"
                class="form-control" :class="{ 'is-invalid': form.errors.has('state_license_number') }">
            <has-error :form="form" field="state_license_number"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">License Effective</span>
            <datepicker placeholder="Select Date" v-model="form.state_license_date" :format="customFormatter" name="state_license_date" input-class ="my-picker-class" 
            class="form-control" :class="{ 'is-invalid': form.errors.has('state_license_date') }" >
            </datepicker>
            <!-- <input v-model="form.state_license_date" type="date" name="state_license_date"
                class="form-control" :class="{ 'is-invalid': form.errors.has('state_license_date') }"> -->
            <has-error :form="form" field="state_license_date"></has-error>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group input-group input-group-sm">
            <span class="input-group input-group-sm">License Expiry</span>
            <datepicker placeholder="Select Date" v-model="form.state_license_expiry" :format="customFormatter" name="state_license_expiry" input-class ="my-picker-class" 
            class="form-control" :class="{ 'is-invalid': form.errors.has('state_license_expiry') }" >
            </datepicker>
            <!-- <input v-model="form.state_license_expiry" type="date" name="state_license_expiry"
                class="form-control" :class="{ 'is-invalid': form.errors.has('state_license_expiry') }"> -->
            <has-error :form="form" field="state_license_expiry"></has-error>
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

<!--Remarks model-->
<div class="modal fade" id="remarksDetail" tabindex="-1" role="dialog" aria-labelledby="remarksDetail" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" >Remarks</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        
                            <div class="form-group">
                                <table width="100%">
                                    <thead>
                                        <tr>
                                          <th>Date</th>
                                          <th>User</th>
                                          <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <tr v-for='(remark, index) in remarksData'>
                                        <td>{{ remark.created_at | myDate }}</td>
                                        <td>{{ remark.user.name }}</td>
                                        <td contenteditable="true" @blur="updateRemarks($event,remark.id)">{{ remark.remarks }}</td>
                                      </tr>
                                    </tbody>
                                </table>
                            </div>
                    </div>
                </div>
            </div>
</div>
  </section>
</template>
<style>
        .my-picker-class{
            border: none !important;
            width: 100%;
           }
    </style>
<script>
import { VueGoodTable } from 'vue-good-table';

import Multiselect from 'vue-multiselect'
import profile from "../../components/provider/Profile";
import MaskedInput from 'vue-masked-input';
import Datepicker from 'vuejs-datepicker';
import moment from 'moment';
    export default {
        components: { VueGoodTable,profile,Multiselect,MaskedInput,Datepicker },
        data () {
            return {


        login: {
                    loginweb: '',
                    loginuser: '',
                    loginpass: '',
                    additional_information: '',
                },
                logins: [],
      columns: [
        {
          label: 'NPI',
          field: 'individual_npi',
        },
        {
          label: 'Full Name',
          field: 'full_name',
        },
        {
          label: 'Email',
          field: 'email',
        },
        {
          label: 'Status',
          field: 'status',
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
      remarksData:[],
      doctypes: [],
                editmode: false,
                errors: {},
                remarksform: new Form({
                    remarks:'',
                }),
                docform: new Form({
                    id : '',
                    file_name : [],
                    selected_provider: [],
                    selected_doctype: [],
                    issue_date:'',
                    expiry_date:'',
                }),
                form: new Form({
                    selected_practices: [],
                    id : '',
                    individual_npi : '',
                    full_name : '',
                    tax_id : '',
                    ssn : '',
                    speciality : '',
                    dob : '',
                    provider_signup_date : '',
                    taxonomy : '',
                    taxonomy2 : '',
                    home_street : '',
                    home_suite : '',
                    home_city : '',
                    home_state : '',
                    home_county : '',
                    home_zip : '',
                    mailing_street : '',
                    mailing_suite : '',
                    mailing_city : '',
                    mailing_state : '',
                    mailing_county : '',
                    mailing_zip : '',
                    cell : '',
                    gender : '',
                    birth_county : '',
                    birth_state : '',
                    email : '',
                    dob : '',
                    password : '',
                    ptan : '',
                    caqh_user : '',
                    caqh_pass : '',
                    caqh_id : '',
                    pecos_user : '',
                    pecos_pass : '',
                    manager_name : '',
                    manager_email : '',
                    manager_contact : '',
                    medicaid_id : '',
                    medicaid_user : '',
                    medicare_id : '',
                    website : '',
                    dea : '',
                    dea_certification_number : '',
                    dea_effective_date : '',
                    dea_expiry_date : '',
                    state_license : '',
                    cds_license_option : '',
                    cds_license_number : '',
                    cds_effective_date : '',
                    cds_expiry_date : '',
                    hospital_affiliation : '',
                    hospital_name : '',
                    hospital_effective_date : '',
                    hospital_expiry_date : '',
                    state_license_option : '',
                    state_license_number : '',
                    state_license_date : '',
                    state_license_expiry : '',
                    status : '',
                    practice_id: '',
                }),
                componentKey: 0,
                profiledata:'',
    }
        },
        methods: {
            updateRemarks(e,id){
                this.$Progress.start();
              this.remarksform.remarks = e.target.innerHTML;
              this.remarksform.put('api/remarks/'+id)
              .then((response) => {
                  // success
                  $('#addNew').modal('hide');
                  Toast.fire({
                    icon: 'success',
                    title: response.data.message
                  });
                  this.$Progress.finish();
                      //  Fire.$emit('AfterCreate');
                //   this.loadProviders();
              })
              .catch(() => {
                  this.$Progress.fail();
              });

        },
            customFormatter(date) {
                return moment(date).format('MMMM Do YYYY');
            },
            addNewLogin: function () {
                this.logins.push(Vue.util.extend({}, this.login))
            },
            removeLogin: function (index) {
                Vue.delete(this.logins, index);
            },
            onChange(e){
                this.docform.file_name =[];
                let files = e.target.files;
                for(var a=0; a<e.target.files.length;a++){

                    this.docform.file_name.push(files[a]);
                }
            // console.log("slected file",e.target.files[0]);
            //   this.docform.file_name = e.target.files[0];
          },
            onClickChild (value) {
                // console.log(value) // someValue
                this.remarksData = value;
              },
            profileModal(row){
              $('#infoNew').modal('show');
              this.getProProfile(row);
            },
            getProProfile(row){
            this.profiledata=row;
            },
            editModal(row){
              this.editmode = true;
              this.form.reset();
              this.logins = [];
              $('#addNew').modal('show');
              this.form.fill(row);
              this.logins=row["logins"];
              this.form.selected_practices=row.practices.map(prac=>prac.id);
          },
            docModal(row){
              this.editmode = false;
              this.docform.reset();
              this.docform.selected_provider=row.id;
              this.$refs.inputFile.value = '';
              $('#docNew').modal('show');
              
          },
            newModal(){
              this.editmode = false;
              this.form.reset();
              this.logins = [];
              $('#addNew').modal('show');
          },
            forceRerender() {
                this.componentKey += 1;
              },
              createDocument(){
              this.errors = {};
              this.$Progress.start();
              let fb = new FormData();
              for (var i = 0; i < this.docform.file_name.length; i++) {
                fb.append('file_name[]', this.docform.file_name[i]);
              }
              fb.append('provider_id',this.docform.selected_provider);
              fb.append('document_type_id',this.docform.selected_doctype);
              fb.append('issue_date',moment(this.docform.issue_date).format('YYYY-MM-DD'));
              fb.append('expiry_date',moment(this.docform.expiry_date).format('YYYY-MM-DD'));
              axios.post('api/document',fb)
              
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
            createProvider(){
              this.$Progress.start();
              this.form.web_portals = this.logins;
              this.form.post('api/provider')
              .then((data)=>{
                if(data.data.success){
                  $('#addNew').modal('hide');

                  Toast.fire({
                        icon: 'success',
                        title: data.message
                    });
                    
                  this.$Progress.finish();
                  this.loadProviders();
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
                      title: 'Some error occured! Please try again!'
                  });
              })
          },
          updateProvider(){
              this.$Progress.start();
              this.form.web_portals = this.logins;
              this.form.put('api/provider/'+this.form.id)
              .then((response) => {
                  // success
                  $('#addNew').modal('hide');
                  Toast.fire({
                    icon: 'success',
                    title: response.data.message
                  });
                  this.$Progress.finish();
                      //  Fire.$emit('AfterCreate');
                  this.loadProviders();
              })
              .catch(() => {
                  this.$Progress.fail();
              });

          },
          deleteProduct(id){
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
                              this.form.delete('api/provider/'+id).then(()=>{
                                      Swal.fire(
                                      'Deleted!',
                                      'Your provider has been deleted.',
                                      'success'
                                      );
                                  // Fire.$emit('AfterCreate');
                                  this.loadProviders();
                              }).catch((data)=> {
                                  Swal.fire("Failed!", data.message, "warning");
                              });
                        }
                  })
          },
          loadProviders: function () {
                axios.get('api/provider').then(function (res) {
                    console.log(res);
                    this.rows = res.data.data;
                }.bind(this));
            },
          loadPractices: function () {
                axios.get('api/practice/listing').then(function (res) {
                console.log(res.data.data);
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
           this.loadProviders();
           this.loadPractices();
           this.loadDocTypes();
        }
    }
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css">
