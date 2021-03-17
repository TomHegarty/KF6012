<?php
/**
* Creates a JSON response based on the parameters
* 
* @author Tom Hegarty 
*/
class JSONpage {
    private $page; 
    private $recordset;

    /**
    * function to sort correct response based on endpoint 
    * 
    * @param $pathArr - an array containing the route information
    */
    public function __construct($pathArr, $recordset) {
        $this->recordset = $recordset;
        $path = (empty($pathArr[1])) ? "api" : $pathArr[1];

        switch ($path) {
            case 'api':
                $this->page = $this->json_welcome();
                break;
            case 'authors':
                $this->page = $this->json_authors();
                break;
            case 'authorPres':
                $this->page = $this->json_authorPres();
                break; 
            case 'authorContent':
                $this->page = $this->json_authorContent();
                break;    
            case 'slots' : 
                $this->page = $this->json_slots();
                break; 
            case 'sessionpresentations' :
                $this->page = $this->json_sessionpresentations();
                break;
            case 'sessions':
                $this->page = $this->json_sessions();
                break;  
            case 'presentations':
                $this->page = $this->json_presentations();
                break;  
            case 'login':
                $this->page = $this->json_login();
                break;
            case 'update':
                $this->page = $this->json_update();
                break;
            case 'adduser':
                $this->page = $this->json_adduser();
                break;
            case 'search':
                $this->page = $this->json_search();
                break;
            default:
                $this->page = $this->json_error();
                break;
        }
    }

    private function sanitiseString($x) {
        return substr(trim(filter_var($x, FILTER_SANITIZE_STRING)), 0, 20);
    }
  
    private function sanitiseNum($x) {
        return filter_var($x, FILTER_VALIDATE_INT, array("options"=>array("min_range"=>0, "max_range"=>1000)));
    }

    /**
     * welcome endpoint, returns welcome mesage and list of all other endpoints
     * 
     */
    private function json_welcome() {
        $endpoints = array(
            "Authors"=>"http://unn-w16017590.newnumyspace.co.uk/kf6012/part1/api/authors", 
            "Presentations by Author"=>"http://unn-w16017590.newnumyspace.co.uk/kf6012/part1/api/authorPres", 
            "Content by Author"=>"http://unn-w16017590.newnumyspace.co.uk/kf6012/part1/api/authorContent", 
            "Slots"=>"http://unn-w16017590.newnumyspace.co.uk/kf6012/part1/api/slots", 
            "Presentations in a Session"=>"http://unn-w16017590.newnumyspace.co.uk/kf6012/part1/api/sessionpresentations", 
            "Sessions"=>"http://unn-w16017590.newnumyspace.co.uk/kf6012/part1/api/sessions",
            "Presentations"=>"http://unn-w16017590.newnumyspace.co.uk/kf6012/part1/api/presentations",
            "Login"=>"http://unn-w16017590.newnumyspace.co.uk/kf6012/part1/api/login",
            "Update"=>"http://unn-w16017590.newnumyspace.co.uk/kf6012/part1/api/update",
            "Add User"=>"http://unn-w16017590.newnumyspace.co.uk/kf6012/part1/api/adduser",
            "Search"=>"http://unn-w16017590.newnumyspace.co.uk/kf6012/part1/api/search",
            "Error"=>"http://unn-w16017590.newnumyspace.co.uk/kf6012/part1/api/error",
        );
        $msg = array("message"=>"welcome to CHI 2018 api! Details of each endpoint can be found at http://unn-w16017590.newnumyspace.co.uk/kf6012/part1/documentation/", "author"=>"Tom Hegarty", "aviable endpoints"=>$endpoints);
        return json_encode($msg);
    }

    private function json_error() {
        $msg = array("status"=>"400", "message"=>"error, bad request. check the documentation page or /api/ for available endpoints");
        return json_encode($msg);
    }

    private function array_push_assoc($array, $key, $value){
        $array[$key] = $value;
        return $array;
    }

