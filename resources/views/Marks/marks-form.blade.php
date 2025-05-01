@extends('layout.main')
@section('layout.main')
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <h3>Enter Marks</h3>
                </div>
                <div class="admission">
                    <form>
                        <div class="row form-row">
                            <div class="col-md-4 mb-3">
                                <label for="biology" class="form-label">Biology</label>
                                <input type="number" class="form-control" id="biology">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="chemistry" class="form-label">Chemistry</label>
                                <input type="number" class="form-control" id="chemistry">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="physics" class="form-label">Physics</label>
                                <input type="number" class="form-control" id="physics">
                            </div>
                        </div>
                        <div class="row form-row">
                            <div class="col-md-4 mb-3">
                                <label for="math" class="form-label">Math</label>
                                <input type="number" class="form-control" id="math">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="computer" class="form-label">Computer</label>
                                <input type="number" class="form-control" id="computer">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="english" class="form-label">English</label>
                                <input type="number" class="form-control" id="english">
                            </div>
                        </div>
                        <div class="row form-row">
                            <div class="col-md-4 mb-3">
                                <label for="urdu" class="form-label">Urdu</label>
                                <input type="number" class="form-control" id="urdu">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="pak-study" class="form-label">Pak Study</label>
                                <input type="number" class="form-control" id="pak-study">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="islamiat" class="form-label">Islamiat</label>
                                <input type="number" class="form-control" id="islamiat">
                            </div>
                        </div>
                        <div class="row form-row">
                            <div class="col-md-4 mb-3">
                                <label for="education" class="form-label">Education</label>
                                <input type="number" class="form-control" id="education">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="sociology" class="form-label">Sociology</label>
                                <input type="number" class="form-control" id="sociology">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="health-physical" class="form-label">Health and Physical Education</label>
                                <input type="number" class="form-control" id="health-physical">
                            </div>
                        </div>
                        <div class="row form-row">
                            <div class="col-md-4 mb-3">
                                <label for="economics" class="form-label">Economics</label>
                                <input type="number" class="form-control" id="economics">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                 </div>
@endsection