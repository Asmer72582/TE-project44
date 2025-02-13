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
      Tasks
    </h2>

    <nav>
      <ol class="flex items-center gap-2">
        <li>
          <a class="font-medium" href="index.html">Dashboard /</a>
        </li>
        <li class="font-medium text-primary">Tasks</li>
      </ol>
    </nav>
  </div>
<div class="min-h-screen flex  justify-center">



<div class="relative overflow-x-auto mx-10">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">


              <!-- Start coding here -->
              <div class="relative text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400  border">
                <div class="flex flex-col items-center justify-between p-4 space-y-3 md:flex-row md:space-y-0 md:space-x-4">
                  <div class="w-full md:w-1/2">
                   <h1 class="font-bold">Tasks</h1>
                  </div>
                  <div class="flex flex-col items-stretch justify-end flex-shrink-1 w-full space-y-2 md:w-auto md:flex-row md:space-y-0 md:items-center md:space-x-3">
                    
                    <div class="flex items-center w-full space-x-3 md:w-auto">
                      
                      <button id="filterDropdownButton"  class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg md:w-auto focus:outline-none hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button" 
                      onclick="printTable()">
                        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="w-4 h-4 mr-2 text-gray-400" viewbox="0 0 20 20" fill="currentColor">
                          <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                        </svg>
                        Export
                        <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                          <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                        </svg>
                      </button>
                      <!-- Dropdown menu -->
                      
                    </div>
                  </div>
                </div>



        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr class="border border-gray-300 px-4 py-2 text-left">
                <th scope="col" class=" border border-gray-300 px-4 py-2 text-left">
                   Group No
                </th>
                <th scope="col" class=" border border-gray-300 px-4 py-2 text-left">
                    Week no
                </th>
                <th scope="col" class=" border border-gray-300 px-4 py-2 text-left">
                    Task
                </th>
                <th scope="col" class=" border border-gray-300 px-4 py-2 text-left">
                    Due Date
                </th>
                <th scope="col" class=" border border-gray-300 px-4 py-2 text-left">
                    Completed dat
                </th>
                <th scope="col" class=" border border-gray-300 px-4 py-2 text-left">
                    Remark
                </th>
                <th scope="col" class=" border border-gray-300 px-4 py-2 text-left">
                    Early/Delay
                </th>
                <th scope="col" class=" border border-gray-300 px-4 py-2 text-left">
                    Folder
                </th>
                <th scope="col" class=" border border-gray-300 px-4 py-2 text-left">
                    Status
                </th>
            </tr>
        </thead>
        <tbody>
            {{-- <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    Apple MacBook Pro 17"
                </th>
                <td class="px-6 py-4">
                    Silver
                </td>
                <td class="px-6 py-4">
                    Laptop
                </td>
                <td class="px-6 py-4">
                    $2999
                </td>
            </tr> --}}
            @foreach ($tasks as $task)
            <tr>
                @if ($loop->index == 0)
                    <td rowspan="100" class="border border-gray-300 px-4 py-2 text-left">{{ $group_no }}</td>
                @endif
                <td class="border border-gray-300 px-4 py-2 text-left">{{ $task->week_no }}</td>
                <td class="border border-gray-300 px-4 py-2 text-left">{{ $task->task_title }}</td>
                <td class="border border-gray-300 px-4 py-2 text-left">{{ $task->task_due_date }}</td>
                <td class="border border-gray-300 px-4 py-2 text-left">{{ $task->task_completed_date }}</td>
                <td class="border border-gray-300 px-4 py-2 text-left">{{ $task->task_remark }}</td>
                <td  class="border border-gray-300 px-4 py-2 text-left">
                    @if ($task->task_completed_date && $task->task_completed_date > $task->task_due_date)
                        Late Submission by
                        {{ \Carbon\Carbon::parse($task->task_completed_date)->diffInDays($task->task_due_date) }}
                        days
                    @else
                        @if ($task->task_folder !== null)
                            Submitted
                        @else
                            Not Submitted
                        @endif
                    @endif
                </td>
                <td  class="border border-gray-300 px-4 py-2 text-left">

                    <select name="" id="task_folder" class="border border-gray-300 px-4 py-2 text-left" task_id={{ $task->task_id }} id="task_folder">
                        <option>Select</option>
                        @foreach ($folders as $folder)
                            <option value="{{ $folder->ff_id }}"
                                @if ($folder->ff_id == $task->task_folder) @selected(true) @endif>
                                {{ $folder->ff_title }}
                            </option>
                        @endforeach

                    </select>

                </td>
                <td  class="border border-gray-300 px-4 py-2 text-left">
                    @if ($task->task_completed_date == null || ($task->task_completed_date !== null && $task->task_status === null))
                        Pending <img src="{{ asset('img/pending.png') }}" height="20" alt="">
                    @elseif($task->task_status == 0)
                        Rejected <img src="{{ asset('img/rejected.png') }}" height="20" alt="">
                    @else
                        Accepted <img src="{{ asset('img/tick.png') }}" height="20" alt="">
                    @endif
                </td>
            </tr>
        @endforeach
            
        </tbody>
    </table>
</div>


<script defer>
    function printTable() {
        body.style.display = "none";
        window.print();
    }
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script defer>
        function printTable() {
            body.style.display = "none";
            window.print();
        }
    </script>

    <script>
        function TabDisplay(event) {
            let tab = document.getElementsByClassName("navigation-tab")[0];
            if (tab.style.display === 'flex') {
                tab.style.display = 'none';
            } else {
                tab.style.display = 'flex';
            }
        }

        $(document).ready(function() {
            $(document).on("change", "#task_folder", function() {
                let task_id = $(this).attr("task_id");
                let folder_id = $(this).val();
                @this.update_task_folder(task_id, folder_id);
            })
        })
    </script>


<script>
    window.addEventListener('tasks', event => {
    // alert(event.detail[0].message);

    Swal.fire({
        title: event.detail[0].title,
        text: event.detail[0].message,
        icon: event.detail[0].type
    });

})
</script>
 
</div>
@endsection