<?php
use mharj\net\FileInputStream;

class FileInputStreamTest extends PHPUnit_Framework_TestCase {
	public function testFileInputStream() {
		$file = new FileInputStream("bootstrap.php");
		$b = "";
		$count = $file->read($b,0,5);
		$this->assertEquals($count,5);
		$file->close();
	}
	
	/**
     * @expectedException mharj\net\IOException
	 */
	public function testFileInputStreamException() {
		new FileInputStream("__not_found__");
	}

	public function testFileInputStreamDoubleClose() {
		$file = new FileInputStream("bootstrap.php");
		$file->close();
		$file->close();
	}
	
	public function testFileInputStreamReadByte() {
		$file = new FileInputStream("bootstrap.php");
		$this->assertEquals('<',$file->readByte());
		$file->close();
	}
	
	public function testFileInputStreamReadAndAvailable() {
		$file = new FileInputStream("bootstrap.php");
		$b="";
		
		$total = $file->available();
		$count = $file->read($b,null,4);
		$this->assertEquals(($total-4),($total-$count));
		
		$total = $file->available();
		$count = $file->read($b,null,4);
		$this->assertEquals(($total-4),($total-$count));

		$file->close();
	}
	public function testFileInputStreamReadAll() {
		$file = new FileInputStream("bootstrap.php");
		$b="";
		$totalCount = $file->available();
		$countRead = $file->read($b,null,$totalCount);
		$this->assertEquals(0,$file->available()); // zero bytes more
		$this->assertEquals($totalCount,$countRead); // read and total are same
		$this->assertEquals($totalCount,strlen($b)); // actual data is same length as total bytes
		$file->close();
	}
	
	/**
     * @expectedException mharj\net\IOException
	 */
	public function testFileInputStreamAvailableError() {
		$file = new FileInputStream("bootstrap.php");
		$file->close();
		$file->available();
	}

	/**
     * @expectedException mharj\net\IOException
	 */
	public function testFileInputStreamReadByteError() {
		$file = new FileInputStream("bootstrap.php");
		$file->close();
		$file->readByte();
	}
	/**
     * @expectedException mharj\net\IOException
	 */
	public function testFileInputStreamReadError() {
		$file = new FileInputStream("bootstrap.php");
		$file->close();
		$b="";
		$file->read($b,null,4);
	}	
}
