<?php
/******************************************************************************
 *                                                                            *
 *                                                                            *
 *                                                                            *
 *                        aaaAAaaa            HHHHHH                          *
 *                     aaAAAAAAAAAAaa         HHHHHH                          *
 *                    aAAAAAAAAAAAAAAa        HHHHHH                          *
 *                   aAAAAAAAAAAAAAAAAa       HHHHHH                          *
 *                   aAAAAAa    aAAAAAA                                       *
 *                   AAAAAa      AAAAAA                                       *
 *                   AAAAAa      AAAAAA                                       *
 *                   aAAAAAa     AAAAAA                                       *
 *                    aAAAAAAaaaaAAAAAA       HHHHHH                          *
 *                     aAAAAAAAAAAAAAAA       HHHHHH                          *
 *                      aAAAAAAAAAAAAAA       HHHHHH                          *
 *                         aaAAAAAAAAAA       HHHHHH                          *
 *                                                                            *
 *                                                                            *
 *                                                                            *
 *      a r t e v e l d e  u n i v e r s i t y  c o l l e g e  g h e n t      *
 *                                                                            *
 *                                                                            *
 *                                 MEMBER OF GHENT UNIVERITY ASSOCIATION      *
 *                                                                            *
 *                                                                            *
 ******************************************************************************
 *
 * @author     Olivier Parent
 * @copyright  Copyright (c) 2012 Artevelde University College Ghent
 */

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
      /* Initialize action controller here */
    }

    public function indexAction()
    {
        //CACHE TEST 
        include_once APPLICATION_PATH . '/../library/Zend/Cache.php';

        $frontendOptions = array(
            'lifetime' => null,
            'automatic_serialization' => true
            //,'cache_id_prefix' => 'dontUse'
        );

        $backendOptions = array(
          // Directory where to store cache files
          'cache_dir' => APPLICATION_PATH .  '/../tmp'

          // prefix for cache files ; be really careful with this option because a too generic value in a system cache dir (like /tmp) can cause disasters when cleaning the cache
          ,'file_name_prefix' => 'open9000'
          
          // Enable / disable read control : if enabled, a control key is embedded in the cache file and this key is compared with the one calculated after the reading.
          ,'read_control' => false
        );

        mysql_connect('localhost', 'root', 'root');
        mysql_select_db('ZendFrameworkDemo');
        $query = 'select count(id) as `amount` from datasets';
        $urls = mysql_query($query);
        $amountDatasetsArr = mysql_fetch_assoc($urls);
        $amountDatasets = (int)$amountDatasetsArr["amount"];
         
        for ($i=1; $i <= $amountDatasets; $i++) { 
        	//var_dump( $i );
	        $cache = Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);
	        $id = 'cache'.$i;

	        if (isset($_GET['form_submit']) && $_GET['form_submit'] == 'clear')
	        {
	          $cache->remove($id);
	        }

	        //$start_time = microtime(true);

	        if (!($data = $cache->load($id))) {
	          //echo "Not found in cache<br />";
	          mysql_connect('localhost', 'root', 'root');
	          mysql_select_db('ZendFrameworkDemo');
	          $query = 'select id, url from datasets where id="'.$i.'"';
	          $urls = mysql_query($query);
	          
	          $data = array();
	          while ($row = mysql_fetch_assoc($urls)) {
              $data[] = $row;
	          }

	          $cache->save($data);

	        } else {
	          //echo "Running from Cache<br/>";
	        }
        }


        //echo '<pre>';
        //print_r($data);
        //echo '</pre>';
        //echo sprintf('%01.4f', microtime(true) - $start_time);
    }

    public function addAction()
    {
    	$view = $this->view;
    	$view->title = "yoyo";

    	// $request = $this->getRequest();

    	// if ($request->isPost() ) {
    	//     if ($form->isValid( $request->getPost() )) {
    	//         $values = $form->getValues();
    	//         //Zend_Debug::dump($values);

    	//         $admin = new Backoffice_Model_Admin($values);

    	//         //Zend_Debug::dump($admin);

    	//         $adminMapper = new Backoffice_Model_AdminMapper();
    	//         $adminMapper->save($admin);
    	//     }
    	// }
    	


    	$form = new Application_Form_DatabaseForm();

    	$view->form = $form;
    }
}