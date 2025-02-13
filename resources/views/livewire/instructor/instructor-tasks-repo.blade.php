@extends('layouts.instructor_layout')
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
<div class="mx-auto max-w-screen-2xl  p-4 md:px-6 2xl:px-10 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-title-md2 font-bold text-black dark:text-white">
        Repositories

    </h2>


    <nav>
      <ol class="flex items-center gap-2">
        <li>
          <a class="font-medium" href="index.html">Dashboard /</a>
        </li>
        <li class="font-medium text-primary">Repositories</li>
      </ol>
    </nav>
</div>
{{-- <div class="mx-auto max-w-screen-2xl  p-4 md:px-6 2xl:px-10 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    
</div> --}}

<div class="relative sm:rounded-lg border   max-w-screen-xl  mx-auto  w-full">
    <div class="flex flex-col items-center  justify-between p-4 space-y-1 md:flex-row md:space-y-1 md:space-x-1">
      <div class=" w-1/2 mt-6  ">
        <form class="flex items-center gap-5">
          <label for="simple-search" class="sr-only">Enter Folder Name</label>
          <div class="relative w-full">
            
            <input type="text" id="simple-search" wire:model="folder_name" class="block w-full p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Enter Folder Name..." required="">
            
          </div>
          <button type="button" wire:click="create_folder" class="flex w-1/2 items-center justify-center px-4 py-2 text-sm font-medium text-white  rounded-lg bg-primary hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
            <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
            </svg>
            Add Folder
          </button>
        </form>
      </div>
      <div class="">
        
        
        <form wire:submit.prevent="uploadFile"  enctype="multipart/form-data" class="upload-file-section flex items-center gap-5  flex-col   mt-6 justify-end  flex-shrink-0  space-y-2 md:w-auto md:flex-row md:space-y-0 md:items-center md:space-x-3">
          <input type="file" name="" wire:model="files" style="display: block;" class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white  rounded-lg bg-primary hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800" multiple id="selectImage" required>
          {{-- <input type="submit" value="Upload" class="upload-btn btn"> --}}
      
        {{-- <label for="selectImage" type="button" class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white  rounded-lg bg-primary hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
          <svg class="h-5.5 w-5.5" fill="currentColor" viewbox="0 0 384 512" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M224 136V0H24C10.7 0 0 10.7 0 24v464c0 13.3 10.7 24 24 24h336c13.3 0 24-10.7 24-24V160H248c-13.2 0-24-10.8-24-24zm65.2 216H224v80c0 8.8-7.2 16-16 16h-32c-8.8 0-16-7.2-16-16v-80H94.8c-14.3 0-21.4-17.3-11.3-27.4l96.4-95.7c6.7-6.6 17.4-6.6 24 0l96.4 95.7c10.2 10.1 3 27.4-11.3 27.4zM377 105L279.1 7c-4.5-4.5-10.6-7-17-7H256v128h128v-6.1c0-6.3-2.5-12.4-7-16.9z"/>
          </svg>

        </label> --}}
        <button  type="submit" class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white  rounded-lg bg-primary hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
          <svg class="h-3.5 w-3.5" fill="currentColor" viewbox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
            <path d="M288 109.3L288 352c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-242.7-73.4 73.4c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3l128-128c12.5-12.5 32.8-12.5 45.3 0l128 128c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L288 109.3zM64 352l128 0c0 35.3 28.7 64 64 64s64-28.7 64-64l128 0c35.3 0 64 28.7 64 64l0 32c0 35.3-28.7 64-64 64L64 512c-35.3 0-64-28.7-64-64l0-32c0-35.3 28.7-64 64-64zM432 456a24 24 0 1 0 0-48 24 24 0 1 0 0 48z"/>
          </svg>
          Upload
        </button>
      </form>

        
      </div>
      
    </div>
  </div>
    <div class="mx-auto  p-4 md:px-6 2xl:px-10 mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
       
        
        <div class="relative overflow-x-auto w-full grid sm:grid-cols-3 xl:grid-cols-6">
{{-- 
            <div class="bg-gray-100 relative overflow-x-auto w-full">
                header
            </div> --}}
            
            @if ($current_folder !== null)
            <a href="{{route('instructor.tasks')}}" class="w-50 mb-4 max-w-sm bg-white border text-center inline-block align-middle border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">

                    <- Go Back

            </a>
        @endif


