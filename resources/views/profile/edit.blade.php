@extends('layouts.student_layout')
@section('content')
<div class="mx-auto max-w-screen-2xl p-4 md:px-6 2xl:px-10">
    <div class="mb-6">
        <h2 class="text-2xl font-bold mb-4">Profile Settings</h2>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Profile Information Section -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                @include('profile.partials.update-profile-information-form')
            </div>

            <!-- Password Update Section -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                @include('profile.partials.update-password-form')
            </div>

            <!-- Danger Zone -->
            <div class="lg:col-span-2">
                <div class="bg-red-50 p-6 rounded-lg shadow-md border-2 border-red-100">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

