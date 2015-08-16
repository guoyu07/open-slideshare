<?php

App::uses('Slide', 'Model');

/**
 * Slide Test Case.
 */
class SlideTest extends CakeTestCase
{
    /**
     * Fixtures.
     *
     * @var array
     */
    public $fixtures = array(
        'app.slide',
        'app.user',
        'app.category',
        'app.comment',
    );

    /**
     * setUp method.
     */
    public function setUp()
    {
        parent::setUp();
        $this->Slide = ClassRegistry::init('Slide');
    }

    public function validationProvider()
    {
        $base_data = array(
            'user_id' => 1,
            'name' => 'The Slide Title',
            'descroption' => 'The Slide Description',
            'key' => '1234567890',
        );

        return array(
            array($base_data, true),
            array(array_merge($base_data, array('user_id' => null)), false),
            array(array_merge($base_data, array('name' => '')), false),
            array(array_merge($base_data, array('description' => '')),  false),
            array(array_merge($base_data, array('key' => '')), false),
        );
    }

    /**
     * @dataProvider validationProvider
     */
    public function testValidation($a, $expected)
    {
        $this->Slide->set($a);
        $result = $this->Slide->validates();
        $this->assertEqual($result, $expected);
    }
    /**
     * tearDown method.
     */
    public function tearDown()
    {
        unset($this->Slide);

        parent::tearDown();
    }

    /**
     * testCountup.
     */
    public function testCountup()
    {
        $id = 1;
        // Get current data
        $data = $this->Slide->findById($id);
        // count up
        $this->Slide->countup('download_count', $id);
        // and then get data again
        $data_new = $this->Slide->findById($id);

        $this->assertEqual($data['Slide']['download_count'] + 1, $data_new['Slide']['download_count']);
        foreach ($data['Slide'] as $key => $val) {
            if (!in_array($key, array('modified', 'download_count'))) {
                $this->assertEqual($data['Slide'][$key], $data_new['Slide'][$key]);
            }
        }
    }

    /**
     * testGetSlide method.
     */
    public function testGetSlide()
    {
        $id = 1;
        $data = $this->Slide->get_slide($id);

        App::uses('SlideFixture', 'Test/Fixture');
        $fixture = new SlideFixture();
        $records = $fixture->records;
        foreach ($records as $record) {
            if ($record['id'] == $id) {
                $expected_record = $record;
            }
        }
        foreach ($data['Slide'] as $k => $v) {
            $this->assertEquals($data['Slide'][$k], $expected_record[$k], "The value of $k is OK?");
        }
    }

    /**
     * testGetRecentSlidesInCategory method.
     */
    public function testGetRecentSlidesInCategory()
    {
        $slide_id = 1;
        $category_id = 1;
        $data = $this->Slide->get_recent_slides_in_category($category_id, $slide_id);

        App::uses('SlideFixture', 'Test/Fixture');
        $fixture = new SlideFixture();
        $expected_record = $fixture->records[1]; // The second record in the fixture
        foreach ($data[0]['Slide'] as $k => $v) {
            $this->assertEquals($data[0]['Slide'][$k], $expected_record[$k], "The value of $k is OK?");
        }
    }
}