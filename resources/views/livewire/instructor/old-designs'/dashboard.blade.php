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
            <span class="heading">DASHBOARD</span>
            
        </div>
        <div class="dashboardPannel">
            <a class='btns parti' href="{{ route('instructor.participants') }}" wire:navigate>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="btns-4-icon">
                    <path fill-rule="evenodd"
                        d="M8.25 6.75a3.75 3.75 0 117.5 0 3.75 3.75 0 01-7.5 0zM15.75 9.75a3 3 0 116 0 3 3 0 01-6 0zM2.25 9.75a3 3 0 116 0 3 3 0 01-6 0zM6.31 15.117A6.745 6.745 0 0112 12a6.745 6.745 0 016.709 7.498.75.75 0 01-.372.568A12.696 12.696 0 0112 21.75c-2.305 0-4.47-.612-6.337-1.684a.75.75 0 01-.372-.568 6.787 6.787 0 011.019-4.38z"
                        clip-rule="evenodd" />
                    <path
                        d="M5.082 14.254a8.287 8.287 0 00-1.308 5.135 9.687 9.687 0 01-1.764-.44l-.115-.04a.563.563 0 01-.373-.487l-.01-.121a3.75 3.75 0 013.57-4.047zM20.226 19.389a8.287 8.287 0 00-1.308-5.135 3.75 3.75 0 013.57 4.047l-.01.121a.563.563 0 01-.373.486l-.115.04c-.567.2-1.156.349-1.764.441z" />
                </svg>
                PARTICIPANTS
                <p class="counter ">{{ $participants_count }}</p>

            </a>
            <a class='btns noti' href="{{ route('instructor.notifications') }}" wire:navigate>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="white" class="btns-1-icon">
                    <path
                        d="M5.85 3.5a.75.75 0 00-1.117-1 9.719 9.719 0 00-2.348 4.876.75.75 0 001.479.248A8.219 8.219 0 015.85 3.5zM19.267 2.5a.75.75 0 10-1.118 1 8.22 8.22 0 011.987 4.124.75.75 0 001.48-.248A9.72 9.72 0 0019.266 2.5z" />
                    <path fill-rule="evenodd" d="M12 2.25A6.75 6.75 0 005.25 9v.75a8.217 8.217 0 01-2.119 5.52.75.75 0 00.298 1.206c1.544.57 3.16.99 4.831 1.243a3.75 3.75 0 107.48 0 24.583 24.583 0 004.83-1.244.75.75 0 00.298-1.205 8.217 8.217 0 01-2.118-5.52V9A6.75 6.75 0 0012 2.25zM9.75 18c0-.034
              0-.067.002-.1a25.05 25.05 0 004.496 0l.002.1a2.25 2.25 0 11-4.5 0z" clip-rule="evenodd" />
                </svg>
                NOTIFICATIONS
                <p class="counter ">{{ $notification_count }}</p>
                {{-- <a class="count-1"></a> --}}
            </a>
            <a class='btns repo' href="{{ route('instructor.repositories') }}" wire:navigate>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="btns-2-icon">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25
              4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                </svg>
                REPOSITORIES
                <p class="counter ">{{ $repositories_count }}</p>

            </a>
            <a class='btns task' href="{{ route('instructor.tasks') }}" wire:navigate>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="btns-3-icon">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25
                0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75
                12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                </svg>
                TASKS
                <p class="counter ">{{ $tasks_count }}</p>

            </a>
            

        </div>
    


  
        <div class="charts">
            <div id="chart-1">
                <p class="chart-1-percentage">{{ $stu_per_done }}%</p>
            </div>
            <div id="chart-2">
                <p class="chart-2-percentage">{{ $approved_per_done }}%</p>
            </div>
                
        </div>
        @include("nav.instructor-nav")
        <style>
             table {
                font-family: Verdana, Geneva, Tahoma, sans-serif;
                position: relative;
                right: 1%;
                float: right;
                top: 20vh;
                width: 43%;
                text-align: center;
            }

            table td,
            table th {
                padding: 20px;
            }

            table th {
                background: black;
                color: white;
            }
        </style>


        @if ($accepted_proposal !== null)
            {{-- <table border="1">

                <thead>
                    <th>Proposal Submitted Date</th>
                    <th>Proposal Accepted Date</th>
                    <th>Proposal Domain</th>
                    <th>Proposal Title</th>
                    <th>Proposal Description</th>
                </thead>

                <tbody>
                    <tr>
                        <td>{{ $accepted_proposal->created_at }}</td>
                        <td>{{ $accepted_proposal->updated_at }}</td>
                        <td>{{ $accepted_proposal->proposal_domain }}</td>
                        <td>{{ $accepted_proposal->proposal_name }}</td>
                        <td>{{ $accepted_proposal->proposal_description }}</td>
                    </tr>

                </tbody>

            </table> --}}
        @endif


        <script>
            google.charts.load('current', {
                'packages': ['corechart']
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                const data = google.visualization.arrayToDataTable([
                    ['Progress', 'Value'],
                    ['Completed', {{ $stu_per_done }}],
                    ['Incomplete', {{ $stu_task_remaining }}]
                ]);

                const data2 = google.visualization.arrayToDataTable([
                    ['Progress', 'Value'],
                    ['Completed', {{ $approved_per_done }}],
                    ['Incomplete', {{ $approved_task_remaining }}]
                ]);

                const options1 = {
                    width: 450,
                    height: 400,
                    title: 'Progress',
                    titleTextStyle: {
                        fontSize: 25
                    },
                    pieHole: 0.4,
                    pieSliceText: 'percentage',
                    legend: 'left',
                    colors: ['rgb(242, 26, 242)', 'rgb(94, 94, 242)']
                };
                const options2 = {
                    width: 450,
                    height: 400,
                    title: 'Approved Progress',
                    pieHole: 0.4,
                    pieSliceText: 'percentage',
                    titleTextStyle: {
                        fontSize: 25
                    },
                    legend: 'left',
                    colors: ['rgb(242, 26, 242)', 'rgb(94, 94, 242)']
                };
                const chart1 = new google.visualization.PieChart(document.getElementById('chart-1'));
                const chart2 = new google.visualization.PieChart(document.getElementById('chart-2'));
                chart1.draw(data, options1);
                chart2.draw(data2, options2);
            }

            function TabDisplay(event) {
                let tab = document.getElementsByClassName("navigation-tab")[0];
                if (tab.style.display === 'flex') {
                    tab.style.display = 'none';
                } else {
                    tab.style.display = 'flex';
                }
            }

            function redirecttoTimeline(event) {
                window.location.href = 'Timeline.html';
            }
        </script>
    </body>

    </html>
</div>
