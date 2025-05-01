@extends('layout.main')
@section('layout.main')

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Attendance</h1>
        <div id="datetime" class="text-gray-700 font-weight-bold"></div>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
        </a>
    </div>
</div>

<script>
    function updateDateTime() {
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        document.getElementById('datetime').textContent = now.toLocaleDateString('en-US', options) + ", " + now.toLocaleTimeString();
    }
    setInterval(updateDateTime, 1000);
    updateDateTime();
</script>

@session('success')
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endsession

<div class="container mt-4">
    <!-- Attendance Summary and Progress Bar in One Row -->
    <div class="d-flex align-items-center justify-content-between flex-wrap mb-3">
        <div class="d-flex justify-content-around flex-wrap" style="gap: 6px;">
            <div class="card text-white bg-success text-center" style="width: 6rem; height: 3rem; font-size: 0.7rem; padding: 4px;">
                <h6 class="m-0"><i class="fas fa-user-check"></i> Present</h6>
                <h5 class="m-0" id="presentCount">0</h5>
            </div>
            <div class="card text-white bg-danger text-center" style="width: 6rem; height: 3rem; font-size: 0.7rem; padding: 4px;">
                <h6 class="m-0"><i class="fas fa-user-times"></i> Absent</h6>
                <h5 class="m-0" id="absentCount">0</h5>
            </div>
            <div class="card text-white bg-primary text-center" style="width: 6rem; height: 3rem; font-size: 0.7rem; padding: 4px;">
                <h6 class="m-0"><i class="fas fa-wallet"></i> Paid</h6>
                <h5 class="m-0" id="paidCount">0</h5>
            </div>
            <div class="card text-white bg-warning text-center" style="width: 6rem; height: 3rem; font-size: 0.7rem; padding: 4px;">
                <h6 class="m-0"><i class="fas fa-exclamation-triangle"></i> Unpaid</h6>
                <h5 class="m-0" id="unpaidCount">0</h5>
            </div>
        </div>

        <div class="progress" style="width: 50%; height: 15px;">
            <div id="attendanceProgress" class="progress-bar progress-bar-striped progress-bar-animated bg-success" 
                 role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                0% Completed
            </div>
        </div>
    </div>

    <form action="{{ route('attendance.store') }}" method="POST">
        @csrf
            <table class="table table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Attendance</th>
                    <th>Fee Status</th>
                    <th>Paid (Rs.)</th>
                    <th>Remaining (Rs.)</th>
                    <th>Date of Paying Fee</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                <tr>
                    <td>{{ $student->id }}</td>
                    <td>{{ $student->name }}</td>
                    <td>
                        <div class="d-flex flex-column">
                            <div>
                                <input type="radio" name="attendance[{{ $student->id }}]" value="Present" required>
                                <label>Present</label>
                            </div>
                            <div>
                                <input type="radio" name="attendance[{{ $student->id }}]" value="Absent" required>
                                <label>Absent</label>
                            </div>
                        </div>
                    </td>
                    <td>
                        @php
                            $studentFee = $fees[$student->id] ?? null;
                        @endphp
                        @if ($studentFee && $studentFee->status === 'Paid')
                            <span class="badge bg-success p-2 text-center m-3">Paid</span>
                            <br>
                        @else
                        <div class="d-flex flex-column">
                            <div>
                                <input type="radio" name="fee_status[{{ $student->id }}]" value="Paid">
                                <label>Paid</label>
                            </div>
                            <div>
                                <input type="radio" name="fee_status[{{ $student->id }}]" value="Unpaid" checked>
                                <label>Unpaid</label>
                            </div>
                        </div>
                                                @endif
                    </td>
                    <td>
                        <input type="number" name="paid[{{ $student->id }}]" value="{{ $studentFee->paid_amount ?? 0 }}" class="form-control">
                    </td>
                    <td>
                        <input type="number" name="remaining[{{ $student->id }}]" value="{{ $studentFee->remaining_amount ?? 0 }}" class="form-control">
                    </td>
                    <td>
                        <input type="date" name="fee_date[{{ $student->id }}]" value="{{ $studentFee->last_paid_date ?? '' }}" class="form-control">
                    </td>
                </tr>
                @endforeach
                                                                </tbody>
        </table>
        <div class="text-center mt-3">
            <button type="submit" class="btn btn-primary">Submit Attendance</button>
        </div>
    </form>
</div>
@endsection
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const attendanceRadios = document.querySelectorAll("input[name^='attendance']");
        const feeRadios = document.querySelectorAll("input[name^='fee_status']");
        const paidInputs = document.querySelectorAll("input[name^='paid']");
    
        const progressBar = document.getElementById("attendanceProgress");
        const presentCount = document.getElementById("presentCount");
        const absentCount = document.getElementById("absentCount");
        const paidCount = document.getElementById("paidCount");
        const unpaidCount = document.getElementById("unpaidCount");
    
        const totalStudents = document.querySelectorAll("tbody tr").length;
        unpaidCount.textContent = totalStudents; 
    
        function updateSummary() {
            let present = 0, absent = 0, paid = 0, unpaid = 0;
    
            document.querySelectorAll("input[name^='attendance']:checked").forEach(input => {
                if (input.value === "Present") present++;
                if (input.value === "Absent") absent++;
            });
    
            document.querySelectorAll("input[name^='fee_status']:checked").forEach(input => {
                if (input.value === "Paid") paid++;
                if (input.value === "Unpaid") unpaid++;
            });
    
            presentCount.textContent = present;
            absentCount.textContent = absent;
            paidCount.textContent = paid;
            unpaidCount.textContent = unpaid;
    
            // Update Progress Bar
            const markedStudents = present + absent;
            const percentage = (markedStudents / totalStudents) * 100;
            progressBar.style.width = percentage + "%";
            progressBar.textContent = Math.round(percentage) + "% Completed";
        }
    
        function handlePaidInputChange() {
            paidInputs.forEach(input => {
                input.addEventListener("input", function () {
                    const row = input.closest("tr");
                    const paidRadio = row.querySelector("input[value='Paid']");
                    const unpaidRadio = row.querySelector("input[value='Unpaid']");
    
                    if (parseInt(input.value) > 0) {
                        paidRadio.checked = true;
                    } else {
                        unpaidRadio.checked = true;
                    }
                    updateSummary();
                });
            });
        }
    
        // Count existing "Paid" students on page load
        function countInitialPaidStudents() {
            let initialPaidCount = 0;
            document.querySelectorAll("span.badge.bg-success").forEach(() => {
                initialPaidCount++;
            });
    
            paidCount.textContent = initialPaidCount;
            unpaidCount.textContent = totalStudents - initialPaidCount;
        }
    
        // Attach event listeners
        attendanceRadios.forEach(radio => radio.addEventListener("change", updateSummary));
        feeRadios.forEach(radio => radio.addEventListener("change", updateSummary));
    
        handlePaidInputChange();
        countInitialPaidStudents(); // Initialize the count for Paid students
    });
    </script>   

