@extends('layout.main')

@section('layout.main')

<div class="container">
    <h2 class="my-4">Enter Marks</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}</div>
    @endif

    <!-- Filters Form -->
    <form method="GET" action="{{ route('marks-form', [$year, $category, $gender]) }}" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <label for="year">Year</label>
                <select name="year" id="year" class="form-control">
                    @foreach(range(2025, 2035) as $yearOption)
                        <option value="{{ $yearOption }}" {{ $selectedYear == $yearOption ? 'selected' : '' }}>
                            {{ $yearOption }}
                        </option>
                    @endforeach
                </select>
            </div>
    
            <div class="col-md-3">
                <label for="month">Month</label>
                <select name="month" id="month" class="form-control">
                    @foreach(range(1, 12) as $monthOption)
                        <option value="{{ $monthOption }}" {{ $selectedMonth == $monthOption ? 'selected' : '' }}>
                            {{ date("F", mktime(0, 0, 0, $monthOption, 1)) }}
                        </option>
                    @endforeach
                </select>
            </div>
    
            <div class="col-md-3">
                <label for="week">Week</label>
                <select name="week" id="week" class="form-control">
                    @foreach(range(1, 52) as $weekOption)
                        <option value="Week {{ $weekOption }}" {{ $selectedWeek == "Week $weekOption" ? 'selected' : '' }}>
                            Week {{ $weekOption }}
                        </option>
                    @endforeach
                </select>
            </div>
    
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </div>
    </form>
    
    <form action="{{ route('submit-marks') }}" method="POST">
        @csrf
        <input type="hidden" name="year" value="{{ $selectedYear }}">
        <input type="hidden" name="month" value="{{ $selectedMonth }}">
        <input type="hidden" name="week" value="{{ $selectedWeek }}">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Student Name</th>
                    @foreach($selectedSubjects as $subject)
                        <th>{{ $subject }}</th>
                    @endforeach
                </tr>
                <tr>
                    <td><strong>Total Marks</strong></td>
                    @foreach($selectedSubjects as $subject)
                        @php
                            $firstMarksEntry = $marks->first();
                            $totalMarks = $firstMarksEntry && isset($firstMarksEntry->$subject) && str_contains($firstMarksEntry->$subject, '/')
                                ? explode('/', $firstMarksEntry->$subject)[1]
                                : old("total_marks.$subject", '');
                        @endphp
                        <td>
                            <input type="number" name="total_marks[{{ $subject }}]" class="form-control total-marks"
                                min="1" value="{{ $totalMarks }}">
                        </td>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                    <tr>
                        <td>{{ $student->name }}</td>
                        @foreach($selectedSubjects as $subject)
                            @php
                                $marksEntry = $marks[$student->id] ?? null;
                                $savedMarks = $marksEntry ? ($marksEntry->$subject ?? '') : '';
                                $obtainedMarks = str_contains($savedMarks, '/') ? explode('/', $savedMarks)[0] : '';
                            @endphp
                            <td>
                                <input type="text" name="marks[{{ $student->id }}][{{ $subject }}]" class="form-control"
                                    value="{{ old("marks.$student->id.$subject", $obtainedMarks) }}">
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Save Marks</button>
    </form>
</div>

@endsection

<script>
    function enableMarks(subject) {
        let totalMarksInput = document.querySelector(`input[name="total_marks[${subject}]"]`);
        let obtainedMarksInputs = document.querySelectorAll(`input[name^="marks"][name*="[${subject}]"]`);

        if (totalMarksInput.value) {
            obtainedMarksInputs.forEach(input => input.disabled = false);
        } else {
            obtainedMarksInputs.forEach(input => {
                input.disabled = true;
                input.value = '';  // Clear value if disabled
            });
        }
    }

    function updateMarks(input, subject, studentId) {
        let obtainedMarks = input.value;
        let totalMarksInput = document.querySelector(`input[name="total_marks[${subject}]"]`);
        let totalMarks = totalMarksInput ? totalMarksInput.value : '';

        let formattedValue = obtainedMarks && totalMarks ? obtainedMarks + '/' + totalMarks : '';
        
        let formattedInput = document.querySelector(`input[name="marks[${studentId}][${subject}]"]`);
        let formattedSpan = input.nextElementSibling;

        formattedInput.value = formattedValue;
        formattedSpan.innerText = formattedValue;
    }
</script>

<script>
    function enableMarks(subject) {
        let totalMarksInput = document.querySelector(`input[name="total_marks[${subject}]"]`);
        let obtainedMarksInputs = document.querySelectorAll(`input[name^="marks"][name*="[${subject}]"]`);

        if (totalMarksInput.value) {
            obtainedMarksInputs.forEach(input => input.disabled = false);
        } else {
            obtainedMarksInputs.forEach(input => {
                input.disabled = true;
                input.value = '';  // Clear value if disabled
            });
        }
    }

    function updateMarks(input, subject, studentId) {
        let obtainedMarks = input.value;
        let totalMarksInput = document.querySelector(`input[name="total_marks[${subject}]"]`);
        let totalMarks = totalMarksInput ? totalMarksInput.value : '';

        let formattedValue = obtainedMarks && totalMarks ? obtainedMarks + '/' + totalMarks : '';
        
        let formattedInput = document.querySelector(`input[name="marks[${studentId}][${subject}]"]`);
        let formattedSpan = input.nextElementSibling;

        formattedInput.value = formattedValue;
        formattedSpan.innerText = formattedValue;
    }
</script>
