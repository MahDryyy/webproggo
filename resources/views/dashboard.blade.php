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
            background: #474E68;
            color: #232946;
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
            border-radius: 0px;
            background: #404258;
            box-shadow:  -43px 43px 100px #0d142c;
            color: #fff;
            width: 100%;
            padding: 28px 0 22px 0;
            text-align: center;
            position: static;
            top: 0;
            z-index: 1000;
        }

        .header h1 {
            font-size: 3.5em;
            margin: 0;
            letter-spacing: 2px;
            font-weight: 700;
            animation: fadeInDown 1.5s ease-in-out;
            text-shadow: 0 2px 12px rgba(35,49,66,0.08);
        }

        .description {
            font-size: 1.2em;
            color: #232946;
            text-align: center;
            padding: 24px;
            margin-top: 90px;
            margin-bottom: 24px;
            max-width: 700px;
            border-radius: 24px;
            background: linear-gradient(225deg,rgb(253, 253, 253), #d6d9dd);
            box-shadow: 0px 3px 40px rgba(248, 243, 243, 0.73);
            animation: fadeInUp 1.5s ease-in-out;
        }

        .button-container {
            display: flex;
            justify-content: center;
            gap: 32px;
            margin-top: 36px;
            flex-wrap: wrap;
        }

        .dashboard-button {
            background: linear-gradient(90deg, #3e6ff4 0%, #5be9b9 100%);
            color: #fff;
            padding: 22px 38px;
            font-size: 1.2em;
            border: none;
            border-radius: 16px;
            cursor: pointer;
            transition: transform 0.25s, box-shadow 0.25s, background 0.25s, color 0.25s;
            width: 250px;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 8px 28px rgba(62,111,244,0.13);
            position: relative;
            overflow: hidden;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .dashboard-button:hover {
            background: linear-gradient(90deg, #5be9b9 0%, #3e6ff4 100%);
            color: #232946;
            transform: scale(1.08);
            box-shadow: 0 16px 32px rgba(91,233,185,0.15);
        }

        .dashboard-button i {
            margin-right: 12px;
            font-size: 1.5em;
        }

        .footer {
            margin-top: 48px;
            font-size: 1em;
            color:rgb(216, 218, 219);
            text-align: center;
            animation: fadeInUp 1.5s ease-in-out;
        }

        .footer a {
            color: #3e6ff4;
            text-decoration: none;
            font-weight: 700;
            transition: color 0.2s;
        }

        .footer a:hover {
            color: #5be9b9;
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
            width: 82%;
            height: 50vh;
            margin: 130px auto 24px;
            border-radius: 22px;
            background: linear-gradient(225deg,rgb(253, 253, 253), #d6d9dd);
            box-shadow: 0px 3px 40px rgba(248, 243, 243, 0.73);
            box-sizing: border-box;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }   

        .alert {
            padding: 18px;
            background: linear-gradient(225deg,rgb(253, 253, 253), #d6d9dd);
            color: #232946;
            border-radius: 10px;
            margin-top: 60px;
            width: 90vw;
            max-width: 700px;
            box-sizing: border-box;
            box-shadow: 0px 3px 40px rgba(248, 243, 243, 0.73);
            font-size: 1.08em;
            font-weight: 500;
        }

        @media (max-width: 900px) {
            #calendar {
                width: 98%;
            }
            .description {
                margin-top: 120px;
            }
        }
        @media (max-width: 600px) {
            .header h1 {
                font-size: 2.1em;
            }
            .description {
                font-size: 1em;
                padding: 12px;
            }
            .dashboard-button {
                width: 98vw;
                font-size: 1em;
                padding: 16px 0;
            }
            #calendar {
                margin-top: 140px;
            }
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

    <div id="notification-area"></div>
    <div id="calendar"></div>

    <div class="button-container">
        <a href="{{ url('/recipes') }}" style="text-decoration: none;">
            <button class="dashboard-button">
                <i class="fas fa-utensils"></i> History Recipes
            </button>
        </a>
        <a href="{{ url('/foods/add') }}" style="text-decoration: none;">
            <button class="dashboard-button">
                <i class="fas fa-plus-circle"></i> Add New Food
            </button>
        </a>
        <a href="{{ url('/foods') }}" style="text-decoration: none;">
            <button class="dashboard-button">
                <i class="fas fa-eye"></i> View Food Data
            </button>
        </a>
    </div>

    <div class="footer">
        <p>&copy; 2025 <a href="https://www.youtube.com/watch?v=2e0BMACvymo" target="_blank">SaveBite</a>. All rights reserved.</p>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script>
    $(document).ready(function() {
        const calendar = $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            editable: true,
            eventLimit: true,
            height: 'auto',
            contentHeight: 'auto',
            events: fetchEvents
        });

        function fetchEvents(start, end, timezone, callback) {
            $.ajax({
                url: '{{ url('/foods-calender') }}',
                method: 'GET',
                success: function(data) {
                    const now = new Date();
                    let notifications = [];

                    const events = data.map(food => {
                        const expiry = new Date(food.expiry_date);
                        const diffDays = Math.floor((expiry - now) / (1000 * 60 * 60 * 24));

                        let color = '#43cea2'; // hijau
                        if (diffDays < 0) {
                            color = '#ff4d4d'; // merah
                            notifications.push(`❌ <strong>${food.name}</strong> sudah expired!`);
                        } else if (diffDays <= 14) {
                            color = '#ffb347'; // oranye
                            notifications.push(`⚠️ <strong>${food.name}</strong> akan expired dalam ${diffDays} hari.`);
                        }

                        return {
                            title: food.name,
                            start: food.expiry_date,
                            color: color
                        };
                    });

                    const notifArea = $('#notification-area');
                    if (notifications.length > 0) {
                        notifArea.html(
                            `<div class="alert alert-warning" role="alert">
                                <strong>Perhatian!</strong><br>${notifications.join('<br>')}
                             </div>`
                        );
                    } else {
                        notifArea.html('');
                    }

                    callback(events);
                }
            });
        }

        setInterval(function() {
            $('#calendar').fullCalendar('refetchEvents');
        }, 600000);
    });
    </script>
</body>
</html>
