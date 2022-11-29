<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">

          <div class="col-12">
        
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Export Application Status Report</h3>
                <div class="card-tools">
                 
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="col-sm-6">
                    <div class="form-group input-group input-group-sm">
                        <span class="input-group input-group-sm">Select Practice</span>
                        <multiselect v-model="selected_practice" :multiple="false" :options="practices.map(prac => prac.id)" :custom-label="opt => practices.find(x => x.id == opt).practice_name" @input="onChangePractice" placeholder="Select Practice">
                        <template slot="selection" slot-scope="{ values, search, isOpen }"><span class="multiselect__single" v-if="values.length >3 &amp;&amp; !isOpen">{{ values.length }} practices selected</span></template>
                        </multiselect>
                    </div>
                </div>
                <div class="modal-footer">
                    <button v-show="selected_practice" type="button" class="btn btn-sm btn-primary" @click="exportExcel">
                      <i class="fa fa-file-excel"></i>
                      Export to excel
                    </button>
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
        
        
  </section>
</template>
<script>
import Multiselect from 'vue-multiselect'
    export default {
        components: { Multiselect},
        data () {
            return {
                practices: [],
                selected_practice:'',
      
    }
        },
        methods: {
            onChangePractice (id) {
                if(id==null){
                    
                }else{

                }
            },
            loadPractices: function () {
            axios.get('/api/practice/listing').then(function (res) {
            
                this.practices = res.data.data;
            }.bind(this));
            },
            exportExcel(){
              var win = window.open('/practiceprovider/export/'+this.selected_practice, '_blank');
            if (win) {
                //Browser has allowed it to be opened
                win.focus();
            } else {
                //Browser has blocked it
                alert('Please allow popups for this website');
            }
          },
        },
        created: function () {
            this.loadPractices();
        }
    }
</script>
