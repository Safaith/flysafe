<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact</title>
  <link rel="stylesheet" href="contact.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>
  <div class="wrapper">
    <header>Contact us</header>
    <form action="#">
      <div class="dbl-field">
        <div class="field">
          <input type="text" name="name" placeholder="Enter your name">
          <i class='fas fa-user'></i>
        </div>
        <div class="field">
          <input type="text" name="email" placeholder="Enter your email">
          <i class='fas fa-envelope'></i>
        </div>
      </div>

      <div class="message">
        <textarea placeholder="Write your message" name="message"></textarea>
      </div>
      <div class="button-area">
        <button type="submit">Send Message</button>
        <span></span>
      </div>
    </form>
  </div>

  <script src="contact.js"></script>

</body>
</html>
