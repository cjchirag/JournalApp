<!DOCTYPE html>
<?php
include("inc/functions.php");
session_start();
if(isset($_GET['id'])) {
  $id = $_GET['id'];
  var_dump($_SESSION['id']);
  $Entry = Get_Entry($id);
} else {
  $error_message = 'Cannot find the journal entry';
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  //To retreive all the input data from the user. Optional if they have content or not.
  $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
  $globaltest = $title;
  $date = trim(filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING));
  $time_spent = filter_input(INPUT_POST, 'timeSpent', FILTER_SANITIZE_NUMBER_INT);
  $learned = trim(filter_input(INPUT_POST, 'whatILearned', FILTER_SANITIZE_STRING));
  $resources = trim(filter_input(INPUT_POST, 'ResourcesToRemember', FILTER_SANITIZE_STRING));
  $tags = trim(filter_input(INPUT_POST, 'tags', FILTER_SANITIZE_STRING));
  $number_id = $_SESSION['id'];
  var_dump($number_id);
  $dateMatch = explode('-',$date);

// To check if the fields contains data.
    if (empty($title) || empty($date) || empty($time_spent) || empty($learned)|| empty($resources)|| empty($tags)) {
        $error_message = 'Please fill in the required fields';
    } else {
      // Data validation for dates
      if (count($dateMatch) != 3
                 || strlen($dateMatch[2]) != 2 // Day
                 || strlen($dateMatch[1]) != 2 // Month
                 || strlen($dateMatch[0]) != 4 // Year
                 || !checkdate($dateMatch[1],$dateMatch[2], $dateMatch[0])) {
            $error_message = 'Invalid Date';
        } else {
        $date = $dateMatch[0] . '-' . $dateMatch[1] . '-' . $dateMatch[2];
        if (New_Entry($title, $date, $time_spent, $learned, $resources, $tags, $_SESSION['id'])){
            header("Location: detail.php?id=" . $_GET['id'] . "");
            exit;
        } else {
            $error_message = 'Could not add task';
        }
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
                    <a class="logo" href="index.html"><i class="material-icons">library_books</i></a>
                    <a class="button icon-right" href="new.php"><span>New Entry</span> <i class="material-icons">add</i></a>
                </div>
            </div>
        </header>
        <section>
            <div class="container">
                <div class="edit-entry">
                    <h2>Edit Entry</h2>
                    <?php echo $error_message ?>
                    <form method='POST' action='edit.php?id="<?php echo $id ?>"'>
                        <label for="title"> Title</label>
                        <input id="title" type="text" name="title" value="<?php echo $Entry['title']?>"><br>
                        <label for="date">Date</label>
                        <input id="date" type="date" name="date" value="<?php echo $Entry['entrydate']?>"><br>
                        <label for="time-spent"> Time Spent</label>
                        <input id="timeSpent" type="text" name="timeSpent" value="<?php echo $Entry['time_spent']?>"><br>
                        <label for="what-i-learned">What I Learned</label>
                        <textarea id="whatILearned" rows="5" name="whatILearned"><?php echo $Entry['learned']?></textarea>
                        <label for="resources-to-remember">Resources to Remember</label>
                        <textarea id="ResourcesToRemember" rows="5" name="ResourcesToRemember"><?php echo $Entry['resources']?></textarea>
                        <label for="title"> Tags</label>
                        <input id="title" type="text" name="tags" value="<?php echo $Entry['tags']?>"><br>
                        <input type="submit" value="Make Changes" class="button">
                        <a href='detail.php?id="<?php echo $id ?>"' class="button button-secondary">Cancel</a>
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
