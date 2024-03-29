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

      $this->records[] = new Record("Adrian","Mathematique",28,47000);

      $this->records[] = new Record("Surasky","Mathematique",28,70050);

      $this->records[] = new Record("Ledorf","Mathematique",28,85050);

      $this->records[] = new Record("Eistein","Mathematique",28,25000);

      $this->records[] = new Record("Newton","Mathematique",28,47000);

      $this->records[] = new Record("Pappilon","Philosophi",28,13000);
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

                 if($ans == 0) $ans = 10;

                 echo"<tr><td>". $name ."</td><td><img src='yellow.jpg' width=".$ans." height='50'></td></tr>";

             }

             echo"</table>";


             echo"<table><tr>";

             for($i = 0; $i < $n; $i++) {

                 $name = $this->adapter->getName($i);

                 $salary = $this->adapter->getValue($i);

                 $ans = ($salary - $this->min ) * $ratio;

                 if($ans == 0) $ans = 10;

                 echo"<td><img src='green.png' width='50' height='".$ans."'></td><td>".$name."</td>";

             }

             echo"</tr></table>";
      }

      public function TextRender() {

             $this->getMin();

             $this->getMax();

             $ratio = 40 / ($this->max - $this->min);

             $n = $this->adapter->getCount();

             echo"\n";

             for($i = 0; $i < $n; $i++) {

                 $name = $this->adapter->getName( $i );

                 $salary = $this->adapter->getValue( $i );

                 $ans = ($salary - $this->min ) * $ratio;

                 if($ans == 0) $ans = 1;

                 echo(sprintf("%11s ", $name));

                 for($j = 1; $j <= $ans;$j++) {

                    echo"*";
                 }
                 echo"\n";
              }

      }

}

$data = new RecordList();

$adapter = new GraphAdapter( $data );

$obj = new GraphRender( $adapter );

if(php_sapi_name() != 'cli') {

  $obj->WebRender();

} else {

  $obj->TextRender();
}
?>
</html>
