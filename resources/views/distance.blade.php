<!DOCTYPE html>
<html>
<head>
    <title>Calculate Distance</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input[type="text"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background: #007bff;
            color: #fff;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
        #distance-result {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Calculate Distance Between Two Locations</h1>

        @if ($errors->any())
            <div style="color:red;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="distance-form" method="POST" action="/calculate-distance">
            @csrf
            <label for="lat1">Latitude 1:</label>
            <input type="text" name="lat1" required>

            <label for="lng1">Longitude 1:</label>
            <input type="text" name="lng1" required>

            <label for="lat2">Latitude 2:</label>
            <input type="text" name="lat2" required>

            <label for="lng2">Longitude 2:</label>
            <input type="text" name="lng2" required>

            <button type="submit">Calculate Distance</button>
        </form>

        <div id="distance-result" style="margin-top: 20px;"></div>
    </div>

    <script>
        document.getElementById('distance-form').addEventListener('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            fetch('/calculate-distance', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    document.getElementById('distance-result').textContent = 'Distance: ' + data.distance.toFixed(2) + ' km';
                } else {
                    document.getElementById('distance-result').textContent = 'Error: ' + data.message;
                }
            })
            .catch(error => {
                document.getElementById('distance-result').textContent = 'An error occurred while processing the request.';
            });
        });
    </script>
</body>
</html>
