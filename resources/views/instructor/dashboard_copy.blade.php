@extends('layouts.master') <!-- Adjust according to your layout -->
@section('title', 'Instructor Dashboard')
@section('content')
    <div class="row">
        <!-- Total Tasks Card -->
        <div class="col-sm-6 col-lg-3">
            <div class="card text-white bg-flat-color-1" style="height: 150px;">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="card-left pt-1">
                        <h3 class="mb-0 fw-r">
                            <span class="count">{{ $tasks->count() }}</span>
                        </h3>
                        <p class="text-light mt-1 m-0">Total Tasks</p>
                    </div>
                    <div class="card-right text-right">
                        <i class="icon fade-5 icon-lg pe-7s-notebook"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Total Students Card -->
        <div class="col-sm-6 col-lg-3">
            <div class="card text-white bg-flat-color-6" style="height: 150px;">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="card-left pt-1">
                        <h3 class="mb-0 fw-r">
                            <span class="count">{{ $studentCount->sum('student_count') }}</span>
                        </h3>
                        <p class="text-light mt-1 m-0">Total Students</p>
                    </div>
                    <div class="card-right text-right">
                        <i class="icon fade-5 icon-lg pe-7s-users"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Sessions Card -->
        <div class="col-sm-6 col-lg-3">
            <div class="card text-white bg-flat-color-3" style="height: 150px;">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="card-left pt-1">
                        <h3 class="mb-0 fw-r">
                            <span class="count">{{ $sessions->count() }}</span>
                        </h3>
                        <p class="text-light mt-1 m-0">Total Sessions</p>
                    </div>
                    <div class="card-right text-right">
                        <i class="icon fade-5 icon-lg pe-7s-date"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Attendance Rate Card -->
        <div class="col-sm-6 col-lg-3">
            <div class="card text-white bg-flat-color-2" style="height: 150px;">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="card-left pt-1">
                        <h3 class="mb-0 fw-r">
                            @php
                                $totalAttendance = $attendanceRecords->sum('total_count');
                                $presentAttendance = $attendanceRecords->sum('present_count');
                                $attendanceRate = $totalAttendance > 0 ? round(($presentAttendance / $totalAttendance) * 100, 2) : 0;
                            @endphp
                            <span class="count">{{ $attendanceRate }}</span><span>%</span>
                        </h3>
                        <p class="text-light mt-1 m-0">Attendance Rate</p>
                    </div>
                    <div class="card-right text-right">
                        <i class="icon fade-5 icon-lg pe-7s-check"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Notes Card -->
        <div class="col-sm-6 col-lg-3">
            <div class="card text-white bg-flat-color-4" style="height: 150px;">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="card-left pt-1">
                        <h3 class="mb-0 fw-r">
                            <span class="count">{{ $notesCount }}</span>
                        </h3>
                        <p class="text-light mt-1 m-0">Total Notes</p>
                    </div>
                    <div class="card-right text-right">
                        <i class="icon fade-5 icon-lg pe-7s-note"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


    <!-- Charts Section -->
    <div class="content">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mb-3">Real Chart</h4>
                            <div class="flot-container">
                                <div id="cpu-load" class="cpu-load"></div>
                            </div>
                        </div>
                    </div>
                </div><!-- /# column -->

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mb-3">Line Chart</h4>
                            <div class="flot-container">
                                <div id="flot-line" class="flot-line"></div>
                            </div>
                        </div>
                    </div>
                </div><!-- /# column -->
            </div><!-- /# row -->

            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mb-3">Pie Chart</h4>
                            <div class="flot-container">
                                <div id="flot-pie" class="flot-pie-container"></div>
                            </div>
                        </div>
                    </div><!-- /# card -->
                </div><!-- /# column -->

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mb-3">Line Chart</h4>
                            <div class="flot-container">
                                <div id="chart1" style="width:100%;height:275px;"></div>
                            </div>
                        </div>
                    </div><!-- /# card -->
                </div><!-- /# column -->
            </div><!-- /# row -->

            <div class="row">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mb-3">Bar Chart</h4>
                            <div class="flot-container">
                                <div id="flotBar" style="width:100%;height:275px;"></div>
                            </div>
                        </div>
                    </div><!-- /# card -->
                </div><!-- /# column -->

                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mb-3">Bar Chart</h4>
                            <div class="flot-container">
                                <div id="flotCurve" style="width:100%;height:275px;"></div>
                            </div>
                        </div>
                    </div><!-- /# card -->
                </div><!-- /# column -->
            </div><!-- /# row -->
        </div><!-- .animated -->
    </div>
    <!-- /.content -->
    <div class="clearfix"></div>
@endsection
