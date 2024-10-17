@extends('layouts.master')
@section('title', 'Student Dashboard')

@section('content')
<div class="container">
    <h1 class="mb-4">Student Dashboard</h1>

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

        <!-- Total Notes Card -->
        <div class="col-sm-6 col-lg-4">
            <div class="card text-white bg-flat-color-6" style="height: 150px;">
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

        <!-- Attendance Rate Card -->
        <div class="col-sm-6 col-lg-4">
            <div class="card text-white bg-flat-color-4" style="height: 150px;">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="card-left pt-1">
                        <h3 class="mb-0 fw-r">
                            <span class="count">{{ $attendanceRate }}%</span>
                        </h3>
                        <p class="text-light mt-1 m-0">Attendance Rate</p>
                    </div>
                    <div class="card-right text-right">
                        <i class="icon fade-5 icon-lg pe-7s-clock"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Task Submission Rate Card -->
        <div class="col-sm-6 col-lg-4">
            <div class="card text-white bg-flat-color-2" style="height: 150px;">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div class="card-left pt-1">
                        <h3 class="mb-0 fw-r">
                            <span class="count">{{ $submissionRate }}%</span>
                        </h3>
                        <p class="text-light mt-1 m-0">Submission Rate</p>
                    </div>
                    <div class="card-right text-right">
                        <i class="icon fade-5 icon-lg pe-7s-check"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h3 class="my-4">Upcoming Sessions</h3>
    <div class="row">
        @foreach ($sessions->filter(fn($session) => \Carbon\Carbon::parse($session->session_date)->isToday() || \Carbon\Carbon::parse($session->session_date)->isFuture()) as $session)
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">{{ $session->name }}: {{ \Carbon\Carbon::parse($session->session_date)->format('F j, Y') }}</strong>
                </div>
                <div class="card-body">
                    <p class="card-text">
                        <strong>Time:</strong> {{ \Carbon\Carbon::parse($session->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($session->end_time)->format('g:i A') }}<br>
                        <strong>Location:</strong> {{ $session->location }}
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <h3 class="my-4">Upcoming Tasks</h3>
    <div class="row">
        @foreach ($tasks->filter(fn($task) => \Carbon\Carbon::parse($task->due_date)->isToday() || \Carbon\Carbon::parse($task->due_date)->isFuture()) as $task)
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <strong class="card-title">{{ $task->name }}: Due {{ \Carbon\Carbon::parse($task->due_date)->format('F j, Y') }}</strong>
                </div>
                <div class="card-body">
                    <p class="card-text">
                        {{ $task->description }}
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
