<?php
	// $url = $_ENV['room_service_url'] . "/room"; // update when dev.env is created 
    $url = "http://localhost:8080/room";  ///test test
    
?>

    
    <!DOCTYPE html>
    <html>
    
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width">
    
        <title>HomePage: View Meeting Rooms</title>
    
        <link rel="stylesheet" href="">
        <!--[if lt IE 9]>
          <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <!-- Bootstrap libraries -->
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
            integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    
        <!-- Latest compiled and minified JavaScript -->
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
            integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
            crossorigin="anonymous"></script>
    
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
            integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
            crossorigin="anonymous"></script>
    </head>
    
    <body>
        <div id="main-container" class="container">
            <h1 class="display-4">Meeting Rooms &#128187;</h1>

            <!-- test -->
            <a href = "bookRoom.php"> <button>bookRoom.php</button></a>

            <table id="roomTable" class='table table-striped' border='1'>
                <thead class='thead-dark'>
                    <tr>
                        <!-- room id -->
                        <th>Room No</th> 
                        <th>Level</th>
                        <th>Price</th>
                        <th>Capacity</th>
                        <th>Book</th>
                    </tr>
                </thead>
            </table>
        </div>
    
        <script>
            // // Helper function to display error message
            // function showError(message) {
            //     // Hide the table and button in the event of error
            //     $('#roomTable').hide();
    
            //     // Display an error under the main container
            //     $('#main-container')
            //         .append("<label>" + message + "</label>");
            // }
    
            // anonymous async function - using await requires the function that calls it to be async
            $(async () => {
                // Change serviceURL to your own
                const serviceURL = "<?php echo $url; ?>";
    
                try {
                    const response =
                        await fetch(
                            serviceURL, { mode: 'cors', method: 'GET' }
                        ); //send GET request to /room
                    const result = await response.json();
                    if (response.status === 200) {
                        // success case
                        const rooms = result.data.rooms;
    
                        // for loop to setup all table rows with obtained game data
                        let rows = "";
                        for (const room of rooms) {
                            eachRow =
                                '<td>' + room.roomNo + '</td>' +
                                '<td>' + room.level + '</td>' +
                                '<td>' + room.price + '</td>' +
                                '<td>' + room.capacity + '</td>' +
                                '<td><a href="bookRoom.php?roomNo=' + room.roomNo + '" style="text-decoration: none;">book;</a></td>';
                            rows += '<tbody><tr>' + eachRow + '</tr></tbody>';
                        }
                        // add all the rows to the table
                        $('#roomTable').append(rows);
    
                    } else if (response.status == 404) {
                        // No rooms
                        showError
                            (result.message);
                    } else {
                        // unexpected outcome, throw the error
                        throw response.status;
                    }
    
                } catch (error) {
                    // Errors when calling the service; such as network error, 
                    // service offline, etc
                    showError
                        ('There is a problem retrieving the rooms, please try again later.<br />' + error);
    
                } // error
            });
        </script>
    </body>
    
    </html>