    /**
     * function to return basic details of the author, can be paged
     *
     * @access private
     */
    private function json_authors() {
        $query  = "SELECT authorId, name FROM authors";
        $params = [];
        reset($_REQUEST);
        $key = key($_REQUEST);

        switch($key){
            case ('id'):
                $query .= " WHERE authorId = :term";
                $term = $this->sanitiseNum($_REQUEST['id']);
                $params = ["term" => $_REQUEST['id']];
            break;
            case ('search'):
                $params .= ["srch" => $_REQUEST['search']];
                $srch = $this->sanitiseString("%" . $_REQUEST['search'] . "%");
                $query .= (" WHERE name LIKE '").$srch."'";
            case ('page'):
                $params .= ["page" => $_REQUEST['page']];
                $query .= " ORDER BY name";
                $query .= " LIMIT 10 ";
                $query .= " OFFSET ";
                $query .= 10 * ($this->sanitiseNum($_REQUEST['page'])-1);
            break;
        }

        //return json_encode($query);
        return ($this->recordset->getJSONRecordSet($query, $params));
    }

    /**
     * function to return details of presentations for each author
     *   
     * gets all papers from an author
     * 
     * @access private
     * @return JSON results from query
     */
    private function json_authorPres(){
        $query = "SELECT authors.authorId, authors.name , content_authors.authorInst, content.title, content.abstract, content.award, slots.startHour, slots.startMinute, rooms.name AS roomName FROM authors INNER JOIN content_authors ON authors.authorId = content_authors.authorId INNER JOIN content ON content.contentId = content_authors.contentId INNER JOIN sessions_content ON sessions_content.contentId = content.contentId INNER JOIN sessions ON sessions.sessionId = sessions_content.sessionId INNER JOIN slots ON slots.slotId = sessions.slotId INNER JOIN rooms ON rooms.roomId = sessions.roomId";
        $params = [];
        $status = "400";
        $Ifsecond = false;

        if($_REQUEST['search']){
            $query .= " WHERE authors.name LIKE '%".$_REQUEST['search']."%'";
            $Ifsecond = true;
        }   

        if($_REQUEST['award']){
            if($Ifsecond == true){ 
                $query .= " AND "; 
            }else{
                $query .= " WHERE ";
            }
            $query .= "content.award LIKE '%".$_REQUEST['award']."%'";
        }

        $query .=  " GROUP BY authors.name ORDER BY authors.name";

        if($_REQUEST['page']){
            $query .= " LIMIT 10 ";
            $query .= " OFFSET ";
            $query .= 10 * ($this->sanitiseNum($_REQUEST['page'])-1);
        }

        return ($this->recordset->getJSONRecordSet($query, $params));
    }

    /**
     * slots, returns details of slot from a given day
     * 
     * @access private
     * @return JSON results from query
     */
    private function json_slots(){
        $query = "SELECT slots.slotId, slots.dayString AS 'Day', slots.dayInt, slots.type AS 'Type',slots.startHour, slots.startMinute, slots.endHour, slots.endMinute
                    FROM slots "
                    ;
        $params = [];
        $status = "400";

        reset($_REQUEST);
        $key = key($_REQUEST);

        switch($key){
            case('day'):
                $query .= " WHERE slots.dayInt = :term";
                $term = $this->sanitiseNum($_REQUEST['day']);
                $params = ["term" => $_REQUEST['day']];
                return ($this->recordset->getJSONRecordSet($query, $params));
            break;
            default:
                $query .= " WHERE slots.dayInt < 5";
                return ($this->recordset->getJSONRecordSet($query, $params));
            break;
        }
    }

    /**
     * author content, Returns details of the content for a specified author
     * 
     * @access private
     * @return JSON results from query
     */
    private function json_authorContent(){
        $query = "SELECT content.title, content.abstract, content.award, slots.startHour, slots.startMinute, slots.endHour, slots.endMinute, authors.name, authors.authorId, rooms.name AS 'roomName'
        FROM content
        INNER JOIN sessions_content ON sessions_content.contentId = content.contentId
        INNER JOIN sessions ON sessions.sessionId = sessions_content.sessionId
        INNER JOIN slots ON slots.slotID = sessions.slotId
        INNER JOIN content_authors ON content_authors.contentId = content.contentId
        INNER JOIN authors ON authors.authorId = content_authors.authorId
        INNER JOIN rooms ON rooms.roomId = Sessions.roomId";
        $params = [];
        $status = "400";

        reset($_REQUEST);
        $key = key($_REQUEST);

        switch($key){
            case('id'):
                $query .= " WHERE authors.authorId = :term";
                $term = $this->sanitiseNum($_REQUEST['id']);
                $params = ["term" => $_REQUEST['id']];
                return ($this->recordset->getJSONRecordSet($query, $params));
            break;
            default:
                return ($this->recordset->getJSONRecordSet($query, $params));
            break;
        }

    }


