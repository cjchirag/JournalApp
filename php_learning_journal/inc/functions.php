
<?php
function Get_Entries($tags=null) {
  include('inc/connection.php');

  // A special call if the user wishes to see specific enteries of a tag.
  if ($tags) {
    $sql = 'SELECT * FROM entries WHERE tags = ? ORDER BY Date(entrydate) DESC';
  } else {
  $sql = 'SELECT * FROM entries ORDER BY Date(entrydate) DESC';
  }

  try {
      $result = $db->prepare($sql);
      if ($tags) {
      $result->bindParam(1, $tags, PDO::PARAM_STR);
      }
      $result->execute();
      return $result->fetchAll();
  } catch (Exception $e) {
      echo "Error!: " . $e->getMessage() . "<br />";
      return array();
  }
}

function Get_Entry($id, $tags=null) {
  include('inc/connection.php');

  if ($tags) {
    $sql = 'SELECT title, entrydate, time_spent, learned, resources, tags FROM entries WHERE id = ? AND tags = ?';
  } else {
    $sql = 'SELECT title, entrydate, time_spent, learned, resources, tags FROM entries WHERE id = ?';
  }

  try {
      $result = $db->prepare($sql);
      $result->bindParam(1, $id, PDO::PARAM_INT);
      if ($tags) {
      $result->bindParam(2, $tags, PDO::PARAM_STR);
      }
      $result->execute();
      return $result->fetch();
    } catch (Exception $e) {
      echo "Error!: " . $e->getMessage() . "<br />";
      return array();
    }
}

function New_Entry($title, $date, $time_spent, $learned, $resources, $tags, $journal_id=null) {
  include('inc/connection.php');
  if ($journal_id) {
        $sql = 'UPDATE entries SET title = ?, entrydate = ?, time_spent = ?, learned = ?, resources = ?, tags = ? WHERE id = ?';
    } else {
        $sql = 'INSERT INTO entries(title, entrydate, time_spent, learned, resources, tags) VALUES(?, ?, ?, ?, ?, ?)';
    }


  try {
        $results = $db->prepare($sql);
        $results->bindValue(1, $title, PDO::PARAM_STR);
        $results->bindValue(2, $date, PDO::PARAM_STR);
        $results->bindValue(3, $time_spent, PDO::PARAM_INT);
        $results->bindValue(4, $learned, PDO::PARAM_STR);
        $results->bindValue(5, $resources, PDO::PARAM_STR);
        $results->bindValue(6, $tags, PDO::PARAM_STR);
        if($journal_id) {
          $results->bindValue(7, $journal_id, PDO::PARAM_INT);
        }
        $results->execute();
    } catch (Exception $e) {
        echo "Error!: " . $e->getMessage() . "<br />";
        return false;
    }
    return true;
}


function Delete_Entry($id) {
include('inc/connection.php');

  $sql = 'DELETE FROM entries WHERE id = ?';
  try {
      $results = $db->prepare($sql);
      $results->bindValue(1, $id);
      $results->execute();
  } catch (Exception $e) {
      echo "Error!: " . $e->getMessage() . "<br />";
      return false;
  }
  return true;
}

function Get_Tags() {
  include('inc/connection.php');
  $sql = 'SELECT tags FROM entries';
  try {
    $result = $db->prepare($sql);
    $result->execute();
    return $result->fetchAll();
  } catch (Exception $e) {
    echo "Error!: " . $e->getMessage() . "<br />";
    return array();
  }
}

function get_item_html($item) {
    $output = "<article><h2><a href='detail.php?id="
        . $item["id"] . "'>"
        . $item["title"]
        . "</a></h2>"
        . "<p>" . $item['entrydate'] . "</p></article>";
    return $output;
}
?>
