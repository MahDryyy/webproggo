<!-- resources/views/users/index.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #6a11cb, #2575fc);
            color: #333;
        }
        header {
            background-color: #007bff;
            color: white;
            padding: 1rem;
            text-align: center;
        }
        .container {
            max-width: 800px;
            margin: 2rem auto;
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            background: #f9f9f9;
            margin: 0.5rem 0;
            padding: 1rem;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        li:hover {
            background: #e9ecef;
        }
        .error {
            color: red;
            margin-bottom: 1rem;
        }
        .btn-back {
            background-color:rgb(0, 21, 44);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
        }
        .btn-back:hover {
            background-color:rgb(7, 192, 224);
        }
        .toggle-btn {
            display: inline-block;
            margin-top: 1rem;
            padding: 0.5rem 1rem;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .toggle-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    
    <header>
        <div style="text-align: left;">
            <button onclick="window.location.href='{{ url()->previous() }}'" class="btn-back">Back</button>
        </div>
        <h1>Users List</h1>
    </header>
    <div class="container">
        @if(session('error'))
            <div class="error">
                {{ session('error') }}
            </div>
        @endif

        @if(count($users) > 0)
            <ul id="user-list">
                @foreach($users as $user)
                    <li>
                        <strong>Username:</strong> {{ $user['username'] }}<br>
                        <strong>Role:</strong> {{ $user['role'] }}<br>
                        <strong>ID:</strong> {{ $user['id'] }}<br>
                    </li>
                @endforeach
            </ul>
            <button class="toggle-btn" onclick="toggleUserList()">Hide Users</button>
        @else
            <p>No users available.</p>
        @endif
    </div>

    <script>
        function toggleUserList() {
            const userList = document.getElementById('user-list');
            const toggleBtn = document.querySelector('.toggle-btn');
            if (userList.style.display === 'none' || userList.style.display === '') {
                userList.style.display = 'block';
                toggleBtn.textContent = 'Hide Users';
            } else {
                userList.style.display = 'none';
                toggleBtn.textContent = 'Show Users';
            }
        }
    </script>
</body>
</html>
