<?php

namespace App\Classes;

use PDO;

class Visit
{
  public $dbcon;

  public function __construct()
  {
    $database = new Database();
    $this->dbcon = $database->getConnection();
  }

  public function hello()
  {
    return "Visit CLASS";
  }

  public function customer_count($data)
  {
    $sql = "SELECT COUNT(*) FROM visit.customer WHERE user = ? AND name = ? AND status = 1";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt->fetchColumn();
  }

  public function customer_create($data)
  {
    $sql = "INSERT INTO visit.customer(`uuid`, `user`, `name`, `contact`, `project`) VALUES(uuid(),?,?,?,?)";
    $stmt = $this->dbcon->prepare($sql);
    return $stmt->execute($data);
  }

  public function customer_view($data)
  {
    $sql = "SELECT * FROM visit.customer a
    WHERE a.uuid = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt->fetch();
  }

  public function customer_update($data)
  {
    $sql = "UPDATE visit.customer SET 
    user = ?,
    name = ?,
    contact = ?,
    project = ?,
    updated = NOW()
    WHERE id = ?";
    $stmt = $this->dbcon->prepare($sql);
    return $stmt->execute($data);
  }

  public function request_count($data)
  {
    $sql = "SELECT COUNT(*) FROM visit.request WHERE customer_id = ? AND remark = ? AND status = 1";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt->fetchColumn();
  }

  public function request_create($data)
  {
    $sql = "INSERT INTO visit.request(`uuid`, `user_id`, `type`, `customer_id`, `reason`, `remark`, `latitude`, `longitude`) VALUES(uuid(),?,?,?,?,?,?,?)";
    $stmt = $this->dbcon->prepare($sql);
    return $stmt->execute($data);
  }

  public function request_view($data)
  {
    $sql = "SELECT a.id,a.`uuid`,a.user_id,
    b.firstname,CONCAT(b.firstname,' ',b.lastname) fullname,
    a.`type`,a.customer_id,a.latitude,a.longitude,
    c.`user` customer_user,c.`name` customer_name,c.contact customer_contact,c.project customer_project,a.reason,
    (
      CASE
        WHEN a.type = 1 THEN 'ลูกค้าใหม่'
        WHEN a.type = 2 THEN 'ลูกค้าเก่า'
        ELSE NULL 
      END
    ) type_name,
    (
      CASE
        WHEN a.reason = 1 THEN 'นำเสนอ'
        WHEN a.reason = 2 THEN 'คุยงาน'
        WHEN a.reason = 3 THEN 'เสนอราคา'
        ELSE NULL 
      END
    ) reason_name,
    (
      CASE
        WHEN a.reason = 1 THEN 'primary'
        WHEN a.reason = 2 THEN 'success'
        WHEN a.reason = 3 THEN 'danger'
        ELSE NULL 
      END
    ) reason_color,a.remark,a.`status`,
    DATE_FORMAT(a.created,'%d/%m/%Y, %H:%i น.') created
    FROM visit.request a
    LEFT JOIN visit.`user` b
    ON a.user_id = b.login
    LEFT JOIN visit.customer c
    ON a.customer_id = c.id 
    WHERE a.`uuid` = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt->fetch();
  }

  public function request_update($data)
  {
    $sql = "UPDATE visit.request SET 
    reason = ?,
    remark = ?,
    updated = NOW()
    WHERE uuid = ?";
    $stmt = $this->dbcon->prepare($sql);
    return $stmt->execute($data);
  }

  public function request_delete($data)
  {
    $sql = "UPDATE visit.request SET 
    status = 0,
    updated = NOW()
    WHERE id = ?";
    $stmt = $this->dbcon->prepare($sql);
    return $stmt->execute($data);
  }

  public function request_export()
  {
    $sql = "SELECT b.firstname,
    (
      CASE
        WHEN a.reason = 1 THEN 'นำเสนอ'
        WHEN a.reason = 2 THEN 'คุยงาน'
        WHEN a.reason = 3 THEN 'เสนอราคา'
        ELSE NULL 
      END
    ) reason_name,
    c.`user` customer_user,c.`name` customer_name,c.contact customer_contact,c.project customer_project,a.remark,
    DATE_FORMAT(a.created,'%d/%m/%Y, %H:%i น.') created
    FROM visit.request a
    LEFT JOIN visit.`user` b
    ON a.user_id = b.login
    LEFT JOIN visit.customer c
    ON a.customer_id = c.id
    WHERE a.status = 1";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_NUM);
  }

  public function auth_count($data)
  {
    $sql = "SELECT COUNT(*) FROM visit.auth WHERE user_id = ? AND status = 1";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt->fetchColumn();
  }

  public function auth_create($data)
  {
    $sql = "INSERT INTO visit.auth(`user_id`) VALUES(?)";
    $stmt = $this->dbcon->prepare($sql);
    return $stmt->execute($data);
  }

