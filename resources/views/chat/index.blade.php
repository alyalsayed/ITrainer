@extends('layouts.master')
@section('title', 'Chat Users')
@section('content')
<div class="container">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card chat-app">
                <div id="plist" class="people-list">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-search"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Search...">
                    </div>
                    <ul class="list-unstyled chat-list mt-2 mb-0">
                        @foreach($users as $user)
                        <li class="clearfix {{ $receiver && $receiver->id == $user->id ? 'active' : '' }}">
                            <a href="{{ route('chat.index', ['receiver_id' => $user->id]) }}">
                                <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : 'https://bootdey.com/img/Content/avatar/avatar1.png' }}" alt="avatar">
                                <div class="about">
                                    <div class="name">{{ $user->name }}</div>
                                    <div class="status">
                                        <i class="fa fa-circle {{ $user->last_seen && now()->diffInMinutes($user->last_seen) < 5 ? 'online' : 'offline' }}"></i>
                                        {{ $user->last_seen ? (now()->diffInMinutes($user->last_seen) < 5 ? 'online' : 'left ' . $user->last_seen->diffForHumans()) : 'No activity' }}
                                    </div>
                                </div>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
