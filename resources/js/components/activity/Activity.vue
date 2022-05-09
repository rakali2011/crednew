<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">

          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Log Daily Activity</h3>
                

              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <div class="modal-body">
                        <form @submit.prevent="createActivity()">
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
                                            <span v-if="errors && errors.provider_id" class=" text-danger">&nbsp;&nbsp; {{ errors.provider_id[0] }}</span>
                                        </span>
                                        <select class="form-control" v-model="form.provider_id" @change="onChangeProvider($event)">
                                            <option :value="provider.id" v-for="(provider) in providers" :key="provider.id">{{provider.full_name}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">&nbsp;</div>
                            <div class="row">
                                
                                <div class="col-sm-6">
                                    <div class="form-group input-group input-group-sm">
                                        <span class="input-group input-group-sm">Select Application
                                            <span v-if="errors && errors.payer" class=" text-danger">&nbsp;&nbsp; {{ errors.payer[0] }}</span>
                                        </span>
                                        <select class="form-control" v-model="form.payer" >
                                            <option :value="payer.name" v-for="(payer) in payers" :key="payer.id">{{payer.name}}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group input-group input-group-sm">
                                        <span class="input-group input-group-sm">Enrollment/Credentialing
                                            <span v-if="errors && errors.enrollment_credentialing" class=" text-danger">&nbsp;&nbsp; {{ errors.enrollment_credentialing[0] }}</span>
                                        </span>
                                        <select class="form-control" v-model="form.enrollment_credentialing" >
                                            <option value="Enrollment" >Enrollment</option>
                                            <option value="Credentialing" >Credentialing</option>
                                            <option value="Enrollment/Credentialing" >Enrollment/Credentialing</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group input-group input-group-sm">
                                        <span class="input-group input-group-sm">ERA/EFT/EDI Portal
                                            <span v-if="errors && errors.era_eft_edi_portal" class=" text-danger">&nbsp;&nbsp; {{ errors.era_eft_edi_portal[0] }}</span>
                                        </span>
                                        <input v-model="form.era_eft_edi_portal" type="text" name="era_eft_edi_portal" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group input-group input-group-sm">
                                        <span class="input-group input-group-sm">Initiated/Followup
                                            <span v-if="errors && errors.initiated_followup" class=" text-danger">&nbsp;&nbsp; {{ errors.initiated_followup[0] }}</span>
                                        </span>
                                        <select class="form-control" v-model="form.initiated_followup" >
                                            <option value="Initiated">Initiated</option>
                                            <option value="Followup">Followup</option>
                                            <option value="Initiated/Followup">Initiated/Followup</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group input-group input-group-sm">
                                        <span class="input-group input-group-sm">Initiated Date
                                          <span v-if="errors && errors.initiated_date" class=" text-danger">&nbsp;&nbsp; {{ errors.initiated_date[0] }}</span>
                                        </span>
                                        <input v-model="form.initiated_date" type="date" name="initiated_date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group input-group input-group-sm">
                                        <span class="input-group input-group-sm">Followup Date
                                          <span v-if="errors && errors.followup_date" class=" text-danger">&nbsp;&nbsp; {{ errors.followup_date[0] }}</span>
                                        </span>
                                        <input v-model="form.followup_date" type="date" name="followup_date" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group input-group input-group-sm">
                                        <span class="input-group input-group-sm">Reference#
                                          <span v-if="errors && errors.reference_no" class=" text-danger">&nbsp;&nbsp; {{ errors.reference_no[0] }}</span>
                                        </span>
                                        <select class="form-control" v-model="form.reference_no" name="reference_no"  >
                                            <option value="Through Call" >Through Call</option>
                                            <option value="Through Email" >Through Email</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- 
                                <div class="col-sm-6">
                                    <div class="form-group input-group input-group-sm">
                                        <span class="input-group input-group-sm">Activity
                                            <span v-if="errors && errors.action" class=" text-danger">&nbsp;&nbsp; {{ errors.action[0] }}</span>
                                        </span>
                                        
                                        <select class="form-control" v-model="form.action" name="action"  >
                                            <option :value="activity.id" v-for="(activity) in activities" :key="activity.id">{{activity.name}}</option>
                                        </select>
                                        
                                    </div>
                                </div>
                                 -->
                                <div class="col-sm-12">
                                    <div class="form-group input-group input-group-sm">
                                        <span class="input-group input-group-sm">Comments
                                            <span v-if="errors && errors.description" class=" text-danger">&nbsp;&nbsp; {{ errors.description[0] }}</span>
                                        </span>
                                        <textarea name="description" class="form-control"   v-model="form.description" rows="5" placeholder="add multiple lines"></textarea>
                                        <has-error :form="form" field="description"></has-error>
                                    </div>
                                    
                                </div>
                                
                            </div>

                            <div class="modal-footer">
                                <button type="submit" v-on:click.prevent="createActivity" class="btn btn-primary">Save</button>
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
        
        
  </section>
</template>
<script>
import Multiselect from 'vue-multiselect'



    export default {
        components: { Multiselect},
        data () {
            return {
                    rows: [],
                    practices: [],
                    providers: [],
                    payers: [],
                    errors: {},
                    activities: [
                        {"id":"Followup","name":"Followup"},
                        {"id":"Call","name":"Call"},
                        {"id":"Submitted","name":"Submitted"},
                        {"id":"Referred","name":"Referred"},
                        {"id":"Research","name":"Research"},
                        {"id":"Other","name":"Other"},
                    ],
                    
                    editmode:false,
                    form: new Form({
                        id : '',
                        selected_practices:'',
                        provider_id: '',
                        payer: '',
                        action: '',
                        enrollment_credentialing: '',
                        era_eft_edi_portal:'',
                        initiated_followup:'',
                        initiated_date:'',
                        followup_date:'',
                        reference_no:'',
                        description:'',
                    }),
            }
        },
        methods: {
            onChangePractice (id) {

                if(id==null){
                    this.providers=[];
                    this.form.provider_id='';
                    this.payers=[];
                }else{
                    
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
                axios.get('api/provider/payers/'+id).then(function (res) {
                    this.payers = res.data.data
                        console.log(res.data);
                    }.bind(this));
            },
            
            createActivity(){
              this.errors = {};
              this.$Progress.start();
                        this.form.post('api/activity')
              .then((data)=>{
                if(data.data.success){

                  Toast.fire({
                        icon: 'success',
                        title: data.message
                    });
                  this.$Progress.finish();
                  form.reset();
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
          
          
          loadPractices: function () {
            axios.get('api/practice/listing').then(function (res) {
            
                this.practices = res.data.data;
            }.bind(this));
            },
            
        },
        created: function () {
           this.loadPractices();
        }
    }
</script>
