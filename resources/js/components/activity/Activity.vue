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
                                        <span class="input-group input-group-sm">Select Provider</span>
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
                                        <span class="input-group input-group-sm">Select Application</span>
                                        <select class="form-control" v-model="form.payer" >
                                            <option :value="payer.name" v-for="(payer) in payers" :key="payer.id">{{payer.name}}</option>
                                        </select>
                                    </div>
                                </div>
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
                                <div class="col-sm-12">
                                    <div class="form-group input-group input-group-sm">
                                        <span class="input-group input-group-sm">Description/Remarks
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
                        {"id":"followup","name":"Followup"},
                        {"id":"call","name":"Call"},
                        {"id":"submitted","name":"Submitted"},
                        {"id":"referred","name":"Referred"},
                        {"id":"research","name":"Research"},
                        {"id":"other","name":"Other"},
                    ],
                    editmode:false,
                    form: new Form({
                        id : '',
                        selected_practices:'',
                        provider_id: '',
                        payer: '',
                        action: '',
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
