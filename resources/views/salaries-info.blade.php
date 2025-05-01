@extends('layout.main')
@section('layout.main')
<div class="container">
    
<form method="GET" action="{{ route('salaries-information') }}">
    <label for="month">Select Month:</label>
    <input type="month" name="month" id="month" value="{{ request('month', date('Y-m')) }}">
    <button type="submit" class="btn btn-primary btn-sm">Filter</button>
</form>

<table class="table table-bordered text-center align-middle">
    <thead class="table-primary">
        <tr>
            <th>Sr No.</th>
            <th>Teacher Name</th>
            <th>Final Paid</th>
            <th>Salary Month</th>
        </tr>
    </thead>
    <tbody>
        @php $index = 1; @endphp <!-- Define the index outside the loop -->
        @foreach($salary as $s)
        <tr>
            <td>{{ $index }}</td>
            <td>{{ $s->teacher_name }}</td>
            <td>{{ $s->final_payable }}</td>
            <td>{{ $s->salary_month }}</td>
        </tr>
        @php $index++; @endphp <!-- Increment index -->
        @endforeach
    </tbody>
</table>

</div>
@endsection
