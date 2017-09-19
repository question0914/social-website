@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <form method="POST" action="{{ url('/selectrole') }}">
                        {{ csrf_field() }}
                        <p>Hello {{$users->name}}, Please choose your role</p>
                        <select id="myselect" name="role">
                            <option value="enduser">Enduser</option>
                            <option value="designer">Designer</option>
                            <option value="architect">Architect</option>
                        </select>
                        <input type="submit" name="idk" value="OK">
                        <input type="hidden" name="token" value="{{$users->token}}">
                        <input type="hidden" name="provider" value="{{$provider}}">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