  public function auth_delete($data)
  {
    $sql = "UPDATE visit.auth SET 
    status = 0,
    updated = NOW()
    WHERE id = ?";
    $stmt = $this->dbcon->prepare($sql);
    return $stmt->execute($data);
  }

  public function request_data()
  {
    $sql = "SELECT COUNT(*) FROM visit.request";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute();
    $total = $stmt->fetchColumn();

    $column = ["a.id", "a.name", "a.token"];

    $keyword = (isset($_POST['search']['value']) ? trim($_POST['search']['value']) : '');
    $filter_order = (isset($_POST['order']) ? $_POST['order'] : '');
    $order_column = (isset($_POST['order']['0']['column']) ? $_POST['order']['0']['column'] : '');
    $order_dir = (isset($_POST['order']['0']['dir']) ? $_POST['order']['0']['dir'] : '');
    $limit_start = (isset($_POST['start']) ? $_POST['start'] : '');
    $limit_length = (isset($_POST['length']) ? $_POST['length'] : '');
    $draw = (isset($_POST['draw']) ? $_POST['draw'] : '');

    $sql = "SELECT a.id,a.`uuid`,b.firstname,CONCAT(b.firstname,' ',b.lastname) fullname,a.remark,
    c.`user` customer_user,c.`name` customer_name,c.project customer_project,
    (
      CASE
        WHEN a.reason = 1 THEN 'นำเสนอ'
        WHEN a.reason = 2 THEN 'คุยงาน'
        WHEN a.reason = 3 THEN 'เสนอราคา'
        ELSE NULL 
      END
    ) reason_name,
    (
      CASE
        WHEN a.reason = 1 THEN 'primary'
        WHEN a.reason = 2 THEN 'success'
        WHEN a.reason = 3 THEN 'danger'
        ELSE NULL 
      END
    ) reason_color,
    (
      CASE
        WHEN a.status = 1 THEN 'รายละเอียด'
        WHEN a.status = 2 THEN 'ระงับการใช้งาน'
        ELSE NULL 
      END
    ) status_name,
    (
      CASE
        WHEN a.status = 1 THEN 'success'
        WHEN a.status = 2 THEN 'danger'
        ELSE NULL 
      END
    ) status_color,
    DATE_FORMAT(a.created,'%d/%m/%Y, %H:%i น.') created
    FROM visit.request a
    LEFT JOIN visit.`user` b
    ON a.user_id = b.login
    LEFT JOIN visit.customer c
    ON a.customer_id = c.id
    WHERE a.status = 1 ";

    if ($keyword) {
      $sql .= " AND (a.remark LIKE '%{$keyword}%' OR b.firstname LIKE '%{$keyword}%' OR c.user LIKE '%{$keyword}%' OR c.name LIKE '%{$keyword}%' OR c.contact LIKE '%{$keyword}%' OR c.project LIKE '%{$keyword}%') ";
    }

    if ($filter_order) {
      $sql .= " ORDER BY {$column[$order_column]} {$order_dir} ";
    } else {
      $sql .= " ORDER BY a.status ASC,a.created DESC ";
    }

    $sql2 = "";
    if ($limit_length) {
      $sql2 .= "LIMIT {$limit_start}, {$limit_length}";
    }

    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute();
    $filter = $stmt->rowCount();
    $stmt = $this->dbcon->prepare($sql . $sql2);
    $stmt->execute();
    $result = $stmt->fetchAll();

    $data = [];
    foreach ($result as $row) {
      $action = "<a href='/visit/view/{$row['uuid']}' class='badge badge-{$row['status_color']} font-weight-light'>{$row['status_name']}</a>";
      $reason = "<a href='javascript:void(0)' class='badge badge-{$row['reason_color']} font-weight-light'>{$row['reason_name']}</a>";
      $data[] = [
        $action,
        $row['fullname'],
        $reason,
        $row['customer_user'],
        $row['customer_name'],
        $row['customer_project'],
        str_replace("\n", "<br>", $row['remark']),
        str_replace(",", "<br>", $row['created']),
      ];
    }

    $output = [
      "draw"    => $draw,
      "recordsTotal"  =>  $total,
      "recordsFiltered" => $filter,
      "data"    => $data
    ];

    return $output;
  }

