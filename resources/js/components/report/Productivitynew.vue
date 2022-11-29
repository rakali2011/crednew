<template>
  <section class="content">
    <div class="container-fluid">
        <div class="row">

          <div class="col-12">
        
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">User Productivity Report New</h3>
                <div class="card-tools">
                 <vue-excel-xlsx
                    :data="data"
                    :columns="columns"
                    :file-name="'Activity Report'"
                    :file-type="'xlsx'"
                    :sheet-name="'activity'"
                    >
                    Export to Excel
                 </vue-excel-xlsx>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <vue-good-table
                  mode="remote"
                  @on-page-change="onPageChange"
                  @on-sort-change="onSortChange"
                  @on-column-filter="onColumnFilter"
                  @on-per-page-change="onPerPageChange"
                  @on-search="onSearch"
                  :totalRows="totalRecords"
                  :isLoading.sync="isLoading"
                  :pagination-options="{
                    enabled: true,
                    perPageDropdown: [10, 20],
                  }"
                  :rows="data"
                  :columns="columns"
                  :search-options="{
                    enabled: true,
                  }"
                />
                <!-- <vue-good-table
                  :key="componentKey"
                  :columns="columns"
                  :rows="rows"
                  :pagination-options="{
                    enabled: true
                  }"
                  :search-options="{
                        enabled: true
                  }">
                </vue-good-table> -->
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
const apiUrl ="/api/allusersactivitynew";
    export default {
        components: { VueGoodTable},
        data: () => {
    const columns = [
      {
        field: "practice_name",
        label: "Group Name",
      },
      {
        field: "provider_name",
        label: "Provider Name",
      },
      {
        field: "payer",
        label: "Insurance",
      },
      { field: "enrollment_credentialing", label: "Enrollment Or Credentialing" },
      { field: "era_eft_edi_portal", label: "ERA/EFT/EDI Portal" },
      {
        field: "initiated_followup",
        label: "Initiated/Followup",
      },
      { field: "followup_date", label: "Followup Date" },
      { field: "user", label: "Action By" },
      { field: "submitted_at", label: "Created At" },
      { field: "description", label: "Comments" },
    ];

    return {
      isLoading: false,
      columns: columns,
      data: [],
      totalRecords: 0,
      serverData: {
        columns: [],
        page: 1,
        pageSize: 10,
      },
    };
  },
  methods: {
    async onPageChange(params) {
      this.serverData.page = params.currentPage;
      await this.loadItems();
    },

    async onPerPageChange(params) {
      this.serverData.pageSize = params.currentPerPage;
      await this.loadItems();
    },

    async onSortChange(sort) {
      this.serverData.columns.forEach((c) => delete c.sort);

      sort.forEach((e) => {
        const columnIndex = this.serverData.columns.findIndex(
          (i) => i.field === e.field
        );

        if (columnIndex < 0) return;

        this.serverData.columns[columnIndex].sort = e.type;
      });

      await this.loadItems();
    },

    async onColumnFilter(params) {
      for (var key in params.columnFilters) {
        const columnIndex = this.serverData.columns.findIndex(
          (i) => i.field === key
        );

        if (columnIndex < 0) return;

        this.serverData.columns[columnIndex].search = params.columnFilters[key];
      }

      await this.loadItems();
    },

    async onSearch(data) {
      this.serverData.search = data.searchTerm;
      await this.loadItems();
    },

    async loadItems() {
      const result = (await axios.post(apiUrl, this.serverData)).data.data;
      this.totalRecords = result.recordsFiltered;
      this.data = result.data;
    },
  },

  async created() {
    this.columns.forEach((c) =>
      this.serverData.columns.push({
        field: c.field,
        name: c.label,
        searchable: c.searchable,
        sortable: c.sortable,
      })
    );

    await this.loadItems();
  },
    }
</script>
