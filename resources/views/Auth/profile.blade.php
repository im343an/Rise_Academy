@extends('layout.main')

@section('layout.main')
<div class="container mt-5">
    <div class="container mt-5">
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif(session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    <div class="row justify-content-center">
        <!-- Picture Card -->
        <div class="col-md-5">
            <div class="card text-center p-3">
                <div class="card-head">
                    <h4 class="card-title">Profile Picture</h4>
                </div>
                <div class="card-body">
                    <!-- Avatar -->
                    <img src="{{ $user->profile_picture ? asset('storage/'. $user->profile_picture) : asset('user.png') }}" 
                    alt="User Avatar" 
                    class="rounded-circle img-fluid" 
                    style="width: 150px; height: 150px;">                    
                    <!-- Upload Picture Button -->
                    <form action="{{route('updatepicture')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mt-3">
                            <input type="file" name="image" type="image/*" class="form-control">
                            <button type="submit" class="btn btn-primary mt-2">Upload Picture</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Information Card -->
        <div class="col-md-5">
            <div class="card p-3">
                <div class="card-head">
                    <h4 class="card-title">Edit Information</h4>
                </div>
                <div class="card-body">
                    <form action="{{route('updateprofileinfo')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">First Name</label>
                            <input type="text" name="firstname" value="{{ $user->firstname }}" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">First Name</label>
                            <input type="text" name="lastname" value="{{ $user->lastname }}" class="form-control" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current password">
                        </div>
                        
                        <button type="submit" class="btn btn-success">Update Information</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
