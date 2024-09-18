<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Audio File</title>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        input[type="file"] {
            padding: 10px;
            border: 2px dashed #ccc;
            border-radius: 8px;
            cursor: pointer;
            margin-bottom: 20px;
            width: 100%;
            text-align: center;
            background-color: #f8f9fa;
            transition: all 0.3s ease;
        }

        input[type="file"]:hover {
            background-color: #e9ecef;
            border-color: #007bff;
        }

        button {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        button:hover {
            background-color: #0056b3;
        }

        #playtime-result {
            margin-top: 20px;
            color: #333;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }

        .error ul {
            list-style: none;
            padding: 0;
        }

        /* Responsive Design */
        @media (max-width: 500px) {
            .container {
                padding: 20px;
            }

            h1 {
                font-size: 20px;
            }

            button {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Upload Audio File to Get Playtime</h1>

        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="audio-form" method="POST" action="/audio/playtime" enctype="multipart/form-data">
            @csrf
            <input type="file" name="audio" accept="audio/*" required>
            <button type="submit">Get Playtime</button>
        </form>

        <div id="playtime-result"></div>
    </div>

    <script>
        $('#audio-form').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url: '/audio/playtime',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                success: function(response) {
                    if (response.status === 'success') {
                        $('#playtime-result').html('Playtime: ' + response.playtime);
                    } else {
                        $('#playtime-result').html('Error: ' + response.message);
                    }
                },
                error: function(xhr) {
                    $('#playtime-result').html('An error occurred while processing the request.');
                }
            });
        });
    </script>
</body>
</html>
