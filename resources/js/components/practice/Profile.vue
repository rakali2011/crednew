<template>
	<div class="modal fade" id="infoNew" tabindex="-1" role="dialog" aria-labelledby="infoNew" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Practice Profile</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                <div class="section-heading">Practice Info</div>
                <div class="provider_formbox">
                    <div class="row">
                        <div class="col-sm-3">
                                <span class="input-group input-group-sm"><strong>Client Name:</strong></span>
                        </div>
                        <div class="col-sm-3">
                                <span class="input-group input-group-sm">{{listdata.client_name}}</span>
                        </div>
                        <div class="col-sm-3">
                                <span class="input-group input-group-sm"><strong>Practice Name:</strong></span>
                        </div>
                        <div class="col-sm-3">
                                <span class="input-group input-group-sm">{{listdata.practice_name}}</span>
                        </div>
                        <div class="col-sm-3">
                                <span class="input-group input-group-sm"><strong>Group NPI:</strong></span>
                        </div>
                        <div class="col-sm-3">
                                <span class="input-group input-group-sm">{{listdata.group_npi}}</span>
                        </div>
                        <div class="col-sm-3">
                                <span class="input-group input-group-sm"><strong>Tax ID:</strong></span>
                        </div>
                        <div class="col-sm-3">
                                <span class="input-group input-group-sm">{{listdata.practice_tax_id}}</span>
                        </div>
                        <div class="col-sm-3">
                                <span class="input-group input-group-sm"><strong>Specialty:</strong></span>
                        </div>
                        <div class="col-sm-3">
                                <span class="input-group input-group-sm">{{listdata.speciality}}</span>
                        </div>
                        <div class="col-sm-3">
                                <span class="input-group input-group-sm"><strong>Taxnomy:</strong></span>
                        </div>
                        <div class="col-sm-3">
                                <span class="input-group input-group-sm">{{listdata.taxnomy}}</span>
                        </div>
                    </div>
                </div>
                
                
                <div class="section-heading">Practice Documents</div>
                <div class="provider_formbox">
                    <div class="form-group">
                        <table width="100%">
                            <thead>
                                <tr>
                                    <th>Document Type</th>
                                    <th>Document Name</th>
                                    <th>Issue Date</th>
                                    <th>Expiry Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="document_rows">
                                <tr v-for='(doc, index) in listdata.documents'>
                                           <td v-if="doc.document_type.type">{{doc.document_type.type}}</td>
                                           <td v-else></td>
                                           <td>{{doc.name}}</td>
                                           <td>{{doc.issue_date | usDate}}</td>
                                           <td>{{doc.expiry_date | usDate}}</td>
                                           <td><a :href="'/pdocument/' + doc.id" target="_blank">Show</a>&nbsp;<a @click="delDoc(doc.id)" >Delete</a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="section-heading">Providers</div>
                <div class="provider_formbox">
                    <div class="form-group">
                        <table width="100%">
                            <thead>
                                <tr>
                                    <th>Full Name</th>
                                    <th>NPI</th>
                                    <th>SSN</th>
                                    <th>Tax ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for='(pro, index) in listdata.providers'>
                                           <td>{{pro.full_name}}</td>
                                           <td>{{pro.individual_npi}}</td>
                                           <td>{{pro.ssn}}</td>
                                           <td>{{pro.tax_id}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
                </div>
            </div>
        </div>


</template>

<script>
export default {
        props: ['listdata'],
        
	name: "Profile",
	data: function (){
		return{
			dataObj:{
				title: 'abc',
				body:''
			}
		}
	},
	methods:{
                  delDoc(id){
              Swal.fire({
                  title: 'Are you sure?',
                  text: "You won't be able to revert this!",
                  showCancelButton: true,
                  confirmButtonColor: '#d33',
                  cancelButtonColor: '#3085d6',
                  confirmButtonText: 'Yes, delete it!'
                  }).then((result) => {
// :href="'/pdocument/delete/' + doc.id"
                      // Send request to the server
                        if (result.value) {
                              axios.delete('api/practicedoc/'+id).then(()=>{
                                      Swal.fire(
                                      'Deleted!',
                                      'Your document has been deleted.',
                                      'success'
                                      );
                                  // Fire.$emit('AfterCreate');
                                //   this.loadProviders();
                                 $('#infoNew').modal('hide');
                              }).catch((data)=> {
                                  Swal.fire("Failed!", data.message, "warning");
                              });
                        }
                  })
          },
                remarksModal: function (pro_id,pay_id) {
                axios.get('api/getRemarks?pro_id='+pro_id+'&pay_id='+pay_id).then(function (res) {
                    
                    this.$emit('clicked', res.data.data);
                    $('#remarksDetail').modal('show');
                }.bind(this));
                
            },
	}
}
</script>