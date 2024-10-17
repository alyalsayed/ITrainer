@extends('layouts.master')
@section('title', 'Admin Dashboard')
@section('content')
<div class="row">
    <!-- Total Admins Card -->
    <div class="col-sm-6 col-lg-3">
        <div class="card text-white bg-flat-color-1">
            <div class="card-body">
                <div class="card-left pt-1 float-left">
                    <h3 class="mb-0 fw-r">
                        <span class="count">{{ $totalAdmins }}</span>
                    </h3>
                    <p class="text-light mt-1 m-0">Total Admins</p>
                </div>
                <div class="card-right float-right text-right">
                    <i class="icon fade-5 icon-lg pe-7s-users"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Instructors Card -->
    <div class="col-sm-6 col-lg-3">
        <div class="card text-white bg-flat-color-2">
            <div class="card-body">
                <div class="card-left pt-1 float-left">
                    <h3 class="mb-0 fw-r">
                        <span class="count">{{ $totalInstructors }}</span>
                    </h3>
                    <p class="text-light mt-1 m-0">Total Instructors</p>
                </div>
                <div class="card-right float-right text-right">
                    <i class="icon fade-5 icon-lg pe-7s-id"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Tracks Card -->
    <div class="col-sm-6 col-lg-3">
        <div class="card text-white bg-flat-color-3">
            <div class="card-body">
                <div class="card-left pt-1 float-left">
                    <h3 class="mb-0 fw-r">
                        <span class="count">{{ $totalTracks }}</span>
                    </h3>
                    <p class="text-light mt-1 m-0">Total Tracks</p>
                </div>
                <div class="card-right float-right text-right">
                    <i class="icon fade-5 icon-lg pe-7s-map-marker"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Students Card -->
    <div class="col-sm-6 col-lg-3">
        <div class="card text-white bg-flat-color-4">
            <div class="card-body">
                <div class="card-left pt-1 float-left">
                    <h3 class="mb-0 fw-r">
                        <span class="count">{{ $totalStudents }}</span>
                    </h3>
                    <p class="text-light mt-1 m-0">Total Students</p>
                </div>
                <div class="card-right float-right text-right">
                    <i class="icon fade-5 icon-lg pe-7s-study"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Total HR Card -->
    <div class="col-sm-6 col-lg-3">
        <div class="card text-white bg-flat-color-5">
            <div class="card-body">
                <div class="card-left pt-1 float-left">
                    <h3 class="mb-0 fw-r">
                        <span class="count">{{ $totalHR }}</span>
                    </h3>
                    <p class="text-light mt-1 m-0">Total HR</p>
                </div>
                <div class="card-right float-right text-right">
                    <i class="icon fade-5 icon-lg pe-7s-users"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bar Chart for Students in Each Track -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3">Students in Each Track</h4>
                <canvas id="studentsBarChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('studentsBarChart').getContext('2d');
    const studentsBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($trackNames),
            datasets: [{
                label: 'Number of Students',
                data: @json($studentCounts),
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

  
@endSection