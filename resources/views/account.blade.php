@extends('layout.main')

@section('layout.main')
<!-- Main Content Starts -->
<div class="container-fluid mb-4">
    <h1 class="h3 mb-0 text-gray-800">Respected Staff Members</h1>
</div>

<div class="container-fluid">
    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th class="text-center">Department</th>
                            <th class="text-center">Teacher Name</th>
                            <th class="text-center">Picture</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $staff = [
                                ['department' => 'Chemistry', 'name' => 'Iftikhar Ahmad Shahid', 'image' => 'Muhammad-imran.jpg'],
                                ['department' => 'Mathematics', 'name' => 'Rashid Khan', 'image' => 'Muhammad-imran.jpg'],
                                ['department' => 'Physics', 'name' => 'Tahir Mehmood', 'image' => 'Muhammad-imran.jpg'],
                                ['department' => 'Computer Science', 'name' => 'Muhammad Imran', 'image' => 'Muhammad-imran.jpg'],
                                ['department' => 'English', 'name' => 'Mudasir Buzdar', 'image' => 'Muhammad-imran.jpg'],
                                ['department' => 'Biology', 'name' => 'Maqsood Baloch', 'image' => 'Muhammad-imran.jpg'],
                                ['department' => 'Economics', 'name' => 'Muhammad Imran', 'image' => 'Muhammad-imran.jpg', 'salary' => 71000],
                                ['department' => 'Arts', 'name' => 'Muhammad Imran', 'image' => 'Muhammad-imran.jpg', 'salary' => 71000],
                                ['department' => 'Urdu', 'name' => 'Baqir Hussain', 'image' => 'Muhammad-imran.jpg'],
                                ['department' => 'Office Assistant', 'name' => 'Muhammad Ahmad', 'image' => 'Muhammad-imran.jpg'],
                            ];
                        @endphp

                        @foreach ($staff as $member)
                            <tr>
                                <td class="text-uppercase font-weight-bold text-primary align-middle">{{ $member['department'] }}</td>
                                <td class="font-weight-bold align-middle">{{ $member['name'] }}</td>
                                <td class="align-middle">
                                    <img src="{{ asset($member['image']) }}" alt="Staff Image" class="rounded-circle shadow"
                                        style="width: 60px; height: 60px; object-fit: cover; border: 2px solid #007bff;">
                                </td>
                                <td class="align-middle">
                                    <a href="{{ route('salary.show', ['teacher' => Str::slug($member['name'])]) }}" 
                                       class="btn btn-success btn-sm">
                                       Calculate Salary
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- End of Main Content -->
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('.calculate-salary').forEach(button => {
            button.addEventListener('click', function () {
                alert('Salary calculation logic will be implemented here.');
            });
        });
    });
</script>
@endsection