@foreach ($ffs as $ff)
@if ($ff->is_folder)
            <div class="w-50 mb-4 max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700"  >
                <div class="flex justify-end px-4 pt-4">
                    <button id="dropdownButton" data-dropdown-toggle="dropdown" class="inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5" type="button">
                        <span class="sr-only">Open dropdown</span>
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 3">
                            <path d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"/>
                        </svg>
                    </button>
                    <!-- Dropdown menu -->
                    <div id="dropdown" class="z-10 hidden text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                        <ul class="py-2" aria-labelledby="dropdownButton">
                        <li>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Edit</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Export Data</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</a>
                        </li>
                        </ul>
                    </div>
                </div>
                <div class="flex flex-col items-center pb-10">
                    <img class="w-24 h-24 mb-3  shadow-lg" wire:click="openFolder({{ $ff->ff_id }})" src="{{ asset('img/folder.png') }}" alt="Bonnie image"/>
                    <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ $ff->ff_title }}</h5>
                    <span class="text-sm text-gray-500 dark:text-gray-400"> {{ $ff->created_at }}</span>
                    <div class="flex mt-4 md:mt-6">
                        {{-- <a href="#" class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" wire:click="openFolder({{ $ff->ff_id }})">Open</a> --}}
                        {{-- <a href="#" class="py-2 px-4 ms-2 text-sm font-medium  focus:outline-none bg-red-600 text-white rounded-lg border border-gray-200 hover:bg-gray-100  focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" wire:click="deleteFF({{ $ff->ff_id }})">Delete</a> --}}
                        <a href="#" class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" wire:click="openFolder({{ $ff->sub_ff_of }})">Download {{ $ff->sub_ff_of }}</a>

                    </div>
                </div>
            </div>
@else
            <div class="w-50 mb-4 max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700" >
                <div class="flex justify-end px-4 pt-4">
                    <button id="dropdownButton" data-dropdown-toggle="dropdown" class="inline-block text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-1.5" type="button">
                        <span class="sr-only">Open dropdown</span>
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 3">
                            <path d="M2 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Zm6.041 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM14 0a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3Z"/>
                        </svg>
                    </button>
                    <!-- Dropdown menu -->
                    <div id="dropdown" class="z-10 hidden text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                        <ul class="py-2" aria-labelledby="dropdownButton">
                        <li>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Edit</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Export Data</a>
                        </li>
                        <li>
                            <a href="#" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</a>
                        </li>
                        </ul>
                    </div>
                </div>
                <div class="flex flex-col items-center pb-10">
                    <img class="w-24 h-24 mb-3  shadow-lg"   src="{{ asset('img/file.png') }}" alt="fileIMG"/>
                    <h5 class="mb-1 text-xl font-medium text-gray-900 dark:text-white">{{ $ff->ff_title }}</h5>
                    <span class="text-sm text-gray-500 dark:text-gray-400"> {{ $ff->created_at }}</span>
                    {{-- <img src=`{{ storage_path('') }}` alt="" srcset=""> --}}
                    {{-- {{ $ff->file_path }} --}}
                    <img src="{{storage_path("app/public/files/cQwueCHzsDIyZ4zWejkj4mxnUQDWkIxoAYuFWygN.jpg" )}}" alt="img" srcset="">
                    <div class="flex mt-4 md:mt-6">
                        <a href="#" class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" wire:click="DownloadFile({{ $ff->ff_id }})">Download</a>
                        <a href="#" class="py-2 px-4 ms-2 text-sm font-medium  focus:outline-none bg-red-600 text-white rounded-lg border border-gray-200 hover:bg-red-200  focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" wire:click="deleteFF({{ $ff->ff_id }})">Delete</a>
                    </div>
                </div>
            </div>
                
@endif
@endforeach


        
           

        </div>

    </div>

    <script>
        window.addEventListener('repo', event => {
        // alert(event.detail[0].message);

        Swal.fire({
            title: event.detail[0].title,
            text: event.detail[0].message,
            icon: event.detail[0].type
        });

    })
    </script>

@endsection

