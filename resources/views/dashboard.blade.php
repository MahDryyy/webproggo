<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SaveBite Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to bottom, #f7f9fc, #e8f5e9);
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            min-height: 100vh;
            overflow-y: auto;
        }

        .header {
            background: linear-gradient(135deg, #4caf50, #81c784);
            color: white;
            width: 100%;
            padding: 20px 0;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            position: fixed;
            top: 0;
            z-index: 1000;
        }

        .header h1 {
            font-size: 3.5em;
            margin: 0;
            letter-spacing: 2px;
            font-weight: 600;
            animation: fadeInDown 1.5s ease-in-out;
        }

        .description {
            font-size: 1.2em;
            color: #555;
            text-align: center;
            padding: 20px;
            margin-top: 100px;
            max-width: 700px;
            animation: fadeInUp 1.5s ease-in-out;
        }

        .button-container {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .dashboard-button {
            background: rgba(255, 255, 255, 0.8);
            color: #333;
            padding: 20px 35px;
            font-size: 1.2em;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
            width: 250px;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .dashboard-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(76, 175, 80, 0.2);
            z-index: 0;
            transition: left 0.3s ease;
        }

        .dashboard-button:hover::before {
            left: 0;
        }

        .dashboard-button:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        }

        .dashboard-button i {
            margin-right: 10px;
            font-size: 1.5em;
        }

        .footer {
            margin-top: 40px;
            font-size: 1em;
            color: #888;
            text-align: center;
            animation: fadeInUp 1.5s ease-in-out;
        }

        .footer a {
            color: #4caf50;
            text-decoration: none;
            font-weight: 600;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }

        }
        #calendar {
            width: 80%;
            height: 60vh; /* Reduced height to avoid overlapping with buttons */
            margin: 120px auto 20px; /* Added top margin to account for header and avoid overlap */
            border: 2px solid #ccc; /* Ensures the element is visible */
            background-color: #f0f0f0; /* Clear background */
        }

    </style>
</head>
<body>
    <div class="header">
        <h1>SaveBite</h1>
    </div>

    <div class="description">
        <p>Welcome to the <strong>SaveBite Dashboard</strong>! Manage your food data, track expiration dates, and keep your food fresh with ease.</p>
    </div>

    <div id="calendar"></div>
    <script>
        $(document).ready(function() {
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                events: [
                    {
                        title: 'Sample Food 1',
                        start: '2025-05-09',
                        color: '#ff5722'
                    },
                    {
                        title: 'Sample Food 2',
                        start: '2025-12-05',
                        color: '#4caf50'
                    },
                    {
                        title: 'Sample Food 3',
                        start: '2025-12-10',
                        color: '#2196f3'
                    }
                ],
                editable: true,
                eventLimit: true,
                height: 'auto', 
                contentHeight: 'auto' 
            });
        });
    </script>


    </script>

    <div class="button-container">
        <a href="/recipes" style="text-decoration: none;">
            <button class="dashboard-button">
                <i class="fas fa-utensils"></i> History Recipes
            </button>
        </a>
        <a href="/foods/add" style="text-decoration: none;">
            <button class="dashboard-button">
                <i class="fas fa-plus-circle"></i> Add New Food
            </button>
        </a>
        <a href="/foods" style="text-decoration: none;">
            <button class="dashboard-button">
                <i class="fas fa-eye"></i> View Food Data
            </button>
        </a>
    </div>

    <div class="footer">
        <p>&copy; 2025 <a href="https://www.youtube.com/watch?v=2e0BMACvymo" target="_blank">SaveBite</a>. All rights reserved.</p>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
