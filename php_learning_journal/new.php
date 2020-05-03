<!DOCTYPE html>
<?php

include('inc/functions.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
  $date = trim(filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING));
  $time_spent = filter_input(INPUT_POST, 'timeSpent', FILTER_SANITIZE_NUMBER_INT);
  $learned = trim(filter_input(INPUT_POST, 'whatILearned', FILTER_SANITIZE_STRING));
  $resources = trim(filter_input(INPUT_POST, 'ResourcesToRemember', FILTER_SANITIZE_STRING));
  $tags = trim(filter_input(INPUT_POST, 'tags', FILTER_SANITIZE_STRING));
  $dateMatch = explode('-',$date);
  var_dump($dateMatch);
  $Resources = [];

  if (empty($title) || empty($date) || empty($time_spent) || empty($learned)|| empty($resources)|| empty($tags)) {
      $error_message = 'Please fill in the required fields';
  } elseif (count($dateMatch) != 3
             || strlen($dateMatch[2]) != 2 // Day
             || strlen($dateMatch[1]) != 2 // Month
             || strlen($dateMatch[0]) != 4 // Year
             || !checkdate($dateMatch[1],$dateMatch[2], $dateMatch[0])) {
        $error_message = 'Invalid Date';
    } else {
      $date = $dateMatch[0] . '-' . $dateMatch[1] . '-' . $dateMatch[2];
    if (New_Entry($title, $date, $time_spent, $learned, $resources, $tags)) {
        header('Location: index.php');
        exit;
    } else {
        $error_message = 'Could not add task';
    }
    }
}

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
    <body>
        <header>
            <div class="container">
                <div class="site-header">
                    <a class="logo" href="index.php"><i class="material-icons">library_books</i></a>
                    <a class="button icon-right" href="new.php"><span>New Entry</span> <i class="material-icons">add</i></a>
                </div>
            </div>
        </header>
        <section>
            <div class="container">
                <div class="new-entry">
                    <h2>New Entry</h2>
                    <?php echo "<p> $error_message </p>" ?>
                    <form action='new.php' method='POST'>
                        <label for="title"> Title</label>
                        <input id="title" type="text" name="title"><br>
                        <label for="date">Date</label>
                        <input id="date" type="date" name="date"><br>
                        <label for="time-spent"> Time Spent</label>
                        <input id="title" type="text" name="timeSpent"><br>
                        <label for="what-i-learned">What I Learned</label>
                        <textarea id="what-i-learned" rows="5" name="whatILearned"></textarea>
                        <label for="resources-to-remember">Resources to Remember</label>
                        <textarea id="resources-to-remember" rows="5" name="ResourcesToRemember"></textarea>
                        <label for="title"> Tags</label>
                        <select style="width: 100%; height: 50px;" name="tags">
                        <option value="Personal">Personal</option>
                        <option value="Business">Business</option>
                        <option value="School">School</option>
                        </select><br><br>

                        <input type="submit" value="Publish Entry" class="button">
                        <a href="#" class="button button-secondary">Cancel</a>
                    </form>
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
