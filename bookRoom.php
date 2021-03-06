<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width">

    <title>Meeting Rooms – Make a Booking</title>

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
        integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
        integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
        crossorigin="anonymous"></script>
</head>

<body>
	<div id="main-container" class="container">
        <?php
            $roomNo = $_GET['roomNo'];
        ?>
        
		<h1 class="display-4"><?php
            echo "Booking " . $roomNo;
        ?> </h1>
        
		<form id='addBookingForm'>

			<div class="form-group">
				<label for="name">Your Name:</label>
				<input type="text" class="form-control" id="name" aria-describedby="emailHelp" placeholder="Enter your name">
			</div>

			<div class="form-group">
				<label for="email">Your Email:</label>
				<input type="text" class="form-control" id="email" placeholder="Enter your email">
			</div>

			<div class="form-group">
				<label for="date">Date of Booking:</label>
				<input type="date" class="form-control" id="date">
                <!-- write a script that retrieves all available dates instead -->
			</div>

			<div class="form-group">
				<label for="pax">Number of People:</label><br />
				<select name = "select" class="form-control" id="pax">
                    <option value="1"> 1 person </option>
                    <option value="2"> 2 people </option>
                    <option value="3"> 3 people </option>
                    <option value="4"> 4 people </option>
                    <option value="5"> 5 people </option>
                    <option value="6"> 6 people </option>
                    <option value="7"> 7 people </option>
                    <option value="8"> 8 people </option>
                    <option value="9"> 9 people </option>
                    <option value="10"> 10 people </option>
                </select>
			</div>
			<button type="submit" class="btn btn-primary">Submit</button>
		</form>
		<label id="error" class="text-danger"></label>
	</div>
</body>
<script>
    // Helper function to display error message
    function showError(message) {
        // Display an error under the the predefined label with error as the id
        $('#error').text(message);
    }

    $("#addBookingForm").submit(async (event) => {
        //Prevents screen from refreshing when submitting
        event.preventDefault();

		const serviceURL = './addNewBooking.php'

        //Get form data 
        const roomNo = <?php echo $roomNo; ?>
        const name = $('#name').val();
        const email = $('#email').val();
        const date = parseFloat($('#date').val());
        const pax = parseInt($("#pax").val());

        try {
            const response =
                await fetch(
                    serviceURL, {
                    method: 'POST',
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ roomNo: roomNo, name: name, email: email, date: date, pax: pax })
                });
            const data = await response.json();

            if (response.ok) {
                // relocate to home page
                window.location.replace("./");
                return false;
            } else {
                console.log(data);
                showError(data.message);
            }
        } catch (error) {
            // Errors when calling the service; such as network error, 
            // service offline, etc
            showError
                ("There was a problem making this game. Please try again later. " + error);

        } // error
    });
</script>
</html>