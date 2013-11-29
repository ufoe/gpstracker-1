<?php
/**
 * Licensed to the Apache Software Foundation (ASF) under one or more
 * contributor license agreements. See the NOTICE file distributed with
 * this work for additional information regarding copyright ownership.
 * The ASF licenses this file to You under the Apache License, Version 2.0
 * (the "License"); you may not use this file except in compliance with
 * the License. You may obtain a copy of the License at
 *
 *	   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * @package log4php
 */

/**
 * LoggerAppenderFireBug uses {@link PHP_MANUAL#echo echo} function to output events. 
 * 
 * <p>This appender requires a layout.</p>	
 * 
 * An example php file:
 * 
 * {@example ../../examples/php/appender_echo.php 19}
 * 
 * An example configuration file:
 * 
 * {@example ../../examples/resources/appender_echo.properties 18}
 * 
 * The above example would print the following:
 * <pre>
 *    Tue Sep  8 22:44:55 2009,812 [6783] DEBUG appender_echo - Hello World!
 * </pre>
 *
 * @version $Revision: 0 $
 * @package log4php
 * @subpackage appenders
 */
class LoggerAppenderFireBug extends LoggerAppender {
	/** boolean used internally to mark first append */
	protected $firstAppend = true;
	
	/** 
	 * If set to true, a <br /> element will be inserted before each line
	 * break in the logged message. Default value is false. @var boolean 
	 */
	protected $htmlLineBreaks = false;
    
  
    
	/** 
	 * Show  stack trace starting from level...
	 */
	protected $showStackTraceFrom = "";
    
    function get_debug_print_backtrace($traces_to_ignore = 1){
        $traces = debug_backtrace();
        $ret = array();
        foreach($traces as $i => $call){
            if ($i < $traces_to_ignore ) {
                continue;
            }

            $object = '';
            if (isset($call['class'])) {
                $object = $call['class'].$call['type'];
                if (is_array($call['args'])) {
                    foreach ($call['args'] as &$arg) {
                        $this->get_arg($arg);
                    }
                }
            }       

            //$ret[] = '#'.str_pad($i - $traces_to_ignore, 3, ' ')
            //.$object.$call['function'].'('.implode(', ', $call['args'])
            //.') called at ['.$call['file'].':'.$call['line'].']';
            $ret[] = $call['file'].':'.$call['line'].'';
        }

        return implode("\n",$ret);
    }

    function get_arg(&$arg) {
        if (is_object($arg)) {
            $arr = (array)$arg;
            $args = array();
            foreach($arr as $key => $value) {
                if (strpos($key, chr(0)) !== false) {
                    $key = '';    // Private variable found
                }
                $args[] =  '['.$key.'] => '.$this->get_arg($value);
            }

            $arg = get_class($arg) . ' Object ('.implode(',', $args).')';
        }
    }

    
    
    
	public function close() {
		if($this->closed != true) {
			if(!$this->firstAppend) {
				echo $this->layout->getFooter();
			}
		}
		$this->closed = true;
	}

	public function append(LoggerLoggingEvent $event) {
		if($this->layout !== null) {
			if($this->firstAppend) {
				echo $this->layout->getHeader();
				$this->firstAppend = false;
			}
			$text = $this->layout->format($event);
			
			if ($this->htmlLineBreaks) {
				$text = nl2br($text);
			}

            $logType="log";
            if ($event->getLevel()->isGreaterOrEqual(LoggerLevel::getLevelDebug())) {
                $logType="debug";
            }
            if ($event->getLevel()->isGreaterOrEqual(LoggerLevel::getLevelInfo())) {
                $logType="info";
            }
            if ($event->getLevel()->isGreaterOrEqual(LoggerLevel::getLevelWarn())) {
                $logType="warn";
            }
            if ($event->getLevel()->isGreaterOrEqual(LoggerLevel::getLevelError())) {
                $logType="error";
            }
            
            $text2= "<script>\r\n//<![CDATA[\r\nif(!console){var console={log:function(){}}}";
                       
            $output    =    explode("\n", $text );
            foreach ($output as $line) {
                if (trim($line)) {
                    $line    =    addslashes($line);
                    $text2.="console.$logType(\"{$line}\");";
                }
            }
          

            if ($this->showStackTraceFrom!="") {
                if ($event->getLevel()->isGreaterOrEqual(LoggerLevel::toLevel($this->showStackTraceFrom) )) {
                    $textStack= addslashes($this->get_debug_print_backtrace(7));

                    $output    =    explode("\n", $textStack );
                    foreach ($output as $line) {
                        if (trim($line)) {
                            $line    =    addslashes($line);
                            $text2.="console.log(\"{$line}\");";
                        }
                    }
                }
            }
            
            $text2.="\r\n//]]>\r\n</script>";
            
			echo $text2;
		}
	}
	
	public function setHtmlLineBreaks($value) {
		$this->setBoolean('htmlLineBreaks', $value);
	}

	public function getHtmlLineBreaks() {
		return $this->htmlLineBreaks;
	}
    
	public function setShowStackTraceFrom ($flag ) {
		$this->setString('showStackTraceFrom', $flag );
	}
}
