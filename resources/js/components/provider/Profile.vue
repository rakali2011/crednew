<template>
	<div class="modal fade" id="infoNew" tabindex="-1" role="dialog" aria-labelledby="infoNew" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Provider Profile</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                <div class="section-heading">Personal</div>
                <div class="provider_formbox">
                    <div class="row">
                        <div class="col-sm-3">
                                <span class="input-group input-group-sm"><strong>Full Name:</strong></span>
                        </div>
                        <div class="col-sm-3">
                                <span class="input-group input-group-sm">{{listdata.full_name}}</span>
                        </div>
                        <div class="col-sm-3">
                                <span class="input-group input-group-sm"><strong>SSN:</strong></span>
                        </div>
                        <div class="col-sm-3">
                                <span class="input-group input-group-sm">{{listdata.ssn}}</span>
                        </div>
                        <div class="col-sm-3">
                                <span class="input-group input-group-sm"><strong>NPI:</strong></span>
                        </div>
                        <div class="col-sm-3">
                                <span class="input-group input-group-sm">{{listdata.individual_npi}}</span>
                        </div>
                        <div class="col-sm-3">
                                <span class="input-group input-group-sm"><strong>Tax ID:</strong></span>
                        </div>
                        <div class="col-sm-3">
                                <span class="input-group input-group-sm">{{listdata.tax_id}}</span>
                        </div>
                    </div>
                </div>
                <div class="section-heading">CAQH/PECOS</div>
                <div class="provider_formbox">
                    <div class="row">
                        <div class="col-sm-3">
                                <span class="input-group input-group-sm"><strong>CAQH User:</strong></span>
                        </div>
                        <div class="col-sm-3">
                                <span class="input-group input-group-sm">{{listdata.caqh_user}}</span>
                        </div>
                        <div class="col-sm-3">
                                <span class="input-group input-group-sm"><strong>CAQH Pass:</strong></span>
                        </div>
                        <div class="col-sm-3">
                                <span class="input-group input-group-sm">{{listdata.caqh_pass}}</span>
                        </div>
                        <div class="col-sm-3">
                                <span class="input-group input-group-sm"><strong>CAQH ID:</strong></span>
                        </div>
                        <div class="col-sm-3">
                                <span class="input-group input-group-sm">{{listdata.caqh_id}}</span>
                        </div>
                        <div class="col-sm-3">
                                <span class="input-group input-group-sm"><strong>PECOS User:</strong></span>
                        </div>
                        <div class="col-sm-3">
                                <span class="input-group input-group-sm">{{listdata.pecos_user}}</span>
                        </div>
                        <div class="col-sm-3">
                                <span class="input-group input-group-sm"><strong>PECOS Pass:</strong></span>
                        </div>
                        <div class="col-sm-3">
                                <span class="input-group input-group-sm">{{listdata.pecos_pass}}</span>
                        </div>
                    </div>
                </div>
                <div class="section-heading">Enrollment</div>
                <div class="provider_formbox">
                    <div class="form-group">
                        <table width="100%">
                            <thead>
                                <tr>
                                    <th>Payer Name</th>
                                    <th>Status</th>
                                    <th>Provider Id</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody id="enrollment_rows">
                                        <tr v-for='(enroll, index) in listdata.payers'>
                                           <td>{{enroll.name}}</td>
                                           <td>{{enroll.pivot.status}}</td>
                                           <td>{{enroll.pivot.provider_identifier}}</td>
                                           <td><a @click="remarksModal(listdata.id,enroll.id)" href="#" pro_id="576" pay_id="11" data-toggle="modal" class="remark_detail_view">Show</a></td>
                                        </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="section-heading">Documents</div>
                <div class="provider_formbox">
                    <div class="form-group">
                        <table width="100%">
                            <thead>
                                <tr>
                                    <th>Document Type</th>
                                    <th>Document Name</th>
                                    <th>Issue Date</th>
                                    <th>Expiry Date</th>
                                    <th>View</th>
                                </tr>
                            </thead>
                            <tbody id="document_rows">
                                <tr v-for='(doc, index) in listdata.documents'>
                                           <td v-if="doc.document_type.type">{{doc.document_type.type}}</td>
                                           <td v-else></td>
                                           <td>{{doc.name}}</td>
                                           <td>{{doc.issue_date | usDate}}</td>
                                           <td>{{doc.expiry_date | usDate}}</td>
                                           <td><a :href="'/document/' + doc.id" target="_blank">Show</a></td>
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
            showDoc: function (doc_id) {
                window.open(
  'http://127.0.0.1:8000/document/show/1',
  '_blank' // <- This is what makes it open in a new window.
);
                // window.location="www.google.com";
                // alert("testing");
            },
	}
}
</script>