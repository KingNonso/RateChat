<?php

    class Database {

        private static $_instance = null;
        private $_pdo,
            $_query,
            $_error = false,
            $_results,
            $_result_assoc,
            $_json_data,
            $_count = 0,
            $_count_assoc = 0;
        public static $today, $nextYr;

        private function __construct() {
            try {
                $this->_pdo = new PDO('mysql:host=' . Config::get('mysql/host') . ';dbname=' . Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
            } catch (PDOException $e) {
                die($e->getMessage());
            }

        }

        public static function getInstance() {
            if (!isset(self::$_instance)) {
                self::$_instance = new Database();
            }
            $come = new DateTime('now');
            self::$today = $come->format('Y-m-d H:i:s');
            $come->add(new DateInterval('P1Y'));
            self::$nextYr = $come->format('Y-m-d');

            return self::$_instance;
        }

        public static function close_Instance() {
            if (isset(self::$_instance)) {
                self::$_instance = NULL;
            }
            return self::$_instance;
        }

        private function query($sql, $params = array()) {
            $this->_error = false;
            if ($this->_query = $this->_pdo->prepare($sql)) {
                $x = 1;

                if (count($params)) {
                    foreach ($params as $param) {
                        $this->_query->bindValue($x, $param);
                        $x++;

                    }
                }
                if ($this->_query->execute()) {
                    //echo 'Successful';
                    $this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
                    //$this->_result_assoc = $this->_query->fetchAll(PDO::FETCH_ASSOC);
                    $this->_count = $this->_query->rowCount();

                } else {
                    $this->_error = true;
                    //echo "<pre>";
                    //print_r($this->_query->errorInfo());
                    //echo "</pre>";
                    //die();
                }
            }
            return $this;
        }

        public function customQuery($sql, $params = array()) {
            $this->_error = false;
            if ($this->_query = $this->_pdo->prepare($sql)) {
                //$this->_query->setFetchMode(PDO::FETCH_ASSOC);
                $x = 1;
                //print_r ($this->_query);
                //echo '<br>';
                //print_r($params);
                if (count($params)) {
                    foreach ($params as $param) {
                        $this->_query->bindValue($x, $param);
                        $x++;
                    }
                }
                if ($this->_query->execute()) {
                    //echo 'Successful';
                    //$this->_results = $this->_query->fetchAll();
                    $this->_result_assoc = $this->_query->fetchAll(PDO::FETCH_ASSOC);
                    //$this->_json_data = json_encode($this->_result_assoc);
                    $this->_count_assoc = $this->_query->rowCount();
                } else {
                    $this->_error = true;
                    //echo "<pre>";
                    //print_r($this->_query->errorInfo());
                    //echo "</pre>";
                }
            }
            return $this;
        }

        public function update($table, $fields = array(), $where, $id = null) {
            $set = "";
            $x = 1;

            foreach ($fields as $name => $value) {
                $set .= "{$name} = ?";
                if ($x < count($fields)) {
                    $set .= ', ';
                }
                $x++;
            }
            $sql = "UPDATE {$table} SET {$set} WHERE {$where} = '{$id}'";//{$id}";

            //die($sql);

            $this->query($sql, $fields);
            if (!$this->query($sql, $fields)->error()) {
                return true;
            }

        }

        public function double_update($table, $fields = array(), $where1, $id1 = null,$where2, $id2 = null) {
            $set = "";
            $x = 1;

            foreach ($fields as $name => $value) {
                $set .= "{$name} = ?";
                if ($x < count($fields)) {
                    $set .= ', ';
                }
                $x++;
            }
            $sql = "UPDATE {$table} SET {$set} WHERE {$where1} = '{$id1}' AND {$where2} = '{$id2}'";//{$id}";

            //die($sql);

            $this->query($sql, $fields);
            if (!$this->query($sql, $fields)->error()) {
                return true;
            }

        }

        public function pumpUpdate($table, $fields = array(), $where = array(),$concatenate = ' AND ') {
            $set = "";
            $x = 1;

            foreach ($fields as $name => $value) {
                $set .= "{$name} = ?";
                if ($x < count($fields)) {
                    $set .= ', ';
                }
                $x++;
            }

            if (count($where) >= 3) {
                $operators = array('=', '>', '<', '>=', '<=', 'LIKE');


                $ref = '';
                $matrix = count($where);
                for($i=0; $i < count($where); $i+=3){
                    $column = $where[$i];
                    $operator = $where[$i+1];
                    if (in_array($operator, $operators)) {
                        $val = $where[$i+2];
                        $ref .= " {$column} {$operator} '{$val}' ";
                        $b = ($i+3);
                        $ans = ($matrix/$b);
                        if($ans == 1){
                            break;
                        }else{
                            $ref .= $concatenate;
                        }

                    }

                }

            }

            $sql = "UPDATE {$table} SET {$set} WHERE {$ref} ";
            //print_r($sql);
            //die();

            $this->query($sql, $fields);
            if (!$this->query($sql, $fields)->error()) {
                return true;
            }

        }


        public function action($action, $table, $where = array(), $order = NULL, $orderly = 'DESC') {
            if (count($where) === 6) {
                $operators = array('=', '>', '<', '>=', '<=', 'LIKE');
                $field = $where[0];
                $operator = $where[1];
                $value = $where[2];
                $field2 = $where[3];
                $operator2 = $where[4];
                $value2 = $where[5];

                if (in_array($operator, $operators)) {
                    $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ? AND {$field2} {$operator2} ? ";
                    if (isset($order)) {
                        $sql .= " ORDER BY {$order} {$orderly}";
                    }

                    if (!$this->query($sql, array($value,$value2))->error()) {
                        return $this;
                    }
                }
            }
            elseif (count($where) === 3) {
                $operators = array('=', '>', '<', '>=', '<=', 'LIKE');
                $field = $where[0];
                $operator = $where[1];
                $value = $where[2];

                if (in_array($operator, $operators)) {
                    $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
                    if (isset($order)) {
                        $sql .= " ORDER BY {$order} {$orderly}";
                    }

                    if (!$this->query($sql, array($value))->error()) {
                        return $this;
                    }
                }
            }
            elseif ($where == NULL) {
                $sql = "{$action} FROM {$table}";
                if (isset($order)) {
                    $sql .= " ORDER BY {$order} {$orderly}";
                }

                if (!$this->query($sql)->error()) {
                    return $this;
                }
            }
            return false;
        }

        public function pumpAction($action, $table, $where = array(), $order = NULL, $orderly = 'DESC', $concatenate = "AND ") {
            if (count($where) >= 3) {
                $operators = array('=', '>', '<', '>=', '<=', 'LIKE');

                $matrix = count($where);
                $sql = "{$action} FROM {$table} WHERE ";
                $value = array();
                  for($i=0; $i < count($where); $i+=3){
                    $field = $where[$i];
                    $operator = $where[$i+1];
                      if (in_array($operator, $operators)) {
                          $value[] = $where[$i+2];
                          $sql .= " {$field} {$operator} ? ";
                          $b = ($i+3);
                          $ans = ($matrix/$b);
                          if($ans == 1){
                              break;
                          }else{
                              $sql .= $concatenate;
                          }

                      }

                }
                if (isset($order)) {
                    $sql .= " ORDER BY {$order} {$orderly}";
                }

                if (!$this->query($sql, $value)->error()) {
                    return $this;
                }
            }
            elseif (count($where) === 3) {
                $operators = array('=', '>', '<', '>=', '<=', 'LIKE');
                $field = $where[0];
                $operator = $where[1];
                $value = $where[2];

                if (in_array($operator, $operators)) {
                    $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
                    if (isset($order)) {
                        $sql .= " ORDER BY {$order} {$orderly}";
                    }

                    if (!$this->query($sql, array($value))->error()) {
                        return $this;
                    }
                }
            }
            elseif ($where == NULL) {
                $sql = "{$action} FROM {$table}";
                if (isset($order)) {
                    $sql .= " ORDER BY {$order} {$orderly}";
                }

                if (!$this->query($sql)->error()) {
                    return $this;
                }
            }
            return false;
        }

        public function action_assoc($action, $table, $where = array(), $order) {
            if(count($where)=== 3){
                $operators = array('=', '>', '<', '>=', '<=', 'LIKE');
                $field = $where[0];
                $operator = $where[1];
                $value = $where[2];

                if (in_array($operator, $operators)) {
                    $sql = "{$action} FROM {$table} ";
                    $sql .= " WHERE {$field} {$operator} ? ";
                    if (isset($order)) {
                        $sql .= " ORDER BY {$order} ASC";
                    }

                    //echo $sql.' '. $value;
                    if(!$this->customQuery($sql,array($value))->error()){
                        return $this;
                    }
                }
            }//my own
            elseif($where==NULL){
                $sql = "{$action} FROM {$table} ";

                if (isset($order)) {
                    $sql .= " ORDER BY {$order} DESC";
                }
                if(!$this->customQuery($sql)->error()){
                    return $this;

                }
            }
            return false;
        }

        public function limiting_action($action, $table,$limit, $where = array(), $order) {

            if(count($where)=== 3){

                $operators = array('=', '>', '<', '>=', '<=', 'LIKE');
                $field = $where[0];
                $operator = $where[1];
                $value = $where[2];

                if (in_array($operator, $operators)) {
                    $sql = "{$action} FROM {$table} ";
                    $sql .= " WHERE {$field} {$operator} ? ";
                    if (isset($order) && $order != 'RAND') {
                        $sql .= " ORDER BY {$order} DESC";
                    }elseif($order == 'RAND') {
                        $sql .= " ORDER BY RAND()";
                    }
                    if (isset($limit)) {
                        $sql .= " LIMIT $limit";
                    }

                    //echo $sql.' '. $value;
                    if(!$this->customQuery($sql,array($value))->error()){
                        return $this;
                    }
                }
            }//my own
            elseif($where==NULL){

                $sql = "{$action} FROM {$table} ";

                if (isset($order) && $order != 'RAND') {
                    $sql .= " ORDER BY {$order} DESC";
                }elseif($order == 'RAND') {
                    $sql .= " ORDER BY RAND()";
                }
                if (isset($limit)) {
                    $sql .= " LIMIT $limit";
                }
                if(!$this->customQuery($sql)->error()){
                    return $this;

                }
            }
            return false;
        }

        public function action_join_assoc($action, $table1, $table2, $table1_id, $table2_id, $where = array(), $order){
            if(count($where)=== 3){
                $operators = array('=','>','<','>=','<=','LIKE');
                $field = $where[0];
                $operator = $where[1];
                $value = $where[2];

                if(in_array($operator,$operators)){
                    $sql = "{$action} FROM {$table1} ";

                    //$sql .= 'SELECT make, yearmade, mileage, price, description  FROM cars';ON (table1.id=table2.id)
                    $sql .= "LEFT JOIN {$table2} ON {$table1_id} = {$table2_id}";

                    $sql .= " WHERE {$field} {$operator} ? ";
                    if(isset($order)){
                        $sql .= " ORDER BY {$order} DESC";//ORDER BY table2." . $ordem . " DESC")
                    }
                    //echo $sql.' '. $value;
                    if (!$this->customQuery($sql, array($value))->error()) {
                        return $this;
                    }
                }
            }//my own
            elseif ($where == NULL) {
                $sql = "{$action} FROM {$table1}";
                if (isset($order)) {
                    $sql .= " ORDER BY {$order} DESC";
                }
                if (!$this->customQuery($sql)->error()) {
                    return $this;
                }
            }
            return false;
        }

        public function multiple_where($action, $table, $where = array(),$order = NULL){
            if (count($where) === 6) {
                $operators = array('=', '>', '<', '>=', '<=', 'LIKE');
                $field = $where[0];
                $operator = $where[1];
                $value = $where[2];
                $field2 = $where[3];
                $operator2 = $where[4];
                $value2 = $where[5];

                if (in_array($operator, $operators)) {
                    $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ? AND {$field2} {$operator2} ? ";
                    if(isset($order)){
                        $sql .= " ORDER BY {$order} DESC ";
                    }

                    if(!$this->customQuery($sql,array($value, $value2))->error()){
                        return $this;
                    }
                }
            }//my own
            elseif($where==NULL){
                $sql = "{$action} FROM {$table}";
                if(!$this->customQuery($sql)->error()){
                    return $this;
                }
            }
            return false;
        }

        public function multiple_either($action, $table, $where = array(),$order){
            if(count($where)=== 6){
                $operators = array('=','>','<','>=','<=','LIKE');
                $field = $where[0];
                $operator = $where[1];
                $value = $where[2];
                $field2 = $where[3];
                $operator2 = $where[4];
                $value2 = $where[5];

                if(in_array($operator,$operators)){
                    $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ? OR {$field2} {$operator2} ? ";
                    if(isset($order)){
                        $sql .= " ORDER BY {$order} DESC";
                    }

                    if (!$this->customQuery($sql, array($value, $value2))->error()) {
                        return $this;
                    }
                }
            }//my own
            elseif($where==NULL){
                $sql = "{$action} FROM {$table}";
                if(!$this->customQuery($sql)->error()){
                    return $this;
                }
            }
            return false;
        }


        public function triple_either($action, $table, $where = array(),$order){ //get value from 3 columns
            if(count($where)=== 9){
                $operators = array('=','>','<','>=','<=','LIKE');
                $field = $where[0];
                $operator = $where[1];
                $value = $where[2];
                $field2 = $where[3];
                $operator2 = $where[4];
                $value2 = $where[5];
                $field3 = $where[6];
                $operator3 = $where[7];
                $value3 = $where[8];

                if(in_array($operator,$operators)){
                    $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ? OR {$field2} {$operator2} ? OR {$field3} {$operator3} ? ";
                    if(isset($order)){
                        $sql .= " ORDER BY {$order} DESC";
                    }

                    if(!$this->customQuery($sql,array($value, $value2, $value3))->error()){
                        return $this;
                    }
                }
            }//my own
            elseif($where==NULL){
                $sql = "{$action} FROM {$table}";
                if(!$this->customQuery($sql)->error()){
                    return $this;
                }
            }
            return false;
        }

        public function get($table, $where = NULL, $order = NULL, $orderly = 'DESC',$concatenate = "AND ") {
            return $this->pumpAction("SELECT *", $table, $where, $order, $orderly,$concatenate);
        }

        public function get_assoc($table, $where = NULL, $order = NULL) {
            return $this->action_assoc("SELECT *", $table, $where, $order);
        }
        public function get_jointed($table1, $table2, $table1_id, $table2_id, $where,$order=NULL){
            return $this->action_join_assoc("SELECT *",$table1, $table2, $table1_id, $table2_id,$where,$order);

        }
        public function get_multiple($table, $where, $order = NULL){
            return $this->multiple_where("SELECT *",$table,$where,$order);
        }
        public function get_multiple_either($table, $where,$order){
            return $this->multiple_either("SELECT *",$table,$where,$order);
        }
        public function get_triple_either($table, $where,$order = NULL){
            return $this->triple_either("SELECT *",$table,$where,$order);
        }
        public function getAll($table) {
            return $this->action("SELECT *", $table, $where = NULL);
        }

        public function get_limited($table, $limit,$where = NULL, $order = NULL){
            return $this->limiting_action("SELECT *",$table,$limit,$where,$order);
        }

        public function getAll_assoc($table, $order = NULL, $where = NULL) {
            return $this->action_assoc("SELECT *", $table, $where, $order);
        }

        public function delete($table, $where) {
            return $this->action("DELETE", $table, $where);
        }

        public function insert($table, $fields = array()) {
            if (count($fields)) {
                $keys = array_keys($fields);
                $values = null;
                $x = 1;

                foreach ($fields as $field) {
                    $values .= '?';
                    if ($x < count($fields)) {
                        $values .= ', ';
                    }
                    $x++;
                }

                $sql = "INSERT INTO {$table}(`" . implode('`,`', $keys) . "`) VALUES ({$values})";
                if (!$this->query($sql, $fields)->error()) {
                    return true;
                }
            }
            return false;
        }


        public function results() {
            return $this->_results;
        }

        public function results_assoc() {
            return $this->_result_assoc;
        }

        public function first() {
            if($this->results()){
                return $this->results()[0];
            }
            return false;
        }

        public function error() {
            return $this->_error;
        }

        public function count() {
            return $this->_count;
        }

        public function count_assoc() {
            return $this->_count_assoc;
        }

        public function last_insert_id() {
            $last = $this->_pdo->lastInsertId();
            return $last;
        }

        public function pagination($table, $start, $finish, $table_column = NULL, $value = NULL) {
            $sql = "SELECT * FROM " . $table;
            if (isset($table_column) && isset($value)) {
                $sql .= " WHERE " . $table_column . " = " . $value;
            }
            $sql .= " LIMIT " . $start . ", " . $finish;
            $page = $this->_pdo->prepare($sql);
            $page->execute();
            $_assoc = $page->fetchAll(PDO::FETCH_ASSOC);
            return $_assoc;
        }

        public function random_generator($table, $id) {
            $random = $this->_pdo->prepare("SELECT * FROM {$table} WHERE {$id} IN( SELECT {$id} FROM {$table} ORDER BY RAND() LIMIT 4)");
            $random->execute();
            $randomized = $random->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_FIRST);
            print_r($randomized);
            //return $randomized;
        }

        public function fetch_exact($table, $id, $defined) {
            $first = $this->_pdo->prepare("SELECT * FROM {$table} WHERE `{$id}`='{$defined}'");
            //die(print_r($first));

            $first->execute();
            $first_id = $first->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_FIRST);
            return $first_id;
        }
        public function fetch_exact_two($table,$id1,$defined1,$id2,$defined2){//$id3,$defined3
            //SELECT * FROM `user_likes` WHERE `post_id` = '41' AND `from_where` = 'forum'

            $first = $this->_pdo->prepare("SELECT * FROM {$table} WHERE {$id1} = '{$defined1}' AND {$id2} = '{$defined2}'");
            // print_r($first);
            $first->execute();
            $first_id = $first->fetch(PDO::FETCH_ASSOC,PDO::FETCH_ORI_FIRST);
            //if($count = $first->rowCount()){ echo($count) ;}
            //print_r( $first_id );
            return $first_id;
        }

        public function fetch_last($table, $order, $id = NULL, $defined = NULL, $id2 = NULL, $defined2 = NULL) {
            $sql = " SELECT * FROM {$table} ";

            if (isset($id) && isset($defined)) {
                $sql .= " WHERE {$id} = '{$defined}' ";
            }
            if (isset($id2) && isset($defined2)) {
                $sql .= " AND {$id2} = '{$defined2}' ";
            }
            if (isset($order)) {
                $sql .= " ORDER BY {$order} DESC ";
            }
            //echo $sql;
            $last = $this->_pdo->prepare($sql);
            //$last = $this->_pdo->prepare("SELECT * FROM {$table}  ORDER BY {$order} DESC ");
            $last->execute();
            $last_id = $last->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_LAST);
            //print_r( $last_id );
            return $last_id;
        }
        public function fetch_something($table,$id1 = NULL,$defined1 = NULL,$id2 = NULL,$defined2 = NULL, $order = NULL){
            $sql = " SELECT * FROM {$table} ";

            if(isset($id1) && isset($defined1)){
                $sql .= " WHERE {$id1} = '{$defined1}' ";
            }
            if(isset($id2) && isset($defined2)){
                $sql .= " AND {$id2} = '{$defined2}' ";
            }
            if(isset($order)){
                $sql .= " ORDER BY {$order} DESC ";
            }

            $first = $this->_pdo->prepare($sql);
            $first->execute();
            $first_id = $first->fetchAll(PDO::FETCH_ASSOC);
            //$first_id = $first->nextRowset();
            //while()
            echo('<pre>');
            print_r( $first_id );
            return $first_id;
        }

    }
?>