  public function manage_data()
  {
    $sql = "SELECT COUNT(*) FROM visit.request";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute();
    $total = $stmt->fetchColumn();

    $column = ["a.id", "a.name", "a.token"];

    $keyword = (isset($_POST['search']['value']) ? trim($_POST['search']['value']) : '');
    $filter_order = (isset($_POST['order']) ? $_POST['order'] : '');
    $order_column = (isset($_POST['order']['0']['column']) ? $_POST['order']['0']['column'] : '');
    $order_dir = (isset($_POST['order']['0']['dir']) ? $_POST['order']['0']['dir'] : '');
    $limit_start = (isset($_POST['start']) ? $_POST['start'] : '');
    $limit_length = (isset($_POST['length']) ? $_POST['length'] : '');
    $draw = (isset($_POST['draw']) ? $_POST['draw'] : '');

    $sql = "SELECT a.id,a.`uuid`,b.firstname,CONCAT(b.firstname,' ',b.lastname) fullname,a.remark,
    c.`user` customer_user,c.`name` customer_name,c.project customer_project,
    (
      CASE
        WHEN a.reason = 1 THEN 'นำเสนอ'
        WHEN a.reason = 2 THEN 'คุยงาน'
        WHEN a.reason = 3 THEN 'เสนอราคา'
        ELSE NULL 
      END
    ) reason_name,
    (
      CASE
        WHEN a.reason = 1 THEN 'primary'
        WHEN a.reason = 2 THEN 'success'
        WHEN a.reason = 3 THEN 'danger'
        ELSE NULL 
      END
    ) reason_color,
    (
      CASE
        WHEN a.status = 1 THEN 'รายละเอียด'
        WHEN a.status = 2 THEN 'ระงับการใช้งาน'
        ELSE NULL 
      END
    ) status_name,
    (
      CASE
        WHEN a.status = 1 THEN 'success'
        WHEN a.status = 2 THEN 'danger'
        ELSE NULL 
      END
    ) status_color,
    DATE_FORMAT(a.created,'%d/%m/%Y, %H:%i น.') created
    FROM visit.request a
    LEFT JOIN visit.`user` b
    ON a.user_id = b.login
    LEFT JOIN visit.customer c
    ON a.customer_id = c.id
    WHERE a.status = 1 ";

    if ($keyword) {
      $sql .= " AND (a.remark LIKE '%{$keyword}%' OR b.firstname LIKE '%{$keyword}%' OR c.user LIKE '%{$keyword}%' OR c.name LIKE '%{$keyword}%' OR c.contact LIKE '%{$keyword}%' OR c.project LIKE '%{$keyword}%') ";
    }

    if ($filter_order) {
      $sql .= " ORDER BY {$column[$order_column]} {$order_dir} ";
    } else {
      $sql .= " ORDER BY a.status ASC,a.created DESC ";
    }

    $sql2 = "";
    if ($limit_length) {
      $sql2 .= "LIMIT {$limit_start}, {$limit_length}";
    }

    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute();
    $filter = $stmt->rowCount();
    $stmt = $this->dbcon->prepare($sql . $sql2);
    $stmt->execute();
    $result = $stmt->fetchAll();

    $data = [];
    foreach ($result as $row) {
      $action = "<a href='/visit/edit/{$row['uuid']}' class='badge badge-{$row['status_color']} font-weight-light'>{$row['status_name']}</a> <a href='javascript:void(0)' class='badge badge-danger font-weight-light btn-delete' id='{$row['id']}'>ลบ</a>";
      $reason = "<a href='javascript:void(0)' class='badge badge-{$row['reason_color']} font-weight-light'>{$row['reason_name']}</a>";
      $data[] = [
        $action,
        $row['fullname'],
        $reason,
        $row['customer_user'],
        $row['customer_name'],
        $row['customer_project'],
        str_replace("\n", "<br>", $row['remark']),
        str_replace(",", "<br>", $row['created']),
      ];
    }

    $output = [
      "draw"    => $draw,
      "recordsTotal"  =>  $total,
      "recordsFiltered" => $filter,
      "data"    => $data
    ];

    return $output;
  }

  public function auth_data()
  {
    $sql = "SELECT COUNT(*) FROM visit.auth";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute();
    $total = $stmt->fetchColumn();

    $column = ["a.id", "a.name", "a.token"];

    $keyword = (isset($_POST['search']['value']) ? trim($_POST['search']['value']) : '');
    $filter_order = (isset($_POST['order']) ? $_POST['order'] : '');
    $order_column = (isset($_POST['order']['0']['column']) ? $_POST['order']['0']['column'] : '');
    $order_dir = (isset($_POST['order']['0']['dir']) ? $_POST['order']['0']['dir'] : '');
    $limit_start = (isset($_POST['start']) ? $_POST['start'] : '');
    $limit_length = (isset($_POST['length']) ? $_POST['length'] : '');
    $draw = (isset($_POST['draw']) ? $_POST['draw'] : '');

    $sql = "SELECT a.id,a.user_id,b.firstname,CONCAT(b.firstname,' ',b.lastname) fullname
    FROM visit.auth a
    LEFT JOIN visit.`user` b
    ON a.user_id = b.login
    WHERE a.status = 1 ";

    if ($keyword) {
      $sql .= " AND (b.firstname LIKE '%{$keyword}%' OR b.lastname LIKE '%{$keyword}%') ";
    }

    if ($filter_order) {
      $sql .= " ORDER BY {$column[$order_column]} {$order_dir} ";
    } else {
      $sql .= " ORDER BY a.created DESC ";
    }

    $sql2 = "";
    if ($limit_length) {
      $sql2 .= "LIMIT {$limit_start}, {$limit_length}";
    }

    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute();
    $filter = $stmt->rowCount();
    $stmt = $this->dbcon->prepare($sql . $sql2);
    $stmt->execute();
    $result = $stmt->fetchAll();

    $data = [];
    foreach ($result as $row) {
      $action = "<a href='javascript:void(0)' class='badge badge-danger font-weight-light btn-delete' id='{$row['id']}'>ลบ</a>";
      $data[] = [
        $action,
        $row['fullname'],
      ];
    }

    $output = [
      "draw"    => $draw,
      "recordsTotal"  =>  $total,
      "recordsFiltered" => $filter,
      "data"    => $data
    ];

    return $output;
  }

