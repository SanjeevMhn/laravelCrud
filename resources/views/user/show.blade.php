@extends('layouts.app')
@section('content')
   <div class="container">
       <div class="back-btn">
           <a href="{{route('user.index')}}" class="btn green">Back</a>
       </div>
        <h2 class="">User Info</h2>
        <div class="user-info-card margin-top">
            <div class="user-info-profile">
                <img src="{{asset('storage/images/'.$user->photo)}}" alt="Photo">
            </div>
            <div class="user-details">
                <h2 class="user-name">
                    {{$user->name}}
                </h2>
                <a href="{{$user->email}}" class="">{{$user->email}}</a>
                <p class="description">
                    {{$user->description}}
                </p>
            </div>
        </div>
    </div> 
@endsection