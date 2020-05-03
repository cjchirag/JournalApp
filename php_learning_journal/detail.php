<!DOCTYPE html>
<?php
include("inc/functions.php");
session_start();
$_POST['deleteid'] = null;

if (isset($_GET['id'])) {
    $journal_id = intval(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT));
    $_SESSION['id'] = $journal_id;
    list($journal_title, $journal_date, $journal_time_spent, $journal_learned, $journal_resources, $journal_tags) = Get_Entry(filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT));
}
if (empty($_GET['id'])) {
    exit;
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
                <div class="entry-list single">
                    <article>
                        <h1><?php echo $journal_title; ?></h1>
                        <time datetime="2016-01-31"><?php echo $journal_date; ?></time>
                        <div class="entry">
                            <h3>Time Spent: </h3>
                            <p><?php echo $journal_time_spent; ?></p>
                        </div>
                        <div class="entry">
                            <h3>What I Learned:</h3>
                            <p><?php echo $journal_learned; ?></p>
                        </div>
                        <div class="entry">
                            <h3>Resources to Remember:</h3>
                            <p><?php echo $journal_resources; ?></p>
                        </div>
                        <p><?php echo $journal_tags; ?></p>
                    </article>
                </div>
            </div>
            <div class="edit">
                <?php
              echo "<p><a href='edit.php?id=" . $journal_id . "'>Edit Entry</a></p>";
              echo "<form method='post' action='index.php' onsubmit=\"return confirm('Are you sure you want to delete this note?');\">\n"
              . "<input type='hidden' value=$journal_id name='delete' />\n"
              . "<input type='submit' class='button' value='Delete' />\n"
              . "</form>";
                ?>
            </div>
        </section>
        <footer>
            <div>
                &copy; MyJournal
            </div>
        </footer>
    </body>
</html>
