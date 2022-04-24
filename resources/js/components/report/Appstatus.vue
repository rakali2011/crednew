<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">

          <div class="col-12">
        
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Providers' Application Status Report</h3>
                <div class="card-tools">
                 
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
        
        
  </section>
</template>
<script>
import { VueGoodTable } from 'vue-good-table';

    export default {
        components: { VueGoodTable},
        data () {
            return {
      columns: [
        {
          label: 'Name',
          field: 'name',
        },
        {
          label: 'Apps Total',
          field: 'appstotal',
        },
        {
          label: 'New',
          field: 'new',
        },
        {
          label: 'Approved',
          field: 'approved',
        },
        {
          label: 'Participating',
          field: 'participating',
        },
        {
          label: 'Non-Participating',
          field: 'nonparticipating',
        },
        {
          label: 'In-Process',
          field: 'inporcess',
        },
        {
          label: 'Pending PRG',
          field: 'pending',
        },
        {
          label: 'Pending Provider',
          field: 'pen_provider',
        },
        {
          label: 'Rejected',
          field: 'rejected',
        },
        {
          label: 'Panel Closed',
          field: 'pen_closed',
        },
      ],
      rows: [],
                editmode: false,
                form: new Form({
                    id : '',
                    name : '',
                }),
                componentKey: 0,
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
            createPayer(){
              this.$Progress.start();
              this.form.post('api/payer')
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
              .catch(()=>{
                  Toast.fire({
                      icon: 'error',
                      title: 'Some error occured! Please try again2!'
                  });
              })
          },
          updatePayer(){
              this.$Progress.start();
              this.form.put('api/payer/'+this.form.id)
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
          loadPayers: function () {
                axios.post('/api/allprovidersstatus').then(function (res) {
                    this.rows = res.data.data;
                }.bind(this));
            },
        },
        created: function () {
           this.loadPayers()
            
        }
    }
</script>
