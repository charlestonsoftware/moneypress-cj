<?php

/***********************************************************************
* Class: MPCJ_AdminUI
*
* The MoneyPress : CJ Edition action hooks and helpers.
*
* The methods in here are normally called from an action hook that is
* called via the WordPress action stack.
*
* See http://codex.wordpress.org/Plugin_API/Action_Reference
*
************************************************************************/

if (! class_exists('MPCJ_AdminUI')) {
    class MPCJ_AdminUI {

        /******************************
         * PUBLIC PROPERTIES & METHODS
         ******************************/
        public $parent = null;

        /*************************************
         * The Constructor
         */
        function __construct($params=null) {
        }


        /**
         * Set the parent property to point to the primary plugin object.
         *
         * Returns false if we can't get to the main plugin object.
         *
         * @global wpCSL_plugin__slplus $slplus_plugin
         * @return type boolean true if plugin property is valid
         */
        function setParent() {
            if (!isset($this->parent) || ($this->parent == null)) {
                global $MP_cj_plugin;
                $this->parent = $MP_cj_plugin;
            }
            return (isset($this->parent) && ($this->parent != null));
        }

        /**
         * Render the Pro Options interface.
         */
        function pro_options() {
            if (!$this->setParent()) { return; }

            $this->parent->helper->execute_and_output_template('pro_settings.php');
        }
    }
}
?>
