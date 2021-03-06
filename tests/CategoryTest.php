<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Category.php";
    require_once "src/Task.php";

    $server = 'mysql:host=localhost;dbname=to_do_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CategoryTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Category::deleteAll();
            Task::deleteAll();
        }

        function test_getName()
        {
            //Arrange
            $name = "Work stuff";
            $test_category = new Category($name);

            //Act
            $result = $test_category->getName();

            //Assert
            $this->assertEquals($name, $result);
        }
        function testSetName()
        {
            //Arrange
            $name = "Kitchen chores";
            $test_category = new Category($name);

            //Act
            $test_category->setName("Home chores");
            $result = $test_category->getName();

            //Assert
            $this->assertEquals("Home chores", $result);
        }

        function test_getId()
        {
            //Arrange
            $name = "Work stuff";
            $id = 1;
            $test_category = new Category($name, $id);

            //Act
            $result = $test_category->getId();

            //Assert
            $this->assertEquals(1, $result);
        }

        function test_save()
        {
            //Arrange
            $name = "Work stuff";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            //Act
            $result = Category::getAll();

            //Assert
            $this->assertEquals($test_category, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name = "Work stuff";
            $id = 1;
            $name2 = "Home stuff";
            $id2 = 2;
            $test_category = new Category($name);
            $test_category->save();
            $test_category2 = new Category($name2);
            $test_category2->save();

            //Act
            $result = Category::getAll();

            //Assert
            $this->assertEquals([$test_category, $test_category2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $name = "Wash the dog";
            $id = 1;
            $name2 = "Home stuff";
            $id2 = 2;
            $test_category = new Category($name);
            $test_category->save();
            $test_category2 = new Category($name2);
            $test_category2->save();

            //Act
            Category::deleteAll();
            $result = Category::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $name = "Wash the dog";
            $name2 = "Home stuff";
            $id = 1;
            $id2 = 2;
            $test_category = new Category($name);
            $test_category->save();
            $test_category2 = new Category($name2);
            $test_category2->save();

            //Act
            $result = Category::find($test_category->getId());

            //Assert
            $this->assertEquals($test_category, $result);
        }
        function testUpdate()
        {
          //Arrange
          $name = "Work stuff";
          $id = 1;
          $test_category = new Category($name, $id);
          $test_category->save();

          $new_name = "Home Stuff";

          //Act
          $test_category->update($new_name);

          //Assert
          $this->assertEquals("Home Stuff", $test_category->getName());
        }
        function testDelete()
        {
          //Arrange
          $name = "Work Stuff";
          $id = 1;
          $test_category = new Category($name, $id);
          $test_category->save();

          $description ="File reports";
          $id2 = 2;
          $due_date = '2015-01-01';
          $test_task = new Task($description, $id2, $due_date);
          $test_task->save();

          //Act
          $test_task->addCategory($test_category);
          $test_task->delete();


          //Assert
          $this->assertEquals([], $test_category->getTasks());
        }
        function testAddTask()
        {
          //Arrange
          $name = "Work Stuff";
          $id = 1;
          $due_date = '2015-01-01';
          $test_category = new Category($name, $id);
          $test_category->save();

          $description = "File reports";
          $id2 = 2;
          $due_date = '2015-01-02';
          $test_task = new Task($description, $id2, $due_date);
          $test_task->save();

          //Act
          $test_category->addTask($test_task);

          //Assert
          $this->assertEquals($test_category->getTasks(), [$test_task]);
        }

        function testGetTasks()
        {
            //Arrange
            $name = "Home stuff";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog";
            $id2 = 2;
            $due_date = '2015-01-01';
            $test_task = new Task($description, $id2, $due_date);
            $test_task->save();

            $description2 = "Take out the trash";
            $id3 = 3;
            $due_date2 = '2015-01-01';
            $test_task2 = new Task($description2, $id3,$due_date2);
            $test_task2->save();

            //Act
            $test_category->addTask($test_task);
            $test_category->addTask($test_task2);

            //Assert
            $this->assertEquals($test_category->getTasks(), [$test_task, $test_task2]);
        }



    }

?>
