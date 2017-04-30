<?php

namespace test\app\Models;



/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 15.03.2017
 * Time: 18:17
 */
class Model
{
    private static $db;
    private static $query = ['sql' => '', 'vars' => []];
    private static $where = false;
    private static $connected = false;
    public static $table;
    public static $available;
    public static $queries = [];

    public function __construct()
    {
        if(!self::$connected) {
            try {
                self::setup(new \PDO('mysql:host=localhost;dbname=mehanica', 'root', '', [\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC]));
            } catch (\PDOException $e) {
                print "Error!: " . $e->getMessage() . "<br/>";
            }
        }
        $called_class = get_called_class();
        self::$table = $called_class::$table;
        self::$available = $called_class::$available;
    }

    public static function setup($dbi, $charset = 'utf8') {
        if(is_object($dbi)) {
            $dbi->exec("set names $charset");
            self::$db = $dbi;
            self::$connected = true;
        }
    }

    public static function select()
    {
        $called_class = get_called_class();
        $obj = new self();
        $obj::$table = $called_class::$table;
        $obj::$available = $called_class::$available;
        $obj::$query = ['sql' => 'select * from '.$obj::$table, 'vars' => []];
        return $obj;
    }

    public function where($key, $value) {
        if(!self::$where) {
            self::$query['sql'] = self::$query['sql'].' where '.$key.' = ?';
        } else {
            self::$query['sql'] = self::$query['sql'].' and '.$key.' = ?';
        }
        self::$query['vars'][] = $value;
        self::$where = true;
        return $this;
    }

    public function get()
    {
        return $this->query(self::$query['sql'], self::$query['vars'])->fetchAll(\PDO::FETCH_OBJ);
    }

    public function all()
    {
        return $this->query('select * from '.self::$table)->fetchAll(\PDO::FETCH_OBJ);
    }

    public function first()
    {
        self::$where = false;
        if($row = $this->query(self::$query['sql'], self::$query['vars'])->fetch()) {
            $called_class = get_called_class();
            $cObj = new $called_class;
            foreach ($row as $key => $value) {
                $cObj->$key = $value;
            }
            return $cObj;
        } else return false;
    }

    public function last()
    {
        return $this->query('select * from '.self::$table.' order by id DESC')->fetch(\PDO::FETCH_OBJ);
    }

    public function count()
    {
        if($query = $this->get()) return count($query);
        return 0;
    }

    public function delete()
    {
        if($this->query('delete from '.self::$table.' where id = '.$this->id)) return true;
        return false;
    }

    public function save()
    {
        $vars = [];
        if(isset($this->id)) {
            self::$available[] = 'updated_at';
            $this->updated_at = date("Y-m-d H:i:s");
            $query = 'update '.self::$table.' set ';
            $query = $query.implode(' = ?, ', self::$available).' = ?';
            foreach (self::$available as $field){
                $vars[] = $this->$field;
            }
            $query = $query.' where id = '.$this->id;
            if($this->query($query, $vars)) return true;
        } else {
            $values = '';
            foreach (self::$available as $field){
                if(!isset($this->$field)) $this->$field = '';
                $vars[] = $this->$field;
                if(empty($values)) {
                    $values = '?';
                } else {
                    $values = $values.', ?';
                }
            }
            $query = 'insert into '.self::$table.'('.implode(', ', self::$available).') values('.$values.')';
            if($this->query($query, $vars)) {
                $this->id = self::$db->lastInsertId();
                return true;
            }
        }

        return false;
    }

    public function query($sql, $vars = [])
    {
        self::$queries[] = $sql;
        $stmt = self::$db->prepare($sql);
        if($stmt->execute($vars)) return $stmt;
        return false;
    }

    /**
     * @return mixed
     */
    public static function getQuery()
    {
        return self::$query;
    }

    /**
     * @return array
     */
    public static function getQueries()
    {
        return self::$queries;
    }
}