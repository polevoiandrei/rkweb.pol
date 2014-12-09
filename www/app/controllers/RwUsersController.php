<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;

class RwUsersController extends ControllerBase
{

    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for rw_users
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, "RwUsers", $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        $parameters["order"] = "usr_id";

        $rw_users = RwUsers::find($parameters);
        if (count($rw_users) == 0) {
            $this->flash->notice("The search did not find any rw_users");

            return $this->dispatcher->forward(array(
                "controller" => "rw_users",
                "action" => "index"
            ));
        }

        $paginator = new Paginator(array(
            "data" => $rw_users,
            "limit"=> 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displayes the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a rw_user
     *
     * @param string $usr_id
     */
    public function editAction($usr_id)
    {

        if (!$this->request->isPost()) {

            $rw_user = RwUsers::findFirstByusr_id($usr_id);
            if (!$rw_user) {
                $this->flash->error("rw_user was not found");

                return $this->dispatcher->forward(array(
                    "controller" => "rw_users",
                    "action" => "index"
                ));
            }

            $this->view->usr_id = $rw_user->usr_id;

            $this->tag->setDefault("usr_id", $rw_user->usr_id);
            $this->tag->setDefault("usr_hash", $rw_user->usr_hash);
            $this->tag->setDefault("usr_xml_url", $rw_user->usr_xml_url);
            $this->tag->setDefault("usr_xml_login", $rw_user->usr_xml_login);
            $this->tag->setDefault("usr_xml_password", $rw_user->usr_xml_password);
            $this->tag->setDefault("usr_name", $rw_user->usr_name);
            $this->tag->setDefault("usr_city", $rw_user->usr_city);
            $this->tag->setDefault("usr_address", $rw_user->usr_address);
            $this->tag->setDefault("usr_email", $rw_user->usr_email);
            $this->tag->setDefault("usr_phone", $rw_user->usr_phone);
            $this->tag->setDefault("usr_contact_info", $rw_user->usr_contact_info);
            $this->tag->setDefault("usr_comment", $rw_user->usr_comment);
            $this->tag->setDefault("usr_lang", $rw_user->usr_lang);
            $this->tag->setDefault("usr_allow_ips", $rw_user->usr_allow_ips);
            $this->tag->setDefault("usr_plan", $rw_user->usr_plan);
            $this->tag->setDefault("usr_plan_paid_from", $rw_user->usr_plan_paid_from);
            $this->tag->setDefault("usr_plan_paid_to", $rw_user->usr_plan_paid_to);
            $this->tag->setDefault("usr_additional_functions", $rw_user->usr_additional_functions);
            
        }
    }

    /**
     * Creates a new rw_user
     */
    public function createAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "rw_users",
                "action" => "index"
            ));
        }

        $rw_user = new RwUsers();

        $rw_user->usr_hash = $this->request->getPost("usr_hash");
        $rw_user->usr_xml_url = $this->request->getPost("usr_xml_url");
        $rw_user->usr_xml_login = $this->request->getPost("usr_xml_login");
        $rw_user->usr_xml_password = $this->request->getPost("usr_xml_password");
        $rw_user->usr_name = $this->request->getPost("usr_name");
        $rw_user->usr_city = $this->request->getPost("usr_city");
        $rw_user->usr_address = $this->request->getPost("usr_address");
        $rw_user->usr_email = $this->request->getPost("usr_email");
        $rw_user->usr_phone = $this->request->getPost("usr_phone");
        $rw_user->usr_contact_info = $this->request->getPost("usr_contact_info");
        $rw_user->usr_comment = $this->request->getPost("usr_comment");
        $rw_user->usr_lang = $this->request->getPost("usr_lang");
        $rw_user->usr_allow_ips = $this->request->getPost("usr_allow_ips");
        $rw_user->usr_plan = $this->request->getPost("usr_plan");
        $rw_user->usr_plan_paid_from = $this->request->getPost("usr_plan_paid_from");
        $rw_user->usr_plan_paid_to = $this->request->getPost("usr_plan_paid_to");
        $rw_user->usr_additional_functions = $this->request->getPost("usr_additional_functions");
        

        if (!$rw_user->save()) {
            foreach ($rw_user->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "rw_users",
                "action" => "new"
            ));
        }

        $this->flash->success("rw_user was created successfully");

        return $this->dispatcher->forward(array(
            "controller" => "rw_users",
            "action" => "index"
        ));

    }

    /**
     * Saves a rw_user edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(array(
                "controller" => "rw_users",
                "action" => "index"
            ));
        }

        $usr_id = $this->request->getPost("usr_id");

        $rw_user = RwUsers::findFirstByusr_id($usr_id);
        if (!$rw_user) {
            $this->flash->error("rw_user does not exist " . $usr_id);

            return $this->dispatcher->forward(array(
                "controller" => "rw_users",
                "action" => "index"
            ));
        }

        $rw_user->usr_hash = $this->request->getPost("usr_hash");
        $rw_user->usr_xml_url = $this->request->getPost("usr_xml_url");
        $rw_user->usr_xml_login = $this->request->getPost("usr_xml_login");
        $rw_user->usr_xml_password = $this->request->getPost("usr_xml_password");
        $rw_user->usr_name = $this->request->getPost("usr_name");
        $rw_user->usr_city = $this->request->getPost("usr_city");
        $rw_user->usr_address = $this->request->getPost("usr_address");
        $rw_user->usr_email = $this->request->getPost("usr_email");
        $rw_user->usr_phone = $this->request->getPost("usr_phone");
        $rw_user->usr_contact_info = $this->request->getPost("usr_contact_info");
        $rw_user->usr_comment = $this->request->getPost("usr_comment");
        $rw_user->usr_lang = $this->request->getPost("usr_lang");
        $rw_user->usr_allow_ips = $this->request->getPost("usr_allow_ips");
        $rw_user->usr_plan = $this->request->getPost("usr_plan");
        $rw_user->usr_plan_paid_from = $this->request->getPost("usr_plan_paid_from");
        $rw_user->usr_plan_paid_to = $this->request->getPost("usr_plan_paid_to");
        $rw_user->usr_additional_functions = $this->request->getPost("usr_additional_functions");
        

        if (!$rw_user->save()) {

            foreach ($rw_user->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "rw_users",
                "action" => "edit",
                "params" => array($rw_user->usr_id)
            ));
        }

        $this->flash->success("rw_user was updated successfully");

        return $this->dispatcher->forward(array(
            "controller" => "rw_users",
            "action" => "index"
        ));

    }

    /**
     * Deletes a rw_user
     *
     * @param string $usr_id
     */
    public function deleteAction($usr_id)
    {

        $rw_user = RwUsers::findFirstByusr_id($usr_id);
        if (!$rw_user) {
            $this->flash->error("rw_user was not found");

            return $this->dispatcher->forward(array(
                "controller" => "rw_users",
                "action" => "index"
            ));
        }

        if (!$rw_user->delete()) {

            foreach ($rw_user->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(array(
                "controller" => "rw_users",
                "action" => "search"
            ));
        }

        $this->flash->success("rw_user was deleted successfully");

        return $this->dispatcher->forward(array(
            "controller" => "rw_users",
            "action" => "index"
        ));
    }

}
