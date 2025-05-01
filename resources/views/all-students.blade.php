@extends('layout.main')

@section('layout.main')
    <div class="container-fluid">
        @if(session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif(session()->has('edit'))
        <div class="alert alert-info">
            {{ session('edit') }}
        </div>
    @elseif(session()->has('delete'))
        <div class="alert alert-danger">
            {{ session('delete') }}
        </div>
    @endif

    <!-- Filters -->
    <form method="GET" action="{{ route('filter-students') }}" id="filterForm">
        <div class="row mb-3 d-flex align-items-end">
            <div class="col-md-2">
                <label for="yearFilter">Select Year:</label>
                <select class="form-control" name="year" id="yearFilter">
                    <option value="">All</option>
                    <option value="1styear" {{ request('year') == '1styear' ? 'selected' : '' }}>1st Year</option>
                    <option value="2ndyear" {{ request('year') == '2ndyear' ? 'selected' : '' }}>2nd Year</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="sessionFilter">Select Session:</label>
                <select class="form-control" name="session" id="sessionFilter">
                    <option value="">All</option>
                    <option value="2025-2027" {{ request('session') == '2025-2027' ? 'selected' : '' }}>2025-2027</option>
                    <option value="2026-2028" {{ request('session') == '2026-2028' ? 'selected' : '' }}>2026-2028</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="catagory">Select Category:</label>
                <select class="form-control" name="category" id="catagory">
                    <option value="">All</option>
                    <option value="fscPreMedical" {{ request('category') == 'fscPreMedical' ? 'selected' : '' }}>Pre-Medical</option>
                    <option value="fscPreEngineering" {{ request('category') == 'fscPreEngineering' ? 'selected' : '' }}>Pre-Engineering</option>
                    <option value="ics" {{ request('category') == 'ics' ? 'selected' : '' }}>ICS</option>
                    <option value="faIt" {{ request('category') == 'faIt' ? 'selected' : '' }}>FA-IT</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="sectionFilter">Select Section:</label>
                <select class="form-control" name="gender" id="sectionFilter">
                    <option value="">All</option>
                    <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100" id="searchButton">Search</button>
                <button type="button" class="btn btn-warning w-100 mt-2" onclick="clearFilters()">Reset Filters</button>
            </div>
                        
        </div>
    </form>
    
    <!-- Data Table -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Father Name</th>
                            <th>Phone No.</th>
                            <th>Father Profession</th>
                            <th>Previous School</th>
                            <th>Gender</th>
                            <th>Previous Class</th>
                            <th>Marks</th>
                            <th>Desired Class</th>
                            <th>Session</th>
                            <th>Catagory</th>
                            <th>Current Year</th>
                            <th>Address</th>
                            <th>Source</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($students as $student)
                        <tr>
                            <td>{{$student->id}}</td>
                            <td>{{$student->name}}</td>
                            <td>{{$student->father_name}}</td>
                            <td>{{$student->phone_number}}</td>
                            <td>{{$student->father_profession}}</td>
                            <td>{{$student->previous_school}}</td>
                            <td>{{$student->gender}}</td>
                            <td>{{$student->previous_class}}</td>
                            <td>{{$student->marks}}</td>
                            <td>{{$student->desired_class}}</td>
                            <td>{{$student->session}}</td>
                            <td>{{$student->catagory}}</td>
                            <td>{{$student->current_year}}</td>
                            <td>{{$student->address}}</td>
                            <td>{{$student->source}}</td>
                            <td class="text-nowrap">
                                <a href="{{ route('edit-student', $student->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal{{ $student->id }}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
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

@foreach ($students as $student)
    <div class="modal fade" id="deleteModal{{ $student->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Deletion</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete <strong>{{ $student->name }}</strong>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                    <form action="{{ route('delete-student', $student->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Yes, Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach

<script>
    document.getElementById('searchButton').addEventListener('click', function () {
        document.getElementById('filterForm').submit();
    });
    </script>
<script>
    function clearFilters() {
        window.location.href = "{{ route('filter-students', ['clear' => 'true']) }}";
    }
</script>

    
    