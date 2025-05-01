@extends('layout.main')
@section('layout.main')
<div class="container">
    @session('success')
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endsession
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="card col-md-6">
                    <div class="card-header">
                        <h4 class="card-title">Promote 1st year Students</h4>
                     </div>
                     <div class="card-body">
                        <p>Promote 1st year students to second year. Their class and their year will be incremented automatically.</p>
                        <form action="{{ route('promote-first-year') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Promote</button>
                        </form>
                     </div>
                </div>
                <div class="card col-md-6">
                    <div class="card-header">
                        <h4 class="card-title">Promote 2nd year Students</h4>
                     </div>
                     <div class="card-body">
                        <p>Promote 2nd year students to Passout Students. Their Status and their year will be incremented automatically.</p>
                        <form action="{{ route('promote-second-year') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Promote</button>
                        </form>
                     </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
