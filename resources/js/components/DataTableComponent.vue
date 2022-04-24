<template>
    <div>
        <div class="row">
            <div class="col-sm-3">
                <input v-model="filter" type="text" class="form-control" name="search" placeholder="Search...">
            </div>
        </div>

        <bootstrap-4-datatable :columns="columns" :data="rows" :filter="filter" :per-page="perPage" :key="componentKey"></bootstrap-4-datatable>
        <bootstrap-4-datatable-pager v-model="page" type="abbreviated"></bootstrap-4-datatable-pager>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                columns: [{
                        label: 'NPI',
                        field: 'individual_npi'
                    },
                    {
                        label: 'Name',
                        field: 'last_name'
                    },
                    {
                        label: 'Email',
                        field: 'email'
                    },
                    {
                        label: 'Status',
                        field: 'status'
                    }
                ],
                
                componentKey: 0,
                rows: [],
                page: 1,
                filter:  '',
                perPage: 10,
            }
        },
        methods: {
            loadProviders: function () {
                axios.get('api/provider').then(function (res) {
                    this.rows = res.data.data.data;
                }.bind(this));
            },
forceRerender() {
  this.componentKey += 1;
}

        },
        created: function () {
            this.loadProviders()
            
        }
    }
</script>