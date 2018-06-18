<?php
if (!class_exists("wpdreamsType")) {
    /**
     * (abstract) Class wpdreamsType
     *
     * Parent of each type defined in this directory. This class should not be used to make an instance.
     * Each new child type should follow this general interpretation.
     *
     * @package  WPDreams/OptionsFramework/Classes
     * @category Class
     * @author Ernest Marcinko <ernest.marcinko@wp-dreams.com>
     * @link http://wp-dreams.com, http://codecanyon.net/user/anago/portfolio
     * @copyright Copyright (c) 2012, Ernest Marcinko
     */
    abstract class wpdreamsType {
        protected static $_instancenumber = 0;
        protected static $_errors = 0;
        protected static $_globalerrormsg = "Only integer values are accepted!";
        protected $data;

        function __construct($name, $label, $data, $constraints = null, $errormsg = "") {
            $this->name = $name;
            $this->label = $label;
            $this->constraints = $constraints;
            $this->errormsg = $errormsg;
            $this->defaultData = $data; // Preserving constructor default data after posting
            $this->data = $data;
            $this->isError = false;
            self::$_instancenumber++;
            $this->getType();
        }

        /**
         * Returns the raw data passed to the class
         *
         * @return mixed
         */
        function getData() {
            return $this->data;
        }

        /**
         * Returns the name passed in the constructor
         *
         * @return string
         */
        final function getName() {
            return $this->name;
        }

        /**
         * Checks if there was an error within any child
         *
         * @return bool
         */
        final function getError() {
            return $this->isError;
        }

        /**
         * Gets the current error message or the global error if not defined
         *
         * @return string
         */
        final function getErrorMsg() {
            return $this->errormsg;
        }

        /**
         * Triggers or sets an error message.
         *
         * @param $error
         * @param string $errormsg
         */
        final function setError($error, $errormsg = "") {
            if ($errormsg != "")
                $this->errormsg = $errormsg;
            if ($error) {
                self::$_errors++;
                $this->isError = true;
            }
        }

        /**
         * Cheks the newly posted data against possible constraints
         *
         * @return bool
         */
        protected final function checkData() {
            $this->newData = $_POST[$this->name];
            if (is_array($this->constraints)) {
                foreach ($this->constraints as $key => $val) {
                    if ($this->constraints[$key]['op'] == "eq") {
                        if ($val['func']($this->newData) == $this->constraints[$key]['val']) {
                            ;
                        } else {
                            $this->setError(true);
                            return false;
                        }
                    } else if ($this->constraints[$key]['op'] == "ge") {
                        if ($val['func']($this->newData) >= $this->constraints[$key]['val']) {
                            ;
                        } else {
                            $this->setError(true);
                            return false;
                        }
                    } else {
                        if ($val['func']($this->newData) < $this->constraints[$key]['val']) {
                            ;
                        } else {
                            $this->setError(true);
                            return false;
                        }
                    }
                }
            }

            return true;
        }

        /**
         * Called in the constructor by default.
         *
         * Checks for errors when a new value was posted.
         */
        protected function getType() {
            if (isset($_POST[$this->name])) {
                if (!$this->checkData() || $this->getError()) {
                    /*errormessage*/
                    echo "<div class='errorMsg'>" . (($this->errormsg != "") ? $this->errormsg : self::$_globalerrormsg) . "</div>";
                } else {
                    if (is_array($this->data) && isset($this->data['value'])) {
                        $this->data['value'] = $_POST[$this->name];
                    } else {
                        $this->data = $_POST[$this->name];
                    }
                }
            }
        }

        protected function decode_param($v) {
            if (gettype($v) === 'string' && substr($v, 0, strlen('_decode_')) === '_decode_') {
                $v = substr($v, strlen('_decode_'));
                $v = json_decode(base64_decode($v), true);
            }
            return $v;
        }

        protected function encode_param($v) {
            // No need to decode
            if (gettype($v) === 'string' && substr($v, 0, strlen('_decode_')) === '_decode_') {
                return $v;
            } else {
                return '_decode_' . base64_encode(json_encode($v));
            }
        }

        /**
         * Returns the error count
         *
         * @return int
         */
        public static function getErrorNum() {
            return self::$_errors;
        }
    }
}