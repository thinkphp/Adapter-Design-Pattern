<html>
<head>
<title>Design Pattern - Adapter</title>
</head>
<?php
echo"<h1>Design Pattern - Adapter</h1>";

abstract class DataAdapter {

       abstract function getCount();
       abstract function getName($row);
       abstract function getValue($row);
}

class Record {

      public $name;
      public $dep;
      public $age;
      public $salary;

      public function __construct($name, $dep, $age, $salary) {

             $this->name = $name;
             $this->dep = $dep;
             $this->$age = $age;
             $this->salary = $salary;
      }
}

class RecordList {

      public $record = array();

   public function __construct() {

      $this->records[] = new Record("Adrian","Mathematique",28,67000);

      $this->records[] = new Record("Surasky","Mathematique",28,70050);

      $this->records[] = new Record("Ledorf","Mathematique",28,85050);

      $this->records[] = new Record("Eistein","Mathematique",28,25000);

      $this->records[] = new Record("Newton","Mathematique",28,19000);
   }

   public function getRecords() {

          return $this->records;
   }
}

class GraphAdapter extends DataAdapter {

  private $data;

  public function __construct($records) {

         $this->data = $records->getRecords();
  }

  function getCount() {

         return count($this->data);
  }

  function getName($row) {

         return $this->data[$row]->name;
  }

  function getValue($row) {

         return $this->data[$row]->salary;
  }

}

class GraphRender {

      public $min;
      public $max;
      public $adapter;

      public function __construct($adapter) {

             $this->adapter = $adapter;
      }

      public function getMin() {

           $min = 9999999;

           for($i = 0; $i < $this->adapter->getCount(); $i++) {

                if($this->adapter->getValue($i) < $min) {

                   $min = $this->adapter->getValue($i);

                }
           }

           return $this->min = $min;
      }

      public function getMax() {

        $max = -9999999;

        for($i = 0; $i < $this->adapter->getCount(); $i++) {

             if($this->adapter->getValue($i) > $max) {

                $max = $this->adapter->getValue($i);

             }
        }

        return $this->max = $max;
      }

      public function WebRender() {
             $this->getMin();
             $this->getMax();

             $ratio = 200 / ($this->max - $this->min);

             $n = $this->adapter->getCount();

             echo"<table>";

             for($i = 0; $i < $n; $i++) {

                 $name = $this->adapter->getName($i);

                 $salary = $this->adapter->getValue($i);

                 $ans = ($salary - $this->min ) * $ratio;

                 echo"<tr><td>". $name ."</td><td><img src='yellow.png' width=".$ans." height='50'></td></tr>";

             }

             echo"</table>";

      }

      public function TextRender() {


      }

}

$data = new RecordList();

$adapter = new GraphAdapter( $data );

$obj = new GraphRender( $adapter );

$obj->WebRender();
?>
</html>
