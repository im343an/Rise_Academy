@extends('layout.main')
@section('layout.main')

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Class Attendance</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Class Name</th>
                            <th>Total Students</th>
                            <th>Attendance Status</th>
                            <th>Take Attendance</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($classes as $class)
                            <tr>
                                <td>{{ $class['name'] }}</td>
                                <td>{{ $class['total_students'] }}</td>
                                <td class="text-center">
                                    <span class="badge {{ $class['attendance_status'] === 'Submitted' ? 'badge-success' : 'badge-danger' }}">
                                        {{ $class['attendance_status'] }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('attendance-form', [
                                            'year' => $class['desired_class'], 
                                            'category' => $class['catagory'], 
                                            'gender' => $class['gender']
                                        ]) }}" class="btn btn-primary btn-sm">
                                            Take Attendance
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
