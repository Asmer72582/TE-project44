@extends('layouts.student_layout')
@section('content')
<style>
    img{
        height: 30px;

       
    }
    @media (min-width: 1024px) {
        #form-container {
            position: sticky;
            top: 1rem;
        }
    }
</style>
<div class="mx-auto max-w-screen-2xl p-4 md:px-6 2xl:px-10 my-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-title-md2 font-bold text-black dark:text-white">
      Notifications
    </h2>

    <nav>
      <ol class="flex items-center gap-2">
        <li>
          <a class="font-medium" href="index.html">Dashboard /</a>
        </li>
        <li class="font-medium text-primary">Notifications</li>
      </ol>
    </nav>
</div>
    <div class="mx-auto  p-4 md:px-6 2xl:px-10 my-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div class="relative overflow-x-auto w-full">

          

            @foreach ($notifications as $notification)
            {{-- <div class="notifications">
                <div class="notification_title">Title: {{ $notification->notification_title }}</div>
                <div class="notification_message">Message: {{ $notification->notification_message }}</div>
                <div class="created_at">{{ $notification->created_at }}</div>
            </div> --}}

            {{-- <div class="p-4 mb-4 text-base text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
                <span class="font-bold text-lg">{{ $notification->notification_title }}</span> 
                <br><span>
                    {{ $notification->notification_message }}
                </span>
                <br>
                <span>
                    {{ $notification->created_at }}
                </span>

            </div> --}}
            <div
            class="rounded-sm  border-stroke bg-white   shadow-default dark:border-strokedark dark:bg-boxdark md:p-6 "
          >
            <div class="flex flex-col gap-7.5">
              <!-- Alerts Item -->
              <div
                class="flex w-full border-l-6 border-primary bg-primary bg-opacity-[10%] px-7 py-8 shadow-md dark:bg-[#1B1B24] dark:bg-opacity-30 md:p-9"
              >
                <div
                  class="mr-5 flex h-9 w-9 items-center justify-center rounded-lg bg-primary bg-opacity-30"
                >
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="19" fill="blue" class="bi bi-bell-fill" viewBox="0 0 16 16">
                    <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2m.995-14.901a1 1 0 1 0-1.99 0A5 5 0 0 0 3 6c0 1.098-.5 6-2 7h14c-1.5-1-2-5.902-2-7 0-2.42-1.72-4.44-4.005-4.901"/>
                  </svg>
                </div>
                <div class="w-full">
                  <h5 class="mb-3 text-lg font-bold text-primary">
                    {{ $notification->notification_title }}
                  </h5>
                  <p class="leading-relaxed text-primary">
                    {{ $notification->notification_message }}
                  </p>
                  <p>
                    {{ $notification->created_at }}
                  </p>
                </div>
              </div>

              <!-- Alerts Item -->
              

             
            </div>
          </div>
        @endforeach
           
        </div>

    </div>

@endsection