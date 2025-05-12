<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Logs</title>
    <style>
        body {
            font-family: Arial, sans-serif;
           background: linear-gradient(to right, #6a11cb, #2575fc);
            margin: 0;
            padding: 0;
        }
        .container {
            margin: 20px auto;
            max-width: 1200px;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #007BFF;
            color: white;
            cursor: pointer;
        }
        th:hover {
            background-color: #0056b3;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .error-message {
            color: red;
            font-weight: bold;
            text-align: center;
        }
        .search-box {
            margin-bottom: 20px;
            padding: 10px;
            width: 100%;
            max-width: 400px;
            border: 1px solid #ddd;
            border-radius: 4px;
            display: block;
            margin-left: auto;
            margin-right: auto;
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
    </style>
</head>
<body>

    <div class="container">
        <div style="text-align: left;">
            <button onclick="window.location.href='{{ url()->previous() }}'" class="btn-back">Back</button>
        </div>
        <h1>Login Logs</h1>

        @if(session('error'))
            <p class="error-message">{{ session('error') }}</p>
        @endif

        @if(!empty($loginLogs))
            <input type="text" id="searchInput" class="search-box" placeholder="Search logs..." onkeyup="filterTable()">

            <table id="logsTable">
                <thead>
                    <tr>
                        <th onclick="sortTable(0)">ID</th>
                        <th onclick="sortTable(1)">User ID</th>
                        <th onclick="sortTable(2)">Username</th>
                        <th onclick="sortTable(3)">Login Time</th>
                        <th onclick="sortTable(4)">IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($loginLogs as $log)
                        <tr>
                            <td>{{ $log['ID'] }}</td>
                            <td>{{ $log['UserID'] }}</td>
                            <td>{{ $log['Username'] }}</td>
                            <td>{{ $log['LoginTime'] }}</td>
                            <td>{{ $log['IPAddress'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No login logs available.</p>
        @endif
    </div>

    <script>
        function filterTable() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toLowerCase();
            const table = document.getElementById('logsTable');
            const rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName('td');
                let match = false;
                for (let j = 0; j < cells.length; j++) {
                    if (cells[j].innerText.toLowerCase().includes(filter)) {
                        match = true;
                        break;
                    }
                }
                rows[i].style.display = match ? '' : 'none';
            }
        }

        function sortTable(columnIndex) {
            const table = document.getElementById('logsTable');
            const rows = Array.from(table.rows).slice(1);
            const isAscending = table.getAttribute('data-sort-order') === 'asc';
            const direction = isAscending ? 1 : -1;

            rows.sort((a, b) => {
                const aText = a.cells[columnIndex].innerText;
                const bText = b.cells[columnIndex].innerText;

                return aText.localeCompare(bText, undefined, { numeric: true }) * direction;
            });

            rows.forEach(row => table.tBodies[0].appendChild(row));
            table.setAttribute('data-sort-order', isAscending ? 'desc' : 'asc');
        }
    </script>

</body>
</html>
