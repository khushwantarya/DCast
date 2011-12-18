<?php
App::import('Controller', 'Controller');
App::import('Component', 'Croogo');

class CroogoComponentTestController extends Controller {

    public $components = array(
        'Croogo',
        'Security',
        'Acl',
        'Auth',
        'Acl.AclFilter',
        'Session',
        'RequestHandler',
    );
    
    public $uses = array(
        'Block',
        'Link',
        'Setting',
        'Node',
    );

}

class CroogoComponentTest extends CakeTestCase {

    public $fixtures = array(
        'aco',
        'aro',
        'aros_aco',
        'block',
        'comment',
        'contact',
        'i18n',
        'language',
        'link',
        'menu',
        'message',
        'meta',
        'node',
        'nodes_taxonomy',
        'region',
        'role',
        'setting',
        'taxonomy',
        'term',
        'type',
        'types_vocabulary',
        'user',
        'vocabulary',
    );

    public function start() {
        $this->Controller = new CroogoComponentTestController();
        $this->Controller->constructClasses();
        $this->Controller->Component->initialize($this->Controller);
        $this->Controller->beforeFilter();
        $this->Controller->Component->startup($this->Controller);
    }

    public function testStringToArray() {

    }

    public function end() {
    }

}
?>