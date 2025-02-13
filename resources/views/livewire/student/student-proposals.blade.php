@extends('layouts.student_layout')
@section('content')
<style>
    @media (min-width: 1024px) {
        #form-container {
            position: sticky;
            top: 1rem;
        }
    }
    img{
        height: 25px;
        display: block;
  margin-left: auto;
  margin-right: auto;
  width: 50%;
    }
</style>
<div class="mx-auto max-w-screen-2xl p-4 md:px-6 2xl:px-10 my-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <h2 class="text-title-md2 font-bold text-black dark:text-white">
      Proposals

    @if ($show_table)
        <h1>hello</h1>
    @else
        <h3>hijjuji</h3>
    @endif


    </h2>

    <nav>
      <ol class="flex items-center gap-2">
        <li>
          <a class="font-medium" href="index.html">Dashboard /</a>
        </li>
        <li class="font-medium text-primary">Proposals</li>
      </ol>
    </nav>
  </div>
<div class="min-h-screen flex  justify-center">
    
    <div class="container  mx-auto px-6  shadow-lg rounded-lg flex flex-col md:flex-row gap-4">
        <!-- Form Section -->
        <div id="form-container" class="w-full md:w-1/3 p-4 bg-gray-50 shadow-md rounded-lg relative">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-primary">Add Proposal</h2>
                
            </div>
            <form class="space-y-4">
                <!-- Name Field -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        wire:model="proj_name"
                        class="mt-1 block w-full border-gray-300 py-5 px-2 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        placeholder="Enter name" 
                        required
                    >
                </div>

                <!-- Domain Field -->
                <div>
                    <label for="domain" class="block text-sm font-medium text-gray-700">Domain</label>
                    <input 
                        type="text" 
                        id="domain" 
                        name="domain" 
                        class="mt-1 block w-full border-gray-300 py-5 px-2  rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        placeholder="Enter domain" 
                        required
                        wire:model="proj_domain"
                    >
                </div>

                <!-- Description Field -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea 
                        id="description" 
                        name="description" 
                        class="mt-1 block w-full border-gray-300 py-5 px-2 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        rows="5" 
                        placeholder="Enter description" 
                        required
                        wire:model="proj_description"
                    ></textarea>
                </div>

              
                <input 
                type="button" 
                value="Submit"
                onclick="clearForm"
                class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                wire:click="submitProposal"
                >
            </form>
        </div>

        <!-- Table Section -->
        <div id="table-container" class="w-full md:w-2/3 p-4 bg-gray-50 shadow-md rounded-lg">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-primary ">Submitted Data </h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full border-collapse border border-gray-300">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="border border-gray-300 px-4 py-2 text-left">Serial No</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Name</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Description</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Domain</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Status</th>
                            <th class="border border-gray-300 px-4 py-2 text-left">Action</th>

                        </tr>

                    </thead>
                   
                    <tbody id="data-table-body">

                        <!-- Dynamic rows will be added here -->

                        @foreach ($proposals as $proposal)
                            <tr>
                                
                                <td class="border border-gray-300 px-4 py-2 text-left">{{$counter++}}</td>
                                <td class="border border-gray-300 px-4 py-2 text-left">{{ $proposal->proposal_name }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-left">{{ $proposal->proposal_description }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-left">{{ $proposal->proposal_domain }}</td>
                                <td class="border border-gray-300 px-4 py-2 text-right">
                                    @if ($proposal->is_accepted === 0)
                                        <img src="{{ asset('img/rejected.png') }}"  alt="">
                                    @elseif($proposal->is_accepted === 1)
                                        <img src="{{ asset('img/tick.png') }}"  alt="">
                                    @else
                                        <img src="{{ asset('img/pending.png') }}"  alt="">
                                    @endif
                                </td>
                                <td class="border border-gray-300 px-4 py-2 text-left">
                                    <button wire:click="deleteProposal({{ $proposal->proposal_id }})">
                                        X
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        {{-- <td colspan="5" id="ifNothing" class="border text-center font-bold text-xl	 border-gray-300 px-4 py-2">Nothing is added</td> --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

 
</div>
<script>
    window.addEventListener('proposal', event => {
        // alert(event.detail[0].message);

        Swal.fire({
            title: event.detail[0].title,
            text: event.detail[0].message,
            icon: event.detail[0].type
        });

    })
</script>
<script>
    function clearForm() {

    }
        function TabDisplay(event) {
            
            if ({{$show_table}}) {
                cl('h');
            } else {
                console.log("he;;p");
            }
        }

        TabDisplay()
</script>
@endsection