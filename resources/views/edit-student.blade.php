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
    <h3>Edit Student</h3>
</div>
<div class="admission">
    <form action="{{ route('update-student', $student->id) }}" method="POST">
        @csrf
        <div class="row form-row">
            <div class="col-md-3 mb-3">
                <label for="name">Name <span style="color: red;">*</span></label>
                <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $student->name) }}">
            </div>
            <div class="col-md-3 mb-3">
                <label for="father_name">Father's Name <span style="color: red;">*</span></label>
                <input type="text" name="father_name" class="form-control" id="father_name" value="{{ old('father_name', $student->father_name) }}">
            </div>
            <div class="col-md-3 mb-3">
                <label for="phone_number">Phone Number <span style="color: red;">*</span></label>
                <input type="number" name="phone_number" class="form-control" id="phone_number" value="{{ old('phone_number', $student->phone_number) }}">
            </div>
            <div class="col-md-3 mb-3">
                <label for="father_profession">Father Profession <span style="color: red;">*</span></label>
                <input type="text" name="father_profession" class="form-control" id="father_profession" value="{{ old('father_profession', $student->father_profession) }}">
            </div>
        </div>
        <div class="row form-row">
            <div class="col-md-3 mb-3">
                <label for="year">Year <span style="color: red;">*</span></label>
                <input type="text" name="current_year" class="form-control" id="year" value="{{ old('current_year', $student->current_year ?? '') }}">
            </div>
            <div class="col-md-3 mb-3">
                <label for="session">Session <span style="color: red;">*</span></label>
                <input type="text" name="session" class="form-control" id="session" value="{{ old('session', $student->session) }}">
            </div>
            <div class="col-md-3 mb-3">
                <label for="previous_school">Previous School Name <span style="color: red;">*</span></label>
                <input type="text" name="previous_school" class="form-control" id="previous_school" value="{{ old('previous_school', $student->previous_school) }}">
            </div>
            <div class="col-md-3 mb-3">
                <label for="gender">Gender <span style="color: red;">*</span></label>
                <select class="form-control" name="gender" id="gender">
                    <option value="" selected>Select one option</option>
                    <option value="male" {{ old('gender', $student->gender) == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('gender', $student->gender) == 'female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>
        </div>
        <div class="row form-row">
            <div class="col-md-3 mb-3">
                <label for="previous_class">Previous Class <span style="color: red;">*</span></label>
                <select class="form-control" name="previous_class" id="previous_class">
                    <option value="" selected>Select one option</option>
                    <option value="matric" {{ old('previous_class', $student->previous_class) == 'matric' ? 'selected' : '' }}>Matric</option>
                    <option value="inter1stYear" {{ old('previous_class', $student->previous_class) == 'inter1stYear' ? 'selected' : '' }}>Inter 1st Year</option>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label for="marks">Marks <span style="color: red;">*</span></label>
                <input type="number" name="marks" class="form-control" id="marks" value="{{ old('marks', $student->marks) }}">
            </div>
            <div class="col-md-3 mb-3">
                <label for="desired_class">Desired Class <span style="color: red;">*</span></label>
                <select class="form-control" name="desired_class" id="desired_class">
                    <option value="" selected>Select one option</option>
                    <option value="1styear" {{ old('desired_class', $student->desired_class) == '1styear' ? 'selected' : '' }}>1st Year</option>
                    <option value="2ndyear" {{ old('desired_class', $student->desired_class) == '2ndyear' ? 'selected' : '' }}>2nd Year</option>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label for="catagory">Category <span style="color: red;">*</span></label>
                <select class="form-control" name="catagory" id="catagory">
                    <option value="" selected>Select one option</option>
                    <option value="fscPreMedical" {{ old('catagory', $student->catagory) == 'fscPreMedical' ? 'selected' : '' }}>F.Sc Pre-Medical</option>
                    <option value="fscPreEngineering" {{ old('catagory', $student->catagory) == 'fscPreEngineering' ? 'selected' : '' }}>F.Sc Pre-Engineering</option>
                    <option value="ics" {{ old('catagory', $student->catagory) == 'ics' ? 'selected' : '' }}>ICS</option>
                    <option value="faIt" {{ old('catagory', $student->catagory) == 'faIt' ? 'selected' : '' }}>FA-IT</option>
                </select>
            </div>
        </div>
        <div class="row form-row">
            <div class="col-md-6 mb-3">
                <label for="address">Address <span style="color: red;">*</span></label>
                <textarea class="form-control" name="address" id="address" rows="4">{{ old('address', $student->address) }}</textarea>
            </div>
            <div class="col-md-6 mb-3">
                <label for="source">How did you hear about Rise Academy? <span style="color: red;">*</span></label>
                <textarea class="form-control" name="source" id="source" rows="4">{{ old('source', $student->source) }}</textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
