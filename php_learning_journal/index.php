<!DOCTYPE html>
<?php
  /*
  Hello, Thanks for reviewing my project. I hope you and your loved ones are
  healthy, safe and happy during this surreal time!
  I haven't been best in writing comments for this project, though, I hope
  this success criteria block makes your review easy :D

  Thanks so much! Stay safe and healthy :D

  1. No javascript is used.
  2. Yes, I have used prepare statements to get, edit and add enteries. They are in
  the file: inc/functions.php
  3. All enteries are sorted by date in descending order and there is an option to display them
  by tags and date, with the help of 3 tags button on the homepage.
  4. Detail page displays tags and all the required data.
  5. Add/edit includes tags. You can edit an entry with the help of an option in the specific
  entry's detail page. New entries can be added with the help of New Entry button on homepage.
  6. Delete button in the detail page
  7. All styling guidelines followed!
  */


  include('inc/functions.php');
  session_start();

  //To delete an entry...
  if(isset($_POST['delete'])) {
    $deleteid = intval($_POST['delete']);
    if(Delete_Entry($deleteid)) {
      header('location: index.php?msg=Task+deleted');
      exit;
    } else {
      header('location: index.php?msg=Unable+To+delete');
      exit;
    }
  }

// An arry to store all entries
  $AllItems = [];
  if (isset($_POST['Personal'])) {
    $AllItems = Get_Entries('Personal');
  } else if (isset($_POST['Business'])) {
    $AllItems = Get_Entries('Business');
  } else if (isset($_POST['School'])) {
    $AllItems = Get_Entries('School');
  } else {
    $AllItems = Get_Entries();
  }

  // Make changes to the post methods to call the function causing changes!!!!


?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>MyJournal</title>
        <link href="https://fonts.googleapis.com/css?family=Cousine:400" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Work+Sans:600" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/site.css">
    </head>
    <style>

    </style>

    <body>
        <header>
            <div class="container">
                <div class="site-header">
                    <a class="logo" href="index.php"><i class="material-icons">library_books</i></a>
                    <a class="button icon-right" href="new.php"><span>New Entry</span> <i class="material-icons">add</i></a>
                    <form action='index.php' method='POST'>
                      <input type="submit" name="Personal" value="Personal" class="button icon-right">
                      <input type="submit" name="Business" value="Business" class="button icon-right">
                      <input type="submit" name="School" value="School" class="button icon-right">
                    </form>
        </header>
    </div>
</div>
        <section>
            <div class="container">
                <div class="entry-list">
                  <?php
                  foreach ($AllItems as $item) {
                        echo get_item_html($item);
                      }
                  ?>
                </div>
            </div>
        </section>
        <footer>
            <div>
                &copy; MyJournal
            </div>
        </footer>
    </body>
</html>
