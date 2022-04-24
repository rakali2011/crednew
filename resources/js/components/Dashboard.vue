<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fa fa-medkit"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Providers</span>
                            <span class="info-box-number">
                            {{dashboard_stats.total_providers}}
                            <small>Total</small>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-file-pdf"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Documents</span>
                            <span class="info-box-number">
                            {{dashboard_stats.total_documents}}
                            <small>Total</small>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fa fa-clipboard"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Payers</span>
                            <span class="info-box-number">
                            {{dashboard_stats.total_payers}}
                            <small>Total</small>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Practices</span>
                            <span class="info-box-number">
                            {{dashboard_stats.total_practices}}
                            <small>Total</small>
                            </span>
                        </div>
                    <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
            <!-- /.col -->
                
            <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
                <!-- Left col -->
                <div class="col-md-8">
                    <!-- Graph for app Statistics -->
                    <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Application Statistics</h3>

                        <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <div id="chart">
                            <apexchart type="pie" width="480" :options="chartOptions" :series="series"></apexchart>
                        </div>
                    </div>
                <!-- /.card-body -->
                </div>
                <!-- /.card -->
                <!-- /.card -->
            </div>
            <!-- /.col -->

            <div class="col-md-4">
                <!-- Info Boxes Style 2 -->
                <div class="info-box mb-3 bg-secondary">
                <span class="info-box-icon"><i class="fas fa-tag"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Participating</span>
                    <span class="info-box-number">{{dashboard_stats.participating}}</span>
                </div>
                <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
                <div class="info-box mb-3 bg-secondary">
                <span class="info-box-icon"><i class="fa fa-calendar-check"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Approved</span>
                    <span class="info-box-number">{{dashboard_stats.approved}}</span>
                </div>
                <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
                <div class="info-box mb-3 bg-secondary">
                <span class="info-box-icon"><i class="fas fa-cloud-download-alt"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Non-Participating</span>
                    <span class="info-box-number">{{dashboard_stats.non_participating}}</span>
                </div>
                <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
                <div class="info-box mb-3 bg-secondary">
                <span class="info-box-icon"><i class="far fa-comment"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">In-Process</span>
                    <span class="info-box-number">{{dashboard_stats.in_process}}</span>
                </div>
                <!-- /.info-box-content -->
                </div>
                <div class="info-box mb-3 bg-secondary">
                <span class="info-box-icon"><i class="fas fa-tag"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Pending PRG</span>
                    <span class="info-box-number">{{dashboard_stats.pending_prg}}</span>
                </div>
                <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
                <div class="info-box mb-3 bg-secondary">
                <span class="info-box-icon"><i class="fa fa-calendar-check"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Pending Provider</span>
                    <span class="info-box-number">{{dashboard_stats.pending_provider}}</span>
                </div>
                <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
                <div class="info-box mb-3 bg-secondary">
                <span class="info-box-icon"><i class="fas fa-cloud-download-alt"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Rejected</span>
                    <span class="info-box-number">{{dashboard_stats.rejected}}</span>
                </div>
                <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
                <div class="info-box mb-3 bg-secondary">
                <span class="info-box-icon"><i class="far fa-comment"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Not Eligible</span>
                    <span class="info-box-number">{{dashboard_stats.not_eligible}}</span>
                </div>
                <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
                <div class="info-box mb-3 bg-secondary">
                <span class="info-box-icon"><i class="far fa-comment"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Panel Closed</span>
                    <span class="info-box-number">{{dashboard_stats.panel_closed}}</span>
                </div>
                <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!--/. container-fluid -->
    </section>
</template>

<script>
    


    export default {

        data () {
            return {
            dashboard_stats: [],
            series: [0, 0, 0, 0, 0, 0, 0, 0, 0],
          chartOptions: {
            chart: {
              width: 380,
              type: 'pie',
            },
            labels: ['Participating', 'Approved', 'Non-Participating', 'In-Process', 'Pending PRG', 'Pending Provider', 'Rejected', 'Not Eligible', 'Panel Closed' ],
            responsive: [{
              breakpoint: 480,
              options: {
                chart: {
                  width: 200
                },
                legend: {
                  position: 'bottom'
                }
              }
            }]
          },



            }
        },
        mounted() {
            axios.get('api/dashboard_counts').then(function (res) {
                this.dashboard_stats=res.data.data;
                let resp=res.data.data;
                let participating = resp.participating;
                let approved = resp.approved;
                let non_participating = resp.non_participating;
                let in_process = resp.in_process;
                let pending_prg = resp.pending_prg;
                let pending_provider = resp.pending_provider;
                let rejected = resp.rejected;
                let not_eligible = resp.not_eligible;
                let panel_closed = resp.panel_closed;
this.series= [participating, approved, non_participating, in_process, pending_prg, pending_provider, rejected, not_eligible, panel_closed];
                        console.log(res.data);
                    }.bind(this));
            console.log('Component mounted.')
        }
    }
</script>
