<?php

  /**
  * @backupGlobals disabled
  * @backupStaticAttributes disabled
  */

  require_once "src/Task.php";
  require_once "src/Category.php";

  $server = 'mysql:host=localhost;dbname=to_do_test';
  $username = 'root';
  $password = 'root';
  $DB = new PDO($server, $username, $password);

  class TaskTest extends PHPUnit_Framework_TestCase
  {
      protected function tearDown()
      {
          Task::deleteAll();
          Category::deleteAll();
      }


      function test_save()
      {

      //Arrange
      $description = "Wash the dog";
      $due_date = '2015-01-01';
      $id = 1;
      $test_task = new Task($description, $id, $due_date);

      //Act
      $test_task->save();

      //Assert
      $result = Task::getAll();
      $this->assertEquals($test_task, $result[0]);

      }

    function test_getAll()
    {
        //Arrange
        $description = "Wash the dog";
        $due_date = '2015-01-01';
        $id = 1;
        $test_task = new Task($description, $id, $due_date);
        $test_task->save();

        $description2 = "Water the lawn";
        $id2 = 2;
        $test_task2 = new Task($description2, $id2, $due_date);
        $test_task2->save();

        //Act
        $result = Task::getAll();

        //Assert
        $this->assertEquals([$test_task, $test_task2], $result);
    }

    function test_deleteAll()
    {
        //Arrange
        $description = "Wash the dog";
        $due_date = '2015-01-01';
        $id = 1;
        $test_task = new Task($description, $id, $due_date);
        $test_task->save();

        $description2 = "Water the lawn";
        $id2 = 2;
        $due_date = '2015-01-02';
        $test_task2 = new Task($description2, $id, $due_date);
        $test_task2->save();

        //Act
        Task::deleteAll();

        //Asser
        $result = Task::getAll();
        $this->assertEquals([], $result);
    }

    function test_getId()
    {
        //Arrange
        $name = "Home Stuff";
        $id = null;
        $test_category = new Category($name, $id);
        $test_category->save();

        $description = "Wash the dog";
        $due_date = '2015-01-01';
        $test_task = new Task($description, $id, $due_date);
        $test_task->save();

        //Act
        $result = $test_task->getId();

        //Assert
        $this->assertEquals(true, is_numeric($result));
    }
    function test_find()
    {
        //Arrange
        $description = "Wash the dog";
        $due_date = '2015-01-01';
        $id = 1;
        $test_task = new Task($description, $id, $due_date);
        $test_task->save();

        $description2 = "Water the lawn";
        $id2 = 2;
        $test_task2 = new Task($description2, $id2, $due_date);
        $test_task2->save();

        //Act
        $result = Task::find($test_task->getId());

        //Assert
        $this->assertEquals($test_task, $result);
    }
    function testUpdate()
    {
    //Arrange
    $description = "Wash the dog";
    $id = 1;
    $due_date = '2015-01-01';
    $test_task = new Task($description, $due_date, $id);
    $test_task->save();

    //Act
    $test_task->delete();

    //Assert
    $this->assertEquals([$test_task], Task::getAll());
    }
    // function testDeleteTask()
    // {
    //   //Arrange
    //   $description = "Wash the dog";
    //   $id = 1;
    //   $due_date = '2015-01-01';
    //   $test_task = new Task($description, $due_date, $id);
    //   $test_task->save();
    //
    //   $description2 = "Water the lawn";
    //   $id2 = 2;
    //   $due_date2 = '2015-01-01';
    //   $test_task2 = new Task($description2, $due_date2, $id2);
    //   $test_task2->save();
    // 
    //   //Act
    //   $test_task->delete();
    //
    //   //Assert
    //   $this->assertEquals([$test_task2], Task::getAll());
    // }

    function testDelete()
    {
        //Arrange
        $name = "Work stuff";
        $id = 1;
        $test_category = new Category($name, $id);
        $test_category->save();

        $description = "File reports";
        $id2 = 2;
        $test_task = new Task($description, $id2);
        $test_task->save();

        //Act
        $test_task->addCategory($test_category);
        $test_task->delete();

        //Assert
        $this->assertEquals([], $test_category->getTasks());
    }
  }

?>