    /**
     * function to return details of a session when given the session ID 
     * 
     * @access private
     * @return JSON results from query
     */
    private function json_sessions(){
        $query = "SELECT sessions.name AS 'SessionName', sessions.sessionid, session_types.name AS 'SessionType', rooms.name AS 'RoomName',slots.startHour, slots.startMinute, slots.endHour, slots.endMinute, slots.type AS 'SlotType', authors.name AS 'SessionChair'
                FROM (((Sessions
                INNER JOIN session_types ON session_types.typeId = sessions.typeId)
                INNER JOIN slots ON slots.slotId = sessions.slotId)
                INNER JOIN authors ON authors.authorId = sessions.chairId)
                INNER JOIN rooms ON rooms.roomId = sessions.roomId";
        $params = [];
        $status = "400";

        reset($_REQUEST);
        $key = key($_REQUEST);

        switch($key){
            case('id'):
                $query .= " WHERE sessions.sessionId = :term";
                $term = $this->sanitiseNum($_REQUEST['Id']);
                $params = ["term" => $_REQUEST['Id']];
                
            break;
            default:
                return ($this->recordset->getJSONRecordSet($query, $params));
            break;
        }
    }


    /**
     * Returns Details about all presentations a specified author is involved in
     * 
     * @access private
     * @return JSON results from query
     */
    private function json_presentations(){
        $query = "SELECT session_types.name AS 'Type', sessions.name, rooms.name As 'Room', authors.name AS 'Chair', sessions.sessionId
        FROM sessions
        INNER JOIN rooms on rooms.roomId = sessions.roomId
        INNER JOIN session_types on session_types.typeId = sessions.typeId
        INNER JOIN slots on slots.slotId = sessions.slotId
        LEFT JOIN authors on authors.authorId = sessions.chairId
        INNER JOIN sessions_content on sessions_content.sessionId = sessions.sessionId";
        $params = [];
        $status = "400";

        reset($_REQUEST);
        $key = key($_REQUEST);

        switch($key){
            case('slotid'):
                $query .= " WHERE slots.slotid = :term GROUP BY sessions.name";
                $term = $this->sanitiseNum($_REQUEST['slotid']);
                $params = ["term" => $_REQUEST['slotid']];
                return ($this->recordset->getJSONRecordSet($query, $params));
            break;
            default:
                $msg = array("status" => "400", "message"=>"you must enter a slot id");
                return json_encode($msg);
            break;
        }
    }

    /**
     * Returns details of all presentations within a specified session
     * 
     * @access private 
     * @return JSON results from query
     */
    private function json_sessionpresentations(){
        $query = "SELECT content.title , content.abstract, GROUP_CONCAT(authors.name) AS 'authors', content.award, sessions.sessionId
        FROM content 
        INNER JOIN sessions_content on content.contentId = sessions_content.contentId
        INNER JOIN sessions on sessions.sessionId = sessions_content.sessionId
        INNER JOIN content_authors on content_authors.contentId = content.contentId
        INNER JOIN authors on authors.authorId = content_authors.authorId ";
        $params = [];
        $status = "400";

        reset($_REQUEST);
        $key = key($_REQUEST);

        switch($key){
            case('session_id'):
                $query .= " WHERE sessions.sessionId = :term
                GROUP BY content.title";
                $term = $this->sanitiseNum($_REQUEST['session_id']);
                $params = ["term" => $_REQUEST['session_id']];
                return ($this->recordset->getJSONRecordSet($query, $params));
            break;
            default:
                $msg = array("status" => "400", "message"=>"you must enter a session id");
                return json_encode($msg);
            break;
        }

    }


    /**
    * json_login used to verify if details are in database and if user is valid
    * 
    * @return JWT web token containing email, admin status, issued at time and expiry time
    */ 
    private function json_login() {
        $msg = "Invalid request. Username and password required";
        $status = "400";
        $token = null;
        $input = json_decode(file_get_contents("php://input"));
        $jwtkey = JWTKEY; 

      
        if (!is_null($input->email) && !is_null($input->password)) {  
        $query  = "SELECT username, admin, password FROM users WHERE email LIKE :email";
          $params = ['email'=>$input->email];
          $res = json_decode($this->recordset->getJSONRecordSet($query, $params),true);
      
          if (password_verify($input->password, $res['data'][0]['password'])) {
            $msg = "(api)User authorised. Welcome ". $res['data'][0]['firstname'] . " " . $res['data'][0]['lastname'];
            $status = "200";
            $token = array();
            $token['email'] = $input->email;
            $token['admin'] = $res['data'][0]['admin'];
            $token['iat'] = time();
            $token['exp'] = time() + (60 * 60); //1 hour
            $token = \Firebase\JWT\JWT::encode($token, $jwtkey);
          } else { 
            $msg = "username or password are invalid";
            $status = "401";
          }
        }
      
        return json_encode(array("status"=>$status, "token" => $token, "admin" => $res['data'][0]['admin']));
      }

