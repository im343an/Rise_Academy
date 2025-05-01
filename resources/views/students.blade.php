@extends('layout.main')

@section('layout.main')

<div class="container">
    <h3 class="mb-4">Students of {{ $class }}</h3>

    {{-- Month Filter Form --}}
    <form method="GET" class="mb-3">
        <label for="month">Select Month:</label>
        <input type="month" name="month" value="{{ request('month', date('Y-m')) }}" required>
        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
    </form>

    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Student Name</th>
                <th>Gender</th>
                <th>Paid Amount</th>
                <th>Remaining Amount</th>
                <th>Fee Status</th>
                <th>Update Fee Status</th>
            </tr>
        </thead>
        <tbody>
            @php
                $fullPaidCount = \App\Models\FeeSummary::where('class', $class)->where('month_year', request('month', date('Y-m')))->value('full_paid') ?? 0;
                $halfPaidCount = \App\Models\FeeSummary::where('class', $class)->where('month_year', request('month', date('Y-m')))->value('half_paid') ?? 0;
            @endphp

            @forelse($students as $index => $student)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ ucfirst($student->gender) }}</td>
                    <td>{{ $student->paid_amount }}</td>
                    <td>{{ $student->remaining_amount }}</td>
                    <td>{{ $student->fee_status }}</td>
                    <td id="actions-{{ $student->id }}">
                        <input type="radio" name="fee_status_{{ $student->id }}" value="Half Paid"
                            onclick="updateFeeStatus({{ $student->id }}, 'Half Paid')"> Half Paid
                        <input type="radio" name="fee_status_{{ $student->id }}" value="Full Paid"
                            onclick="updateFeeStatus({{ $student->id }}, 'Full Paid')"> Full Paid
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No students found for this class and month.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Summary Section --}}

<div class="mt-3">
    <h5>Summary</h5>
    <p>Full Paid: <strong id="fullPaidCount">{{ $fullPaidCount }}</strong></p>
    <p>Half Paid: <strong id="halfPaidCount">{{ $halfPaidCount }}</strong></p>
    <button class="btn btn-success btn-sm" onclick="saveSummary()">Save Summary</button>
    <button class="btn btn-danger btn-sm" onclick="resetSummary()">Reset Summary</button> <!-- Reset Button -->
</div>


<script>
    function updateFeeStatus(studentId, status) {
        document.getElementById(`actions-${studentId}`).innerHTML = 
            `<button class="btn ${status === 'Full Paid' ? 'btn-success' : 'btn-warning'} btn-sm">${status}</button>`;

        let fullPaidCount = parseInt(document.getElementById('fullPaidCount').innerText);
        let halfPaidCount = parseInt(document.getElementById('halfPaidCount').innerText);

        if (status === 'Full Paid') {
            fullPaidCount++;
        } else {
            halfPaidCount++;
        }

        document.getElementById('fullPaidCount').innerText = fullPaidCount;
        document.getElementById('halfPaidCount').innerText = halfPaidCount;
    }
</script>
<script>
    function updateFeeStatus(studentId, status) {
        document.getElementById(`actions-${studentId}`).innerHTML = 
            `<button class="btn ${status === 'Full Paid' ? 'btn-success' : 'btn-warning'} btn-sm">${status}</button>`;

        let fullPaidCount = parseInt(document.getElementById('fullPaidCount').innerText);
        let halfPaidCount = parseInt(document.getElementById('halfPaidCount').innerText);

        if (status === 'Full Paid') {
            fullPaidCount++;
        } else {
            halfPaidCount++;
        }

        document.getElementById('fullPaidCount').innerText = fullPaidCount;
        document.getElementById('halfPaidCount').innerText = halfPaidCount;
    }

</script>
<script>
    function saveSummary() {
        let fullPaid = parseInt(document.getElementById('fullPaidCount').innerText);
        let halfPaid = parseInt(document.getElementById('halfPaidCount').innerText);
        let className = "{{ $class }}";
        let monthYear = "{{ request('month', date('Y-m')) }}";

        fetch("{{ route('save.salary.summary') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                full_paid: fullPaid, // Make sure this matches backend
                half_paid: halfPaid,
                class: className,
                month_year: monthYear
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Summary Saved Successfully!");
            } else {
                alert("Failed to Save Summary!");
            }
        })
        .catch(error => {
            console.error("Error:", error);
        });
    }

    function fetchSummary() {
        let monthYear = "{{ request('month', date('Y-m')) }}";
        let className = "{{ $class }}";

        fetch("{{ route('get.salary.summary') }}?class=" + className + "&month_year=" + monthYear)
        .then(response => response.json())
        .then(data => {
            document.getElementById('fullPaidCount').innerText = data.full_paid ?? 0;
            document.getElementById('halfPaidCount').innerText = data.half_paid ?? 0;
        })
        .catch(error => {
            console.error("Error fetching summary:", error);
        });
    }

    document.addEventListener("DOMContentLoaded", function () {
        fetchSummary();
    });
    function resetSummary() {
    let className = "{{ $class }}";
    let monthYear = "{{ request('month', date('Y-m')) }}";

    fetch("{{ route('reset.salary.summary') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            class: className,
            month_year: monthYear
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Reset displayed counts
            document.getElementById('fullPaidCount').innerText = 0;
            document.getElementById('halfPaidCount').innerText = 0;

            // Reset all radio buttons
            document.querySelectorAll('input[type="radio"]').forEach(radio => {
                radio.checked = false;
            });

            // Reset button text (if converted)
            document.querySelectorAll('[id^="actions-"]').forEach(actionCell => {
                actionCell.innerHTML = `
                    <input type="radio" name="fee_status_${actionCell.id.split('-')[1]}" value="Half Paid"
                        onclick="updateFeeStatus(${actionCell.id.split('-')[1]}, 'Half Paid')"> Half Paid
                    <input type="radio" name="fee_status_${actionCell.id.split('-')[1]}" value="Full Paid"
                        onclick="updateFeeStatus(${actionCell.id.split('-')[1]}, 'Full Paid')"> Full Paid
                `;
            });

            alert("Summary Reset Successfully!");
        } else {
            alert("Failed to Reset Summary!");
        }
    })
    .catch(error => {
        console.error("Error:", error);
    });
}

</script>



@endsection
