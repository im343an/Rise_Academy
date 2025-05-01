@extends('layout.main')
@section('layout.main')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- Admission Form Starts -->
<div class="container-fluid">
    <h3>Add New Student</h3>
</div>
<div class="admission">
    <form action="{{ route('new-student') }}" method="POST">
        @csrf
        <div class="row form-row">
            <div class="col-md-3 mb-3">
                <label for="name">Name <span style="color: red;">*</span></label>
                <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}">
            </div>
            <div class="col-md-3 mb-3">
                <label for="father_name">Father's Name <span style="color: red;">*</span></label>
                <input type="text" name="father_name" class="form-control" id="father_name" value="{{ old('father_name') }}">
            </div>
            <div class="col-md-3 mb-3">
                <label for="phone_number">Phone Number <span style="color: red;">*</span></label>
                <input type="number" name="phone_number" class="form-control" id="phone_number" value="{{ old('phone_number') }}">
            </div>
            <div class="col-md-3 mb-3">
                <label for="father_profession">Father Profession <span style="color: red;">*</span></label>
                <input type="text" name="father_profession" class="form-control" id="father_profession" value="{{ old('father_profession') }}">
            </div>
        </div>
        <div class="row form-row">
            <div class="col-md-3 mb-3">
                <label for="current_year">Current Year <span style="color: red;">*</span></label>
                <select class="form-control" name="current_year" id="current_year">
                    <option value="" selected>Select Current Year</option>
                    @for ($year = now()->year; $year <= now()->year + 5; $year++)
                        <option value="{{ $year }}" {{ old('current_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label for="previous_school">Previous School Name <span style="color: red;">*</span></label>
                <input type="text" name="previous_school" class="form-control" id="previous_school" value="{{ old('previous_school') }}">
            </div>
            <div class="col-md-3 mb-3">
                <label for="gender">Gender <span style="color: red;">*</span></label>
                <select class="form-control" name="gender" id="gender">
                    <option value="" selected>Select one option</option>
                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label for="session">Session <span style="color: red;">*</span></label>
                <select class="form-control" name="session" id="session">
                    <option value="" selected>Select Session</option>
                    @foreach (["2025-2027", "2026-2028", "2027-2029", "2028-2030", "2029-2031", "2030-2032", "2031-2033", "2032-2034"] as $sess)
                        <option value="{{ $sess }}" {{ old('session') == $sess ? 'selected' : '' }}>{{ $sess }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row form-row">
            <div class="col-md-3 mb-3">
                <label for="previous_class">Previous Class <span style="color: red;">*</span></label>
                <select class="form-control" name="previous_class" id="previous_class">
                    <option value="" selected>Select one option</option>
                    <option value="matric" {{ old('previous_class') == 'matric' ? 'selected' : '' }}>Matric</option>
                    <option value="inter1stYear" {{ old('previous_class') == 'inter1stYear' ? 'selected' : '' }}>Inter 1st Year</option>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label for="marks">Marks <span style="color: red;">*</span></label>
                <input type="number" name="marks" class="form-control" id="marks" value="{{ old('marks') }}">
            </div>
            <div class="col-md-3 mb-3">
                <label for="desired_class">Desired Class <span style="color: red;">*</span></label>
                <select class="form-control" name="desired_class" id="desired_class">
                    <option value="" selected>Select one option</option>
                    <option value="1styear" {{ old('desired_class') == '1styear' ? 'selected' : '' }}>1st Year</option>
                    <option value="2ndyear" {{ old('desired_class') == '2ndyear' ? 'selected' : '' }}>2nd Year</option>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label for="catagory">Catagory <span style="color: red;">*</span></label>
                <select class="form-control" name="catagory" id="catagory">
                    <option value="" selected>Select one option</option>
                    <option value="fscPreMedical" {{ old('catagory') == 'fscPreMedical' ? 'selected' : '' }}>F.Sc Pre-Medical</option>
                    <option value="fscPreEngineering" {{ old('catagory') == 'fscPreEngineering' ? 'selected' : '' }}>F.Sc Pre-Engineering</option>
                    <option value="ics" {{ old('catagory') == 'ics' ? 'selected' : '' }}>ICS</option>
                    <option value="faIt" {{ old('catagory') == 'faIt' ? 'selected' : '' }}>FA-IT</option>
                </select>
            </div>
        </div>
        <div class="row form-row">
            <div class="col-md-6 mb-3">
                <label for="address">Address <span style="color: red;">*</span></label>
                <textarea class="form-control" name="address" id="address" rows="4">{{ old('address') }}</textarea>
            </div>
            <div class="col-md-6 mb-3">
                <label for="source">How did you hear about Rise Academy? <span style="color: red;">*</span></label>
                <textarea class="form-control" name="source" id="source" rows="4">{{ old('source') }}</textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection

