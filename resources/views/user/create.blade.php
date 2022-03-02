@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="back-btn">
            <a href="{{route('user.index')}}" class="btn green">Back</a>
        </div>
        <form enctype="multipart/form-data" action="{{route('user.store')}}" method="post" class="user-create-form margin-top">
            @csrf
            <div class="form-group">
                <label for="name" class="form-label">User Name</label>
                <input type="text" name="name" id="" class="form-input @error('name') error-border @enderror" placeholder="Enter user name">
                @error('name')
                    <p class="error-msg">{{$message}}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="email" class="form-label">User Email</label>
                <input type="email" name="email" id="" class="form-input @error('email') error-border @enderror" placeholder="Enter user email">
                @error('email')
                    <p class="error-msg">{{$message}}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="photo" class="form-label">User Photo</label>
                <input type="file" name="photo" id="" class="form-input @error('photo') error-border @enderror" placeholder="Add User Photo">
                @error('photo')
                    <p class="error-msg">{{$message}}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="desc" class="form-label">User Description</label>
                <textarea name="desc" id="" cols="30" rows="10" class="form-input @error('desc') error-border @enderror" placeholder="Add User Description"></textarea>
                @error('desc')
                    <p class="error-msg">{{$message}}</p>
                @enderror
            </div>
            <div class="form-group">
                <button type="submit" class="btn green">Submit</button>
                <button type="reset" class="btn red">Cancel</button>
            </div>
        </form>
    </div>
@endsection