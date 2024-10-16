@extends('layouts.master') <!-- Adjust according to your layout -->
@section('title', 'Instructor Dashboard')
@section('content')
<div class="row">
    <!-- Total Tasks Card -->
    <div class="col-sm-6 col-lg-4">
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
    <div class="col-sm-6 col-lg-4">
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
    <div class="col-sm-6 col-lg-4">
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
</div>

<div class="row">
    <!-- Attendance Rate Card -->
    <div class="col-sm-6 col-lg-4">
        <div class="card text-white bg-flat-color-2" style="height: 150px;">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div class="card-left pt-1">
                    <h3 class="mb-0 fw-r">
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

    <!-- Average Submission Rate Card -->
    <div class="col-sm-6 col-lg-4">
        <div class="card text-white bg-flat-color-5" style="height: 150px;">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div class="card-left pt-1">
                    <h3 class="mb-0 fw-r">
                        <span class="count">{{ $averageSubmissionRate }}</span><span>%</span>
                    </h3>
                    <p class="text-light mt-1 m-0">Avg Submission Rate</p>
                </div>
                <div class="card-right text-right">
                    <i class="icon fade-5 icon-lg pe-7s-pen"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Notes Card -->
    <div class="col-sm-6 col-lg-4">
        <div class="card text-white bg-flat-color-4" style="height: 150px;">
            <div class="card-body d-flex align-items-center justify-content-between">
                <div class="card-left pt-1">
                    <h3 class="mb-0 fw-r">
                        <span class="count">{{ $notesCount }}</span>
                    </h3>
                    <p class="text-light mt-1 m-0">Total Notes</p>
                </div>
                <div class="card-right text-right">
                    <i class="icon fade-5 icon-lg pe-7s-note2"></i>
                </div>
            </div>
        </div>
    </div>
</div>


    <!-- Charts Section -->
    <div class="content">
        <div class="animated fadeIn">
          

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mb-3">Attendance Chart</h4>
                            <div class="flot-container">
                                <div id="flotBar" style="width:100%;height:275px;"></div>
                            </div>
                        </div>
                    </div><!-- /# card -->
                </div><!-- /# column -->

               
            </div><!-- /# row -->
        </div><!-- .animated -->
    </div>
    <!-- /.content -->
    <div class="clearfix"></div>
    <!-- Student Attendance and Submission Rate Table -->
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <strong class="card-title">Student Attendance and Submission Rates</strong>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Attendance Rate (%)</th>
                            <th>Submission Rate (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($studentDetails as $student)
                        <tr>
                            <td>{{ $student['name'] }}</td>
                            <td>{{ $student['email'] }}</td>
                            <td>{{ $student['attendance_rate'] }}%</td>
                            <td>{{ $student['submission_rate'] }}%</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

    <div class="clearfix"></div>

    
    <script>
        var attendanceData = {!! json_encode($attendanceData) !!};
      //  console.log(attendanceData); 
    </script>
    @section('charts')
    @include('layouts.charts')
    @endsection
    @endsection
    


  