<?php
#
# Licensed to the Apache Software Foundation (ASF) under one
# or more contributor license agreements. See the NOTICE file
# distributed with this work for additional information
# regarding copyright ownership. The ASF licenses this file
# to you under the Apache License, Version 2.0 (the
# "License"); you may not use this file except in compliance
# with the License. You may obtain a copy of the License at
#
#   http://www.apache.org/licenses/LICENSE-2.0
#
# Unless required by applicable law or agreed to in writing,
# software distributed under the License is distributed on an
# "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
# KIND, either express or implied. See the License for the
# specific language governing permissions and limitations
# under the License.
#

if (!isset($GEN_DIR)) {
  $GEN_DIR = 'gen-php';
}

$GLOBALS['THRIFT_ROOT'] = realpath(dirname(__FILE__).'/../..').'/lib/php/src';

require_once $GLOBALS['THRIFT_ROOT'].'/Thrift.php';
require_once $GLOBALS['THRIFT_ROOT'].'/protocol/TBinaryProtocol.php';
require_once $GLOBALS['THRIFT_ROOT'].'/transport/TServerTransport.php';
require_once $GLOBALS['THRIFT_ROOT'].'/transport/TNonblockingServerSocket.php';
require_once $GLOBALS['THRIFT_ROOT'].'/transport/TBufferedTransport.php';
require_once $GLOBALS['THRIFT_ROOT'].'/server/TServer.php';
require_once $GLOBALS['THRIFT_ROOT'].'/server/TNonblockingServer.php';

/** Include the generated code */
require_once $GEN_DIR.'/ThriftTest/ThriftTest.php';
require_once $GEN_DIR.'/ThriftTest/ThriftTest_types.php';

$host = 'localhost';
$port = 9090;

class TestHandler implements ThriftTest {

	function testVoid() {
		print 'testVoid()';
	}

	function testString($str) {
		print sprintf('testString(%s)', $str);
		return $str;
	}

	function testByte($byte) {
		print sprintf('testByte(%d)', $byte);
		return $byte;
	}

	function testI16($i16) {
		print sprintf('testI16(%d)', $i16);
		return $i16;
	}

	function testI32($i32) {
		print sprintf('testI32(%d)', $i32);
		return $i32;
	}

	function testI64($i64) {
		print sprintf('testI64(%d)', $i64);
		return $i64;
	}

	function testDouble($dub) {
		print sprintf('testDouble(%f)', $dub);
		return $dub;
	}

	function testStruct($thing) {
		print sprintf('testStruct({%s, %d, %d, %d})', $thing->string_thing, $thing->byte_thing, $thing->i32_thing, $thing->i64_thing);
		return $thing;
	}

	function testException($str) {
		print sprintf('testException(%s)', $str);
		if ($str == 'Xception') {
			$x = Xception();
			$x->errorCode = 1001;
			$x->message = $str;
			throw $x;
		} elseif ($str == "throw_undeclared") { 
			throw ValueError("foo");
		}
	}

	function testOneway($seconds) {
		print sprintf('testOneway(%d) => sleeping...', $seconds);
		sleep($seconds);
		print 'done sleeping';
	}

	function testNest($thing) {
		return $thing;
	}

	function testMap($thing) {
		return $thing;
	}

	function testSet($thing) {
		return $thing;
	}

	function testList($thing) {
		return $thing;
	}

	function testEnum($thing) {
		return $thing;
	}

	function testTypefunction($thing) {
		return $thing;
	}

}


$handler = new TestHandler();
$processor = new ThriftTestProcessor($handler);
$transport = new TNonblockingServerSocket();

$server = new TNonblockingServer($processor, $transport);
$server->serve();
