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
            background: linear-gradient(135deg, #f4f7fc 0%, #ffffff 100%);
            color: #333;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            overflow-x: hidden;
        }

        h1 {
            text-align: center;
            
            color: #4caf50;
            margin-top: 40px;
            font-size: 3em;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: relative;
            padding-bottom: 10px;
        }

        ul {
            padding: 0;
            list-style-type: none;
            margin: 20px;
        }

        li {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        button[type="submit"] {
            padding: 10px 20px;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        .delete-button {
            padding: 10px 20px;
            background-color: #ff5722;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .delete-button:hover {
            background-color: #e64a19;
            transform: scale(1.05);
        }

        .recipe-content {
            background-color: #f1f1f1;
            border-radius: 8px;
            padding: 10px;
            margin-top: 10px;
            display: none;
        }

        .loading {
            text-align: center;
            font-size: 1.5em;
            color: #4caf50;
        }

        .reload-button {
            padding: 10px 20px;
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            margin-top: 20px;
        }

        .reload-button:hover {
            background-color: #e53935;
        }

        .delete-card {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 300px;
            text-align: center;
            z-index: 1000;
        }

        .delete-card-content {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .delete-confirm-button, .delete-cancel-button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            transition: background-color 0.3s ease;
        }

        .delete-confirm-button {
            background-color: #f44336;
            color: white;
        }

        .delete-confirm-button:hover {
            background-color: #e53935;
        }

        .delete-cancel-button {
            background-color: #4caf50;
            color: white;
        }

        .delete-cancel-button:hover {
            background-color: #45a049;
        }

        .success-message {
            color: green;
            font-size: 1.2em;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <button onclick="window.history.back()" style="display: block; margin: 20px 0 20px 20px; padding: 10px 20px; background-color: #4caf50; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 1em;"><</button>
    <h1>Foods</h1>

    @if(empty($foods))
        <p style="text-align: center; font-size: 1.2em; color: #ff5722;">No foods available. Please add some food items.</p>
    
    @else
        <form id="recipeForm">
            <ul>
                @foreach($foods as $food)
                    <li data-aos="fade-up">
                        <div>
                            <input type="checkbox" class="food-checkbox" data-food-id="{{ $food['id'] }}"> 
                            <strong>{{ $food['name'] }}</strong> - Expiry: {{ $food['expiry_date'] }}
                        </div>
                        <button type="button" class="delete-button" onclick="deleteFood({{ $food['id'] }})"><i class="fas fa-trash"></i> Delete</button>
                        <div id="recipe-{{ $food['id'] }}" class="recipe-content"></div>
                    </li>
                @endforeach
            </ul>
            <button type="submit" style="margin-top: 20px;">Generate Recipes</button>
        </form>
    @endif

    <button class="reload-button" onclick="location.reload()">Reload Page</button>

    <div id="recipe-result" class="recipe-content"></div>

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
                        recipeContent.html('<p>Resep tidak ditemukan.</p>').fadeIn();
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
                    }, 1500);
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
