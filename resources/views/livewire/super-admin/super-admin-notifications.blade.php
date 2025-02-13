<div>

    <html>

    <head>
        <link rel="stylesheet" href="{{ asset('css/Homepage.css') }}">
        <script src="https://www.gstatic.com/charts/loader.js"></script>
    </head>

    <body>
        <div class="header-box">
    
            <span class="heading">NOTIFICATIONS</span>


        </div>
        @include('nav.superadmin-nav')
        <style>
            .notification-container {
                width: 70%;
                height: auto;
                position: relative;
                left: 20%;
                top: 2vh;
                color: white;
                font-family: Verdana, Geneva, Tahoma, sans-serif;
                font-weight: bold;
            }

            .notifications {
                background-color: #198754;
                width: 90%;
                display: flex;
                flex-direction: column;
                margin-left: 100px;
                box-shadow: 0px 0px 10px black;
                padding: 20px;
                margin-top: 20px;
            }

            .notification_title,
            .notification_message {
                line-height: 40px;
            }



            .created_at {
                text-align: right;
            }

            .repositories {
                width: 75%;
                height: auto;
                position: relative;
                left: 20%;
                padding: 20px;
                overflow: hidden;
            }

            .repo-header {
                background: whitesmoke;
                padding: 20px;
                position: relative;
                box-shadow: 0px 0px 5px black;
            }


            .create-folder-section {
                width: 20%;
                float: left;
                position: relative;
                z-index: 100;
            }

            .create-folder-section input {
                padding: 10px;
            }

            .create-folder-section button,
            .upload-file-section input[type="submit"] {
                color: white;
                background: #198754;
                padding: 10px;
                outline: none;
            }

            .upload-file-section {
                /* display: inline; */
                /* float:left; */
                position: relative;
            }

            .create_folder{
                padding:10px;
                cursor: pointer;
                outline: none;
                background:#198754;
                color:white;
                border: none;
                position: absolute;
                top:30%;
                right:40%;
            }

        </style>

        <div class="repositories">

            <div class="repo-header">

                <div class="upload-section">

                    <div class="create-folder-section">
                        <input type="text" name="" wire:model="notification_title" id="Notifiation Title"
                            placeholder="Notification title.." id="" required>
                        </div>
                        <textarea name="" placeholder="Notification Message" wire:model="notification_message"  id="" cols="30" rows="2"></textarea>
                        <button wire:click="create_notification" class="create_folder">Send Notification</button>


                    </form>
                </div>
            </div>
        </div>

        <div class="notification-container">
            @foreach ($notifications as $notification)
                <div class="notifications">
                    <div class="notification_title">Title: {{ $notification->notification_title }}</div>
                    <div class="notification_message">Message: {{ $notification->notification_message }}</div>
                    <div class="created_at">{{ $notification->created_at }}</div>
                </div>
            @endforeach
        </div>

    </body>


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

    </html>

</div>
