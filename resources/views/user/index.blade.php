@extends('layouts.app')
@section('content')
   <div class="container">
        @if(session('status'))
            <div class="success-msg">
                {{session('status')}}
            </div>
        @endif
        <h1 class="title">User CRUD</h1>
        <div class="create-user">
            <a href="{{route('user.create')}}" class="btn green">
                Add User
            </a>
        </div>
        <div class="search-group">
            <input type="text" name="search-user" id="" class="search-user" placeholder="Search User">
            <i class="bi bi-search"></i>
        </div> 
        <div class="user-list grid-col-4 margin-top">
            @foreach($users as $user) 
                <div class="user-card">
                    <div class="user-profile">
                        <img src="{{asset('storage/images/'.$user->photo)}}" alt="Photo">
                    </div>
                    <div class="user-details">
                        <h2 class="user-name">
                            {{$user->name}}
                        </h2>
                        <p class="user-email">
                            {{$user->email}}
                        </p>
                        <form action="{{route('user.destroy',$user->id)}}" method="post" class="flex">
                            @csrf
                            @method('DELETE')
                            <a href="{{route('user.show',$user->id)}}" class="btn-small blue">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{route('user.edit',$user->id)}}" class="btn-small orange">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button type="submit" class="btn-small red">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach  
        </div>
    </div>

   <script type="text/javascript">
        $.ajaxSetup({
            headers: ({'csrftoken':'{{csrf_token()}}'}) 
        });

        $(document).ready(function(){
            $('search-group search-user').on('keyup input',function(){
                let inputVal = $(this).val();
                let result = $('.user-list');

                $.ajax({
                    type: 'get',
                    url: '{{route('search')}}',
                    data: {'search': inputVal},
                    success: function(data){
                        $('.user-card').html(data);
                    }
                })
            })
        })
    </script>
 
@endsection