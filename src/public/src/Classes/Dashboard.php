<?php

namespace App\Classes;

use PDO;

class Dashboard
{
  private $dbcon;

  public function __construct()
  {
    $db = new Database();
    $this->dbcon = $db->getConnection();
  }

  public function hello()
  {
    return "Dashboard CLASS";
  }

  public function dashboard_card()
  {
    $sql = "SELECT COUNT(*) request,
    (SELECT COUNT(*) FROM visit.`subject` WHERE `type` = 1) `primary`,
    (SELECT COUNT(*) FROM visit.`subject` WHERE `type` = 2) subject,
    (SELECT COUNT(*) FROM visit.`group`) `group`,
    (SELECT COUNT(*) FROM visit.`field`) `field`,
    (SELECT COUNT(*) FROM visit.`department`) `department`,
    (SELECT COUNT(*) FROM visit.`zone`) `zone`,
    (SELECT COUNT(*) FROM visit.`branch`) `branch`,
    (SELECT COUNT(*) FROM visit.`position`) `position`
    FROM visit.directory_request";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute();
    return $stmt->fetch();
  }
}
