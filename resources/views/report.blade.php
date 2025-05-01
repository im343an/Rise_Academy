@extends('layout.main')

@section('layout.main')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Today's Report</h1>

    <!-- Absent Students -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Absent Students</div>
        <div class="card-body">
            @if($absentStudents->isEmpty())
                <p>No students are absent today.</p>
            @else
            <h6 class="text-danger font-weight-bold">
                <i class="fas fa-user-times"></i> {{ $absentCount }} Students are Absent Today
            </h6>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>Student Name</th>
                            <th>Father Name</th>
                            <th>Class</th>
                            <th>Gender</th>
                            <th>Catagory</th>
                            <th>Phone No.</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $SrNo = 1;
                        @endphp
                        @foreach($absentStudents as $student)
                            <tr>
                                <td>{{$SrNo ++}}</td>
                                <td>{{ $student->student->name }}</td>
                                <td>{{ $student->student->father_name }}</td>
                                <td>{{ $student->student->desired_class }}</td>
                                <td>{{ $student->student->gender }}</td>
                                <td>{{ $student->student->catagory }}</td>
                                <td>{{ $student->student->phone_number }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <!-- Fee Payments Today -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Fee Payments Today</div>
        <div class="card-body">
            @if($todayPayments->isEmpty())
                <p>No students paid fees today.</p>
            @else
            <h6 class="text-success font-weight-bold">
                <i class="fas fa-money-bill-wave"></i> {{ $paidstudents }} Students have paid their fees today
            </h6>
                            <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>Student Name</th>
                            <th>Class</th>
                            <th>Gender</th>
                            <th>Catagory</th>
                            <th>Amount Paid</th>
                            <th>Remaining Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $SrNo = 1;
                        @endphp
                        @foreach($todayPayments as $payment)
                            <tr>
                                <td>{{$SrNo ++}}</td>
                                <td>{{ $payment->student->name }}</td>
                                <td>{{ $payment->student->desired_class }}</td>
                                <td>{{ $payment->student->gender }}</td>
                                <td>{{ $payment->student->catagory }}</td>
                                <td>Rs. {{ number_format($payment->paid_amount) }}</td>
                                <td>Rs. {{ number_format($payment->remaining_amount) }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
            <h5 class="mt-3"><strong>Total Collection:</strong> Rs. {{ number_format($todayCollection) }}</h5>
        </div>
    </div>
</div>
@endsection
