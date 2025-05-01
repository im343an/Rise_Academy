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
                            <th>Subjects Marks Upload Progress</th>
                            <th>Enter Marks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($classes as $class)
                            @php
                                $totalSubjects = $class['total_subjects'] ?? 0;
                                $subjectsWithMarks = $class['subjects_with_marks'] ?? 0;
                                $uploadPercentage = ($totalSubjects > 0) ? ($subjectsWithMarks / $totalSubjects) * 100 : 0;
                            @endphp
                            <tr>
                                <td>{{ $class['name'] }}</td>
                                <td>{{ $class['total_students'] }}</td>
                                <td>
                                    <div class="progress" style="position: relative; height: 25px;">
                                        @php
                                            $totalSubjects = $class['total_subjects'];
                                            $subjectsWithMarks = $class['subjects_with_marks'];
                                            $uploadPercentage = ($totalSubjects > 0) ? ($subjectsWithMarks / $totalSubjects) * 100 : 0;
                                        @endphp
                                        <div class="progress-bar bg-info" 
                                             role="progressbar" 
                                             style="width: {{ $uploadPercentage }}%;" 
                                             aria-valuenow="{{ $uploadPercentage }}" 
                                             aria-valuemin="0" 
                                             aria-valuemax="100">
                                        </div>
                                        <span class="position-absolute w-100 text-center font-weight-bold" 
                                              style="left: 0; top: 50%; transform: translateY(-50%); color: black;">
                                            {{ $subjectsWithMarks }}/{{ $totalSubjects }} subjects' marks uploaded
                                        </span>
                                    </div>
                                </td>
                                                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('marks-form', [
                                            'year' => $class['desired_class'], 
                                            'category' => $class['catagory'], 
                                            'gender' => $class['gender']
                                        ]) }}" class="btn btn-primary btn-sm">
                                            Enter Marks
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
