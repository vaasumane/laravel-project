@extends('layout.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center py-5">
        <form class="col-lg-6" id="ProfileForm">
            <h1 class="text-center">Profile Setting</h1>
            <div class="row mb-3">
                <div class="col-sm-12">
                    <label for="inputEmail3" class="col-sm-2 col-form-label">First Name</label>
                    <input type="text" class="form-control" id="inputEmail3" name="first_name" value="<?php echo(isset($user) ? $user->first_name : ""); ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-12">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Last Name</label>
                    <input type="text" class="form-control" id="inputPassword3" name="last_name" value="<?php echo(isset($user) ? $user->last_name : ""); ?>">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-12">
                    <label for="user_image" class="col-sm-2 col-form-label">Profile</label>
                    <input type="file" class="form-control" id="user_image" name="user_image">
                </div>
                <div class="col-sm-12">
                   <img src="<?php echo(isset($user) ? config('app.url'). "storage/" . $user->user_image : "") ?>" >
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection