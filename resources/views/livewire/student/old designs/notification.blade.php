<div>

    <html>

    <head>
        <link rel="stylesheet" href="{{ asset('css/Homepage.css') }}">
        <script src="https://www.gstatic.com/charts/loader.js"></script>
    </head>


    <body>
        @include('nav.student-nav')
        <div class="header-box">
          
            <span class="heading">NOTIFICATIONS</span>

            
        </div>

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
                width: 80%;
                display: flex;
                flex-direction: column;
                margin-left: 200px;
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
        </style>

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