  public function customer_data()
  {
    $sql = "SELECT COUNT(*) FROM visit.customer";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute();
    $total = $stmt->fetchColumn();

    $column = ["a.id", "a.name", "a.token"];

    $keyword = (isset($_POST['search']['value']) ? trim($_POST['search']['value']) : '');
    $filter_order = (isset($_POST['order']) ? $_POST['order'] : '');
    $order_column = (isset($_POST['order']['0']['column']) ? $_POST['order']['0']['column'] : '');
    $order_dir = (isset($_POST['order']['0']['dir']) ? $_POST['order']['0']['dir'] : '');
    $limit_start = (isset($_POST['start']) ? $_POST['start'] : '');
    $limit_length = (isset($_POST['length']) ? $_POST['length'] : '');
    $draw = (isset($_POST['draw']) ? $_POST['draw'] : '');

    $sql = "SELECT * FROM visit.customer a
    WHERE a.`status` = 1 ";

    if ($keyword) {
      $sql .= " AND (a.user LIKE '%{$keyword}%' OR a.name LIKE '%{$keyword}%' OR a.contact LIKE '%{$keyword}%' OR a.project LIKE '%{$keyword}%') ";
    }

    if ($filter_order) {
      $sql .= " ORDER BY {$column[$order_column]} {$order_dir} ";
    } else {
      $sql .= " ORDER BY a.name ASC ";
    }

    $sql2 = "";
    if ($limit_length) {
      $sql2 .= "LIMIT {$limit_start}, {$limit_length}";
    }

    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute();
    $filter = $stmt->rowCount();
    $stmt = $this->dbcon->prepare($sql . $sql2);
    $stmt->execute();
    $result = $stmt->fetchAll();

    $data = [];
    foreach ($result as $row) {
      $action = "<a href='/customer/view/{$row['uuid']}' class='badge badge-success font-weight-light'>รายละเอียด</a> <a href='javascript:void(0)' class='badge badge-danger font-weight-light btn-delete' id='{$row['id']}'>ลบ</a>";
      $data[] = [
        $action,
        $row['user'],
        $row['name'],
        $row['contact'],
        $row['project'],
      ];
    }

    $output = [
      "draw"    => $draw,
      "recordsTotal"  =>  $total,
      "recordsFiltered" => $filter,
      "data"    => $data
    ];

    return $output;
  }

  public function user_select($keyword)
  {
    $sql = "SELECT a.login `id`,CONCAT(a.firstname,' ',a.lastname) `text`
    FROM visit.user a
    LEFT JOIN visit.login b
    ON a.login = b.id
    WHERE b.status = 1 ";
    if (!empty($keyword)) {
      $sql .= " AND (a.firstname LIKE '%{$keyword}%' OR a.lastname LIKE '%{$keyword}%' OR a.contact LIKE '%{$keyword}%') ";
    }
    $sql .= " ORDER BY a.firstname ASC LIMIT 20";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  public function customer_select($keyword)
  {
    $sql = "SELECT a.id,CONCAT(a.user,' [',a.name,']') `text`
    FROM visit.customer a
    WHERE a.`status` = 1 ";
    if (!empty($keyword)) {
      $sql .= " AND (a.user LIKE '%{$keyword}%' OR a.name LIKE '%{$keyword}%' OR a.contact LIKE '%{$keyword}%') ";
    }
    $sql .= " ORDER BY a.user ASC LIMIT 20";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  public function customer_detail($data)
  {
    $sql = "SELECT a.user,a.`name`,a.contact,a.project
    FROM visit.customer a
    WHERE a.id = ?";
    $stmt = $this->dbcon->prepare($sql);
    $stmt->execute($data);
    return $stmt->fetch();
  }


  public function last_insert_id()
  {
    return $this->dbcon->lastInsertId();
  }
}
