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
                                           <td>{{doc.issue_date}}</td>
                                           <td>{{doc.expiry_date}}</td>
                                           <td><a href="#" pro_id="576" pay_id="11" data-toggle="modal" class="remark_detail_view">View</a></td>
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
                remarksModal: function (pro_id,pay_id) {
                axios.get('api/getRemarks?pro_id='+pro_id+'&pay_id='+pay_id).then(function (res) {
                    
                    this.$emit('clicked', res.data.data);
                    $('#remarksDetail').modal('show');
                }.bind(this));
                
            },
	}
}
</script>