<div>

    <html>

    <head>
        <link rel="stylesheet" href="{{ asset('css/Homepage.css') }}">
        <script src="https://www.gstatic.com/charts/loader.js"></script>

    </head>
<style>
    
</style>
    <body>
        <div class="header-box">
            {{-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                class="navigation-icon" onclick="TabDisplay(event)">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg> --}}
            <span class="heading">PROGRESS</span>

        </div>
        {{-- <div id="chart-1">
        </div>
        <div id="chart-2">
        </div> --}}


      

        {{-- <p class="chart-1-percentage">{{ $stu_per_done }}%</p> --}}
        {{-- <p class="chart-2-percentage">{{ $approved_per_done }}%</p> --}}


        <br><br>
        <br><br>
        <div class="charts" style="margin-left: 500px;">
            <div id="chart-1">
                <p class="chart-1-percentage">{{ $stu_per_done }}%</p>
            </div>
            <div id="chart-2">
                <p class="chart-2-percentage">{{ $approved_per_done }}%</p>
            </div>
        </div>
        @include('nav.superadmin-nav')

        @if ($accepted_proposal !== null)
        <table border="1">

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

        </table>
        @elseif ($accepted_proposal == null)

            <div class="noproposal">
<h1>No proposal approved</h1>
            </div>
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
        <style>
            .noproposal{
                /* border: 1px solid red; */

                width: 40%;
                margin: 20px;
                position: relative;
                left: 40%;
                padding: 5px
            }
            table {
                font-family: Verdana, Geneva, Tahoma, sans-serif;
                position: relative;
                right: 5%;
                float: right;
                /* top: 5vh; */
                margin: 100px 0px;
                width: 60%;
                text-align: center;
            }

            table td,
            table th {
                padding: 20px;
            }

            table th {
                background: #198753;
                color: white;
            }
        </style>


        




    </body>

    </html>
</div>
