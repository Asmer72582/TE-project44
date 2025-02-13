<div>


    <html>

    <head>
        <link rel="stylesheet" href="{{ asset('css/Homepage.css') }}">
        <script src="https://www.gstatic.com/charts/loader.js"></script>
    </head>

    <body>
        <div class="header-box">
          
            <span class="heading">TASK REPOSITORY</span>

         

        </div>
        @include('nav.instructor-nav')

        <style>
            .repositories {
                width: 75%;
                height: auto;
                position: relative;
                left: 20%;
                padding: 20px;
                overflow: hidden;
            }

            .repo-header {
                background-color: #198753;
                padding: 20px;
                margin-left: 50px;
                position: relative;
                box-shadow: 0px 0px 5px black;
            }


            .create-folder-section {
                width: 30%;
                float: left;
                position: relative;
                z-index: 100;
            }
            .upload-section{
                display: flex;
                justify-content: space-evenly;
                align-items: center;
                /* padding: 10px 0px; */


            }
            .upload-section form, .create-folder-section{
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 10px;
            }

            .create-folder-section input {
                padding: 15px;
            }

            .create-folder-section button,
            .upload-file-section input[type="submit"] {
                color: white;
                background: black;
                /* padding: 10px; */
                outline: none;
            }

            .upload-file-section {
                /* display: inline; */
                /* float:left; */
                position: relative;
            }

            .repo-content {
                width: 100%;
                /* background:red; */
                padding: 40px;
                display: flex;
                flex-wrap: wrap;
                /* max-width: 100%; */

            }

            .repo-file {
                height: 230px;
                width: 15%;

                align-content: center;
                justify-content: center;
                text-align: center;
                background: whitesmoke;
                padding: 20px;
                margin: 20px;
                float: left;
                box-shadow: 0px 0px 2px black;
                transition: 0.2s ease-in-out;
            }

            .file-name{
                height: 20px;
                overflow: hidden;
            }
            .repo-file:hover {
                transform: scale(1.05);
            }

            .file-created-at {
                position: relative;
            }

            .open-folder {
                background: black;
                color: white;
                outline: none;
                padding: 5px;
                cursor: pointer;
            }

            .upload-btn {
                z-index: 100;
            }
        </style>

        <div class="repositories">

            <div class="repo-header">

                <div class="upload-section">

                    <div class="create-folder-section">
                        <input type="text" name="" class="form-control" wire:model="folder_name" id="folder_name"
                            placeholder="Folder Name.." id="" required>
                        <button wire:click="create_folder" class="btn">Create Folder</button>
                    </div>

                    <div>
                        <form wire:submit.prevent="uploadFile" enctype="multipart/form-data" class="upload-file-section">
                            <input type="file" name="" wire:model="files" class="form-control" multiple id="" required>
                            <input type="submit" value="Upload" class="upload-btn btn">
                        </form>
                    </div>
                </div>
            </div>

            <br>

            {{-- @if ($current_folder !== null)
                <button style="padding:10px; background:black; color:white; z-index:100; cursor:pointer;"
                    wire:click="goBackFolder" wire:loading.attr="disabled">Go Back</button>
            @endif --}}

            <div class="repo-content">


                @foreach ($ffs as $ff)
                    @if ($ff->is_folder)
                        <div class="repo-file">
                            <div class="file-upper">
                                <img src="{{ asset('img/folder.png') }}" height="60" alt="">
                            </div>

                            <div class="file-lower">
                                <p class="file-name">{{ $ff->ff_title }}</p>
                                <button class="open-folder" style="position: relative; top:35px;"
                                    wire:click="openFolder({{ $ff->ff_id }})">Open</button>
                                <button class="open-folder"
                                    style="position: relative; top:35px;   background: red; outline:none; border:red;"
                                    wire:click="deleteFF({{ $ff->ff_id }})">Delete</button>
                                <p class="file-created-at" style="position: relative; top:35px;">
                                    {{ $ff->created_at }}</p>
                            </div>
                        </div>
                    @else
                        <div class="repo-file">
                            <div class="file-upper">
                                <img src="{{ asset('img/file.png') }}" height="60" alt="">
                            </div>

                            <div class="file-lower">
                                <p class="file-name">{{ $ff->ff_title }}</p>
                                <p class="file-size">{{ $ff->file_size }}</p>
                                <button class="open-folder"
                                    wire:click="DownloadFile({{ $ff->ff_id }})">Download</button>
                                <button class="open-folder" style="background: red; outline:none; border:red;"
                                    wire:click="deleteFF({{ $ff->ff_id }})">Delete</button>
                                <p class="file-created-at">{{ $ff->created_at }}</p>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
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

    @script
        <script>
            window.addEventListener('invalid_folder_name', () => {
                alert("Folder Name is Required!");
            })

            window.addEventListener('file_deleted', () => {
                alert("Deleted Successfully!");
            })
        </script>
    @endscript

</div>
