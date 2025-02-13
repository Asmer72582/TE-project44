<div>

    <html>

    <head>
        <link rel="stylesheet" href="{{ asset('css/Homepage.css') }}">
        <link rel="stylesheet" href="{{ asset('css/Tasks.css') }}">

        <script src="https://www.gstatic.com/charts/loader.js"></script>
    </head>

    <body>
        <div class="header-box">
            {{-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                class="navigation-icon" onclick="TabDisplay(event)">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg> --}}
            <span class="heading">PROPOSALS 
            </span>

            

            {{-- @if ($show_table) --}}
               
            {{-- @endif --}}


        </div>
        @include('nav.student-nav')
        <form class="proposal-container">

            <div class="proposal-2">
                <h2 class="proposal-2-heading">ADD PROPOSAL</h2>
                <p class="proposal-2-name">Name</p>
                <input class="proposal-2-input-1 form-control" type="text" maxlength="50" size="50"
                    wire:model="proj_name" placeholder="Project Name" required>
                <br class="line-height">
                <p class="proposal-2-description">Description</p>
                <textarea class="proposal-2-input-2 form-control" rows="13" cols="47" wire:model="proj_description"
                    placeholder="Project Description..." required></textarea>
                <br class="line-height">
                {{-- <input type="hidden" value="{{ Auth::User()->name }}" wire:model="user_name"> --}}
                <p class="proposal-2-domain">Domain</p>
                <textarea class="proposal-2-input-3 form-control"  rows="2" cols="47" wire:model="proj_domain"
                    placeholder="Enter Domain Name(s)" required></textarea>
            </div>
<br>
            <input class="btn" type="button" wire:click="submitProposal" value="SUBMIT">
        </form>

        <style>


            table {
                font-family: Verdana, Geneva, Tahoma, sans-serif;
                position: relative;
                left: 48.5%;
                right: 0%;
                top: 3.2vh;
                width: 50%;

                box-shadow: 0px 0px 10px gray;
            }

            table tr {
                text-align: center;
                border: 1px solid #d9d9d9;

            }

            thead {
                background: #198753;
                color: white;
            }

            th {
                padding: 10px;
            }

            td {
                padding: 10px;
                background: whitesmoke;
            }
        </style>

        <table class="table-striped table-bordered table-hover">

            <thead>
                <th>Sr.No.</th>
                <th>Proposal Title</th>
                <th>Proposal Description</th>
                <th>Proposal Domain</th>
                <th>Status</th>
            </thead>

            <tbody>
                {{$counter =1}}
                @foreach ($proposals as $proposal)
                    <tr>
                        
                        <td>{{$counter++}}</td>
                        <td>{{ $proposal->proposal_name }}</td>
                        <td>{{ $proposal->proposal_description }}</td>
                        <td>{{ $proposal->proposal_domain }}</td>
                        <td>
                            @if ($proposal->is_accepted === 0)
                                <img src="{{ asset('img/rejected.png') }}" height="20" alt="">
                            @elseif($proposal->is_accepted === 1)
                                <img src="{{ asset('img/tick.png') }}" height="20" alt="">
                            @else
                                <img src="{{ asset('img/pending.png') }}" height="20" alt="">
                            @endif
                        </td>
                    </tr>
                @endforeach


            </tbody>

        </table>


    </body>

    </html>


    <script>
        // function TabDisplay(event) {
        //     let tab = document.getElementsByClassName("navigation-tab")[0];
        //     if (tab.style.display === 'flex') {
        //         tab.style.display = 'none';
        //     } else {
        //         tab.style.display = 'flex';
        //     }
        // }
    </script>

    @script
        <script>
            window.addEventListener('proposal', event => {
                alert(event.detail[0].message);
            })
        </script>
    @endscript

</div>
