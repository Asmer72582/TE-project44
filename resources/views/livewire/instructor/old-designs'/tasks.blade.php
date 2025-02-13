<div>


    <html>

    <head>
        <link rel="stylesheet" href="{{ asset('css/Tasks.css') }}">
        <link rel="stylesheet" href="{{ asset('css/Homepage.css') }}">
        <script src="https://www.gstatic.com/charts/loader.js"></script>
    </head>

    <body>
        <div class="header-box">
           
            <span class="heading">TASKS</span>

            


        </div>

        @include('nav.instructor-nav')
        <style>
            table {
                font-family: Verdana, Geneva, Tahoma, sans-serif;
                position: relative;
                left: 25%;
                top: 3.2vh;
                width: 70%;
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
                /* background: whitesmoke; */
            }

            .toggle_button {
                background: #198753;
                text-align: center;
                align-content: center;
                justify-content: center;
                color: white;
                padding: 10px;
                z-index: 100;
                cursor: pointer;
            }

            .add_task_btn {
                background: #198753;
                color: white;
                padding: 10px;
                position: relative;
                top: 2vh;
                outline: none;
                border: none;
                cursor: pointer;
                z-index: 30;
                left: 25%;
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

            td {
                border: 1px solid black;
            }
        </style>


        <div class="modal_background modal_hide" id="modal_background">
            <div class="modal">
                <h1>Add Task</h1>

                <form wire:submit.prevent="create_task">

                
                    <p>
                        <label for="">Week No.</label>
                        <input type="number" name="" class="form_input" placeholder="Week" wire:model="week_no"
                            id="" required>
                    </p>
                    <p>
                        <label for="">Task Title</label>
                        <input type="text" name="" class="form_input" placeholder="Task Title"
                            wire:model="task_title" id="" required>
                    </p>
                    <p>
                        <label for="">Task Due Date</label>
                        <input type="date" name="" class="form_input" placeholder="Due Date"
                            wire:model="task_due_date" id="" required>
                    </p>

                    <p>
                        <button class="add_task_btn modal_btn" type="submit">Create Task</button>
                        <button class="add_task_btn modal_btn" type="button" style="z-index: 1000;"
                            id="close_modal_btn">Close</button>
                    </p>
                </form>

            </div>
        </div>


        <button class="add_task_btn" onclick="create_task" id="create_task" style="display: none">Add Task</button>
        <button class="add_task_btn" onclick="printTable()">Print</button>


        <style>
            @media print {

                .navigation-tab{
                    display: none;
                }
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
                    left: 0px;
                    top: 20px;
                    border-collapse: collapse;
                    margin-bottom: 10px;

                }

                th:nth-last-child(-n+2),
                td:nth-last-child(-n+2) {
                    display: none;
                }

                th {
                    font-weight: bolder;
                    color:#000;
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



        <script defer>
            function printTable() {
                window.print();
            }


            let create_task = document.getElementById("create_task");
            let modalBackground = document.getElementById("modal_background");
            create_task.addEventListener("click", function() {
                // Remove all existing classes
                modalBackground.className = "";
                // Add the new class
                modalBackground.classList.add("modal_background");
                modalBackground.classList.add("modal_show");
            })
        </script>

        <table id="my_table">

            <thead>
                <th>Group No</th>
                <th>Week No</th>
                <th>Task</th>
                <th style="width:15%">Due Date</th>
                <th>Completed Date</th>
                <th>Remark</th>
                <th>Early / Delay</th>
                <th>Folder</th>
                <th>Operation</th>
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
                        <td>
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
                        <td>
                            @if ($task->task_folder === null)
                                ----
                            @else
                                <a href="{{ route('instructor.open.folder', $task->task_folder) }}" wire:naviate>
                                    <button
                                        style="background:blue; color:white; border:none; border-radius:10px; padding:10px; cursor: pointer;">View</button>
                                </a>
                            @endif
                        </td>
                        <td>
                            <button class="toggle_button" id="toggle_task_btn"
                                onclick="toggleTasks(this.value, {{ $task->task_id }})"
                                value="{{ (int) $task->task_status }}">
                                @if ($task->task_status == 0)
                                    Click here to Mark as Accepted <img src="{{ asset('img/tick.png') }}"
                                        height="20" alt="">
                                @else
                                    Click here to Mark as Rejected <img src="{{ asset('img/rejected.png') }}"
                                        height="20" alt="">
                                @endif
                            </button>

                            <button wire:click="deleteTask({{ $task->task_id }})"
                                style="background:red; border:none; display:none; cursor: pointer; border-radius:5px; color:white; padding:14px; margin:5px;">
                                Delete
                            </button>

                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>


    </body>

    </html>


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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script defer>
        window.addEventListener('task_created', event => {
            alert("Task Created Successfully!");
            var mb = document.getElementById("modal_background");
            // Remove all existing classes
            mb.className = "";
            // Add the new class
            mb.classList.add("modal_background");
            mb.classList.add("modal_hide");
        });

        $(document).ready(function() {
            $(document).on("click", "#close_modal_btn", function() {
                var mb = document.getElementById("modal_background");
                // Remove all existing classes
                mb.className = "";
                // Add the new class
                mb.classList.add("modal_background");
                mb.classList.add("modal_hide");
            })
        })

        async function toggleTasks(val, task_id) {

            let ques = "Remark for Approval of Task";

            if (val == 1) {
                ques = "Remark for Rejecting the Task";
            }

            const {
                value: text
            } = await Swal.fire({
                input: "textarea",
                inputLabel: ques,
                inputPlaceholder: ques,
                inputAttributes: {
                    "aria-label": ques
                },
                showCancelButton: true
            });
            if (text) {
                @this.update_remark(text, task_id, val);
            }
        }
    </script>



</div>
