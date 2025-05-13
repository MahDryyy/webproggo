<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foods</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #404258;
            color: #222;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            overflow-x: hidden;
        }
        h1 {
            text-align: center;
            color:rgb(255, 255, 255);
            margin-top: 40px;
            font-size: 2.7em;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: relative;
            padding-bottom: 10px;
        }
        .container {
            box-shadow: 0 10px 20px rgba(126, 126, 126, 0.1);
            max-width: 700px;
            margin: 30px auto 0 auto;
            background-color: #474E68;
            border-radius: 16px;
            box-shadow: 0 6px 32px rgba(60, 180, 80, 0.08);
            padding: 32px 24px 24px 24px;
        }
        ul {
            padding: 0;
            list-style-type: none;
            margin: 0;
        }
        li {
            background-color:rgb(226, 226, 226);
            padding: 18px 20px;
            border-radius: 10px;
            margin-bottom: 18px;
            box-shadow: 0 2px 8px rgba(60, 180, 80, 0.06);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: box-shadow 0.2s;
        }
        li:hover {
            box-shadow: 0 4px 16px rgba(60, 180, 80, 0.13);
        }
        .food-info {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }
        .food-title {
            font-weight: 600;
            font-size: 1.1em;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .food-expiry {
            font-size: 0.97em;
            color: #888;
        }
        .food-status {
            font-size: 0.93em;
            font-weight: bold;
            color: #388e3c;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
        button[type="submit"] {
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
        button[type="submit"]:hover, .reload-button:hover {
            background: linear-gradient(90deg, #5be9b9 0%, #3e6ff4 100%);
            color: #232946;
            transform: scale(1.08);
            box-shadow: 0 16px 32px rgba(91,233,185,0.15);
        }
        .delete-button {
            padding: 10px 18px;
            background-color: #ff7043;
            color: white;
            border: none;
            border-radius: 7px;
            cursor: pointer;
            font-size: 1em;
            transition: background 0.2s, transform 0.2s;
        }
        .delete-button:hover {
            background-color: #d84315;
            transform: scale(1.07);
        }
        .recipe-content {
            background-color: #e8f5e9;
            border-radius: 8px;
            padding: 14px 18px;
            margin-top: 12px;
            display: none;
            font-size: 1.04em;
            color: #222;
        }
        .loading {
            text-align: center;
            font-size: 1.3em;
            color: #388e3c;
        }
        .delete-card {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(60, 180, 80, 0.18);
            padding: 28px 24px;
            width: 320px;
            text-align: center;
            z-index: 1000;
        }
        .delete-card-content {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }
        .delete-confirm-button, .delete-cancel-button {
            padding: 10px 22px;
            border: none;
            border-radius: 7px;
            cursor: pointer;
            font-size: 1em;
            transition: background 0.2s;
        }
        .delete-confirm-button {
            background-color: #f44336;
            color: white;
        }
        .delete-confirm-button:hover {
            background-color: #c62828;
        }
        .delete-cancel-button {
            background-color: #388e3c;
            color: white;
        }
        .delete-cancel-button:hover {
            background-color: #2e7031;
        }
        .success-message {
            color: #388e3c;
            font-size: 1.15em;
            margin-top: 10px;
        }
        .back button {
            background: linear-gradient(90deg, #3e6ff4 0%, #5be9b9 100%);
            color: #fff;
            padding: 22px 38px;
            font-size: 1.2em;
            border: none;
            border-radius: 16px;
            cursor: pointer;
            transition: transform 0.25s, box-shadow 0.25s, background 0.25s, color 0.25s;
            width: 100%;
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
        .back button:hover {
            background: linear-gradient(90deg, #5be9b9 0%, #3e6ff4 100%);
            color: #232946;
            transform: scale(1.08);
            box-shadow: 0 16px 32px rgba(91,233,185,0.15);
        }
        .back button i {
            margin-right: 12px;
            font-size: 1.5em;
        }
    
        @media (max-width: 800px) {
            .container { max-width: 98vw; padding: 18px 6vw 18px 6vw; }
        }
    </style>
</head>
<body>
    <div class="back" style="position: absolute; top: 20px; left: 20px;">
        <a href="/dashboard">
            <button style="padding: 10px 20px; background-color: #4caf50; color: white; border: none; border-radius: 8px; font-size: 1em; cursor: pointer;">
            <
        </button>
        </a>
    </div>
    <h1>Foods</h1>
    <div class="container" data-aos="fade-up">
    @if(empty($foods))
        <p style="text-align: center; font-size: 1.2em; color: #ff7043;">No foods available. Please add some food items.</p>
    @else
        <form id="recipeForm">
            <ul>
                @foreach($foods as $food)
                    <li data-aos="fade-up">
                        <div class="food-info" style="color: {{ $food['color'] }};">
                            <span class="food-title">
                                <input type="checkbox" class="food-checkbox" data-food-id="{{ $food['id'] }}">
                                {{ $food['icon'] }} {{ $food['name'] }}
                            </span>
                            <span class="food-expiry">Expiry: {{ $food['expiry_date'] }}</span>
                            <span class="food-status">Status: {{ ucfirst($food['status']) }}</span>
                        </div>
                        <div class="actions">
                            <button type="button" class="delete-button" onclick="deleteFood({{ $food['id'] }})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        <div id="recipe-{{ $food['id'] }}" class="recipe-content"></div>
                    </li>
                @endforeach
            </ul>
            <button type="submit">Generate Recipes</button>
        </form>
    @endif
    <div id="recipe-result" class="recipe-content"></div>
    </div>
    <div id="delete-confirmation" class="delete-card" style="display: none;">
        <div class="delete-card-content">
            <p>Are you sure you want to delete this food item?</p>
            <button class="delete-confirm-button" onclick="confirmDelete()">Yes, Delete</button>
            <button class="delete-cancel-button" onclick="cancelDelete()">Cancel</button>
        </div>
    </div>
    <script>
    AOS.init();
    $(document).ready(function() {
        $('#recipeForm').submit(function(event) {
            event.preventDefault();
            var selectedFoodIds = [];
            $('.food-checkbox:checked').each(function() {
                selectedFoodIds.push($(this).data('food-id'));
            });
            if (selectedFoodIds.length === 0) {
                alert("Please select at least one food item.");
                return;
            }
            $('button[type="submit"]').text('Loading...').attr('disabled', true);
            $('#recipe-result').html('<div class="loading">Loading...</div>').fadeIn();
            $.ajax({
                url: '/recipe',
                method: 'POST',
                data: JSON.stringify({
                    _token: '{{ csrf_token() }}',
                    food_id: selectedFoodIds
                }),
                contentType: 'application/json',
                success: function(response) {
                    var recipeContent = $('#recipe-result');
                    if (response.recipe) {
                        var formattedRecipe = response.recipe.replace(/\n/g, '<br>');
                        recipeContent.html(formattedRecipe).fadeIn();
                    } else {
                        recipeContent.html('<p>Recipe not found.</p>').fadeIn();
                    }
                    $('button[type="submit"]').text('Generate Recipes').attr('disabled', false);
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    alert("An error occurred while generating the recipes.");
                    $('button[type="submit"]').text('Generate Recipes').attr('disabled', false);
                }
            });
        });
    });
    let foodToDelete = null;
    function deleteFood(foodId) {
        foodToDelete = foodId;
        document.getElementById('delete-confirmation').style.display = 'block';
    }
    function confirmDelete() {
        $('#delete-confirmation').html('<div class="loading">Deleting...</div>');
        if (foodToDelete !== null) {
            $.ajax({
                url: '/foods/' + foodToDelete,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE'
                },
                success: function(response) {
                    $('#delete-confirmation').html('<div class="success-message">Food deleted successfully!</div>');
                    setTimeout(function() {
                        location.reload();
                    }, 1200);
                },
                error: function(xhr, status, error) {
                    console.error("Error:", error);
                    $('#delete-confirmation').html('<div class="delete-card-content"><p>An error occurred!</p><button class="delete-cancel-button" onclick="cancelDelete()">Close</button></div>');
                }
            });
        }
    }
    function cancelDelete() {
        document.getElementById('delete-confirmation').style.display = 'none';
    }
    </script>
</body>
</html>