     /**
     * json_update, updates name of session if user has valid token admin status
     * 
     * @return JSON response if update query was successful
     */ 
    private function json_update() {
        $input = json_decode(file_get_contents("php://input"));
        $jwtkey = JWTKEY;
    
        if (is_null($input->token)) {
            return json_encode(array("status" => 401, "message" => "Not authorised!"));
        }
        if (is_null($input->title) || is_null($input->sessionId)) {  
            return json_encode(array("status" => 400, "message" => "Invalid request"));
        }

        try {
            $tokenDecoded = \Firebase\JWT\JWT::decode($input->token, $jwtkey, array('HS256'));
            if ($tokenDecoded->admin == '0'){
                return json_encode(array("status" => 401, "message" => "Not authorised!, sign in as admin to update"));
            } else if ($tokenDecoded->admin == '1'){
                $query  = "UPDATE sessions SET name = :title WHERE sessionId = :sessionId";
                $params = ["title" => $input->title, "sessionId" => $input->sessionId];
                $res = $this->recordset->getJSONRecordSet($query, $params);    
                return json_encode(array("status" => 200, "message" => "ok", "updated id" => $input->sessionId));
            }
        }
            catch (UnexpectedValueException $e) {        
            return json_encode(array("status" => 401, "message" => $e->getMessage()));
        }
    }


    /**
    * json_add user
    * 
    * takes post requests and inserts new users into the users table, as non-admin user
    * @return JSON if adding user was successful 
    */ 
    private function json_adduser() {
        $msg = "Invalid request. Username and password and email required! username";
        $status = "400";
        $input = json_decode(file_get_contents("php://input")); 

        if (!is_null($input->username) && !is_null($input->email) && !is_null($input->password)) {  
            $query  = "INSERT INTO users (username, email, admin, password) VALUES ( :username , :email , 0 , :password )"; //new users will not be admins
            $password = password_hash($input->password, PASSWORD_DEFAULT);
            $params = ["username"=> $input->username, "email" => $input->email, "password" => $password];
            $msg = "new User created. Welcome " . $input->username;
            $status = "200";
            $res = json_decode($this->recordset->getJSONRecordSet($query, $params),true);
            return json_encode(array("status" => $status, "message" => $msg));
        } else {
            $status = "500";
            $msg = "error creating new user, perhaps name is already taken ";
            return json_encode(array("status"=> $status, "message"=>$msg));
        }
        
    }

    /**
    * used to search for presenatiosn and authors asoiacted with them 
    * 
    * @param name STRING from Request : search for authors containing this 
    * @param title STRING from Request : search for presenatation titles containing this  
    * @param page INT from Request : page of results to be returend
    * @return JSON results from query 
    */ 
    private function json_search() {
        $query = "SELECT authors.name, content.title, content.abstract, content.award, content.contentId FROM authors INNER JOIN content_authors ON content_authors.authorId = authors.authorId INNER JOIN content ON content.contentId = content_authors.contentId";
        $status = "400";
        $Ifsecond = false;

        if($_REQUEST['name']){
            $query .= " WHERE authors.name LIKE '%".$_REQUEST['name']."%'";
            $Ifsecond = true;
        }

        if($_REQUEST['title']){
            if($Ifsecond == true){$query .= " AND ";} else {$query .= " WHERE ";}
            $query .= " content.title LIKE '%".$_REQUEST['title']."%'";
        }

        if (isset($_REQUEST['page'])) {
            $query .= " ORDER BY content.title";
            $query .= " LIMIT 10 ";
            $query .= " OFFSET ";
            $query .= 10 * ($this->sanitiseNum($_REQUEST['page'])-1);
        }

        return ($this->recordset->getJSONRecordSet($query));
    }


    public function get_page() {
        return $this->page;
    }
}
?>