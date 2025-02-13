<div>


    <html>

    <head>
        <link rel="stylesheet" href="{{ asset('css/Homepage.css') }}">
        <link rel="stylesheet" href="{{ asset('css/Tasks.css') }}">
        <script src="https://www.gstatic.com/charts/loader.js"></script>
    </head>

    <body>
        @include('nav.student-nav')
        <div class="header-box">
          
            <span class="heading">TASKS</span>

            


        </div>

        

        <style>
            @media print {


                .header-box {
                    display: none;
                }

                /* Hide the button when printing */
                button {
                    display: none;
                }

                /* Define print styles for the table */
                table {
                    width: 100%;
                    position: absolute;
                    left: -0% !important;
                    top: 20px;
                    border-collapse: collapse;
                    margin-bottom: 10px;

                }

                th:nth-last-child(-n+2), {
                    display: none;
                }

                th {
                    font-weight: bolder;
                }

                th{
                    color:black;
                }

                th,
                td {
                    border: 1px solid #000;
                    padding: 8px;
                    text-align: left;
                }

                th {
                    background-color: #f2f2f2;
                }
            }
        </style>

        <style>
            table {
                font-family: Verdana, Geneva, Tahoma, sans-serif;
                position: relative;
                left: 25.5%;
                top: 3.2vh;
                max-width: 60%;
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
                border: 1px solid black;
                /* background: whitesmoke; */
            }

            .toggle_button {
                background: black;
                text-align: center;
                align-content: center;
                justify-content: center;
                color: white;
                padding: 10px;
                z-index: 100;
                cursor: pointer;
            }

            .add_task_btn {
                background-color: #198753;
                
                color: white;
                padding: 10px 40px;
                position: relative;
                top: 5vh;
                outline: none;
                border: none;
                cursor: pointer;
                z-index: 30;
                left: 25.5%;
            }


            .modal_show {
                display: flex;
            }

            .modal_hide {
                display: none;
            }

            .modal_background {
                height: 100vh;
                width: 100%;
                background: rgba(0, 0, 0, 0.5);
                position: absolute;
                z-index: 50;
                margin: 0px;
                padding: 0px;
                left: 0px;
                top: 0px;
                border: none;
                justify-content: center;
                align-content: center;
            }

            .modal {
                height: 50vh;
                width: 20%;
                background: whitesmoke;
                margin-top: 5%;
                border-radius: 10px;
                color: black;
                justify-content: center;
                text-align: center;
                max-width: 50%;
                font-family: Verdana, Geneva, Tahoma, sans-serif;
            }

            label {
                display: block;
                margin: 10px;
            }

            .form_input {
                width: 50%;
                padding: 10px;
                box-shadow: 0px 0px 1px black;
            }

            .modal_btn {
                left: 10px;
                box-shadow: 0px 0px 4px black !important;
            }
        </style>




        <table class="table-striped table-bordered table-hover printTable">
            <button class="add_task_btn btn " onclick="printTable()">Print</button>

            <thead>
                <th>Group No</th>
                <th>Week No</th>
                <th>Task</th>
                <th>Due Date</th>
                <th>Completed Date</th>
                <th>Remark</th>
                <th>Early / Delay</th>
                <th>Folder</th>
                <th>Status</th>
            </thead>


            <tbody>
                @foreach ($tasks as $task)
                    <tr>
                        @if ($loop->index == 0)
                            <td rowspan="100" style="text-align: center;">{{ $group_no }}</td>
                        @endif
                        <td style="text-align: center;">{{ $task->week_no }}</td>
                        <td style="text-align: center;">{{ $task->task_title }}</td>
                        <td style="text-align: center;">{{ $task->task_due_date }}</td>
                        <td style="text-align: center;">{{ $task->task_completed_date }}</td>
                        <td style="text-align: center;">{{ $task->task_remark }}</td>
                        <td  style="text-align: center;">
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
                        <td  style="text-align: center;">

                            <select name="" id="task_folder" task_id={{ $task->task_id }} id="task_folder">
                                <option>Select</option>
                                @foreach ($folders as $folder)
                                    <option value="{{ $folder->ff_id }}"
                                        @if ($folder->ff_id == $task->task_folder) @selected(true) @endif>
                                        {{ $folder->ff_title }}
                                    </option>
                                @endforeach

                            </select>

                        </td>
                        <td  style="text-align: center;">
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


    </body>

    </html>

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



</div>
