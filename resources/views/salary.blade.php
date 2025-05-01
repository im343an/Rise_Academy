@extends('layout.main')

@section('layout.main')

<div class="container">
    @session('success')
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endsession
    @if(isset($teacher))
        <h2>Salary Details for {{ ucwords(str_replace('-', ' ', $teacher)) }}</h2>
    @else
        <p>No teacher selected.</p>
    @endif

    {{-- Month Filter Form --}}
    <form method="GET" class="mb-3">
        <label for="month">Select Month:</label>
        <input type="month" name="month" id="selectedMonth" value="{{ request('month', date('Y-m')) }}" required>
        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
    </form>
    
    <table class="table table-bordered text-center">
        <thead class="thead-dark">
            <tr>
                <th>Classes</th>
                <th>Total Students</th>
                <th>Full Fee Paid Students</th>
                <th>Half Fee Paid Students</th>
                <th>View Students</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalStudents = 0;
                $totalFullFeePaid = 0;
                $totalHalfFeePaid = 0;
            @endphp
            
            @foreach($classes as $class)
                @php
                    $totalStudents += $class['total_students'];
                    $totalFullFeePaid += $class['full_fee_paid'];
                    $totalHalfFeePaid += $class['half_fee_paid'];
                @endphp
                <tr>
                    <td>{{ $class['name'] }}</td>
                    <td>{{ $class['total_students'] }}</td>
                    <td>{{ $class['full_fee_paid'] }}</td>
                    <td>{{ $class['half_fee_paid'] }}</td>
                    <td>
                        <a href="{{ route('salary.students', [
                            'teacher' => $teacher, 
                            'class' => rawurlencode($class['id']),
                            'month' => request('month', date('Y-m'))
                        ]) }}" 
                        class="btn btn-primary btn-sm">
                            View Students
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot class="bg-light font-weight-bold">
            <tr>
                <td>Total</td>
                <td>{{ $totalStudents }}</td>
                <td id="totalFullFeePaid">{{ $totalFullFeePaid }}</td>
                <td id="totalHalfFeePaid">{{ $totalHalfFeePaid }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    {{-- Multiplication Input Fields --}}
    <div class="mt-4 text-center">
        <input type="number" id="num1" class="form-control d-inline w-25" placeholder="Enter number of Students" oninput="calculateMultiplication()">
        <span class="mx-2">×</span>
        <input type="number" id="num2" class="form-control d-inline w-25" placeholder="Enter number" oninput="calculateMultiplication()">
        <br><br>
        <label><strong>Total Amount:</strong></label>
        <input type="text" id="result" class="form-control w-25 d-inline" readonly>
    </div>

    {{-- Additional Multiplication Fields --}}
    <div class="mt-4 text-center">
        <input type="text" id="totalAmount" class="form-control d-inline w-25" readonly placeholder="Auto-filled Total Amount">
        <span class="mx-2">×</span>
        <input type="number" id="multiplier" class="form-control d-inline w-25" placeholder="Enter number" oninput="calculateSecondMultiplication()">
        <br><br>
        <label><strong>Management Amount:</strong></label>
        <input type="text" id="finalResult" class="form-control w-25 d-inline" readonly>
    </div>

    {{-- Subtraction Input Fields --}}
    <div class="mt-4 text-center">
        <label><strong>Total Amount:</strong></label>
        <input type="text" id="finalTotalAmount" class="form-control d-inline w-25" readonly placeholder="Auto-filled Total Amount">
        <span class="mx-2">-</span>
        <input type="text" id="managementAmount" class="form-control d-inline w-25" readonly placeholder="Auto-filled from Management Amount">
        <br><br>
        <label><strong>Final Payable Amount:</strong></label>
        <input type="text" id="finalPayableAmount" class="form-control w-25 d-inline font-weight-bold bg-primary text-light" readonly>
    </div>

    {{-- Ensure Subject is Available --}}
    <form action="{{ route('salary.store') }}" method="POST">
        @csrf
        <input type="hidden" name="teacher_name" value="{{ ucwords(str_replace('-', ' ', $teacher)) }}">
        <input type="hidden" name="final_payable" id="hiddenFinalPayableAmount">
        <input type="hidden" name="salary_month" id="hiddenMonth">
        
        <button type="submit" class="btn btn-success">Save Salary</button>
    </form>

</div>

<script>
    function calculateMultiplication() {
        let num1 = parseFloat(document.getElementById("num1").value) || 0;
        let num2 = parseFloat(document.getElementById("num2").value) || 0;
        
        let result = num1 * num2;
        document.getElementById("result").value = result;
        document.getElementById("totalAmount").value = result;
        document.getElementById("finalTotalAmount").value = result;
        calculateSubtraction();
    }

    function calculateSecondMultiplication() {
        let totalAmount = parseFloat(document.getElementById("totalAmount").value) || 0;
        let multiplier = parseFloat(document.getElementById("multiplier").value) || 0;
        
        let managementAmount = totalAmount * multiplier;
        document.getElementById("finalResult").value = managementAmount;
        document.getElementById("managementAmount").value = managementAmount;
        calculateSubtraction();
    }

    function calculateSubtraction() {
        let finalTotalAmount = parseFloat(document.getElementById("finalTotalAmount").value) || 0;
        let managementAmount = parseFloat(document.getElementById("managementAmount").value) || 0;
        
        let finalPayable = finalTotalAmount - managementAmount;
        document.getElementById("finalPayableAmount").value = finalPayable;
        document.getElementById("hiddenFinalPayableAmount").value = finalPayable;
    }

    // Ensure salary_month is set correctly
    document.getElementById("hiddenMonth").value = document.getElementById("selectedMonth").value;

    // Auto-update hidden salary_month field when user selects a different month
    document.getElementById("selectedMonth").addEventListener("change", function() {
        document.getElementById("hiddenMonth").value = this.value;
    });
</script>

@endsection
