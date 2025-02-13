<div>

    <html>

    <head>
        <link rel="stylesheet" href="{{ asset('css/Homepage.css') }}">
        <script src="https://www.gstatic.com/charts/loader.js"></script>
    </head>

    <body>
        <div class="header-box">
            {{-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                class="navigation-icon" onclick="TabDisplay(event)">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg> --}}
            <span class="heading">GROUPS</span>
            

        </div>

        @include('nav.superadmin-nav')
        <style>
            table {
                font-family: Verdana, Geneva, Tahoma, sans-serif;
                position: absolute;
                right: 50px;
                top: 10vh;
                width: 75%;
                box-shadow: 0px 0px 10px gray;
            }

            table tr {
                text-align: center;

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
                z-index: 100;
            }

             button {
                cursor: pointer;
                padding: 10px;
                background: #198753;
                color: white;
                border: none;
                outline: none;
                border-radius: 10px;
            }
        </style>


        @if ($group_no === null)
            <table>

                
                <thead>
                    <th>Sr No.</th>
                    <th>Group No</th>
                    <th>Instructor Name</th>
                    <th>Instructor</th>
                    <th>Operation</th>
                </thead>

                <tbody>


                    @foreach ($groups as $group)
                        <tr>
                            <td>{{ $count++}}</td>
                            <td>{{ $group->group_no }}</td>
                            <td>{{ $group->name }}</td>
                            <td>{{ $group->email }}</td>
                            <td>
                                <a href="{{ route('superadmin.participant', $group->group_no) }}">
                                    <button>View Participants</button>
                                </a>

                                <a href="{{ route('superadmin.progress', $group->group_no) }}">
                                    <button>View Progress</button>
                                </a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>

            </table>
        @else
        <br>

            <h1 style="font-family: Verdana, Geneva, Tahoma, sans-serif; position: absolute;top:7vh; left:400px;">PARTICIPANTS
                OF {{ $group_no }} GROUP
            <a href="/dashboard/superadmin/groups/"><button> Go back</button></a>

            </h1>
                

            <table style="position: absolute; top:18vh; ">

                <thead>
                    <th>Group No</th>
                    <th>Type</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Progress</th>
                </thead>

                <tbody>

                    @foreach ($groups as $group)
                        <tr>
                            <td>{{ $group->group_no }}</td>
                            <td>{{ $group->user_type }}</td>
                            <td>{{ $group->name }}</td>
                            <td>{{ $group->email }}</td>
                            <td>
                                <a href="{{ route('superadmin.progress', $group->group_no) }}">
                                    <button>View Progress</button>
                                </a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>

            </table>

        @endif



    </body>

    </html>
</div>

<script>
    function TabDisplay(event) {
        let tab = document.getElementsByClassName("navigation-tab")[0];
        if (tab.style.display === 'flex') {
            tab.style.display = 'none';
        } else {
            tab.style.display = 'flex';
        }
    }
</script>

</div>
