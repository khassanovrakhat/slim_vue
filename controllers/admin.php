<?php
    namespace Controllers;  
    use \Firebase\JWT\JWT;

    class AdminController {

    private $key = "secretkey";

    //Получать все клиеты
    public function register($request, $response, $args) {
        $body = (object) $request->getParsedBody();
        
        $name = $body->name;
        // print_r($name); exit();
        $last_name = $body->last_name;
        $patronymic = $body->patronymic;
        $password = SHA1($body->password);
        $hash = md5( rand(0,1000) );
        $email = $body->email;
        
        
        if (empty($name) || empty($last_name) || empty($patronymic) || empty($password) || empty($email)) {
            return $response->withJson(array('code' => 1, 'message' => 'Не полные данные'), 200);
        } else {
            $userRegister = SELECT("INSERT INTO admins (`name`, `last_name`, `patronymic`, `password`, `hash`, `email`) 
                                            VALUES ('$name', '$last_name', '$patronymic', '$password', '$hash', '$email')");
            // $to      = $email; // Send email to our user

            // $subject = 'Жүйеге | сілтеме'; // Give the email a subject 
            // $message = '
            
            // Спасибо за регистрацию!
            
            // ------------------------
            // Email: '.$email.'
            // TicketID: '.$uniqid.'
            // ------------------------
            
            // Что бы подтвердить регистрацию перейдите по ссылке:
            // http://support.edus.kz/api/login.php?email='.$email.'&hash='.$hash.'
            
            // '; // Our message above including the link
                                
            // $headers = 'Mediana' . "\r\n"; // Set from headers
            // mail($to, $subject, $message, $headers); // Send our email
            return $response->withJson(array('code' => 0, 'message' => 'Сәтті тіркеуден өттіңіз'), 200);
        }
    }

    //Получить клиента
    public function login($request, $response, $args) {
        $body = (object) $request->getParsedBody();
        $email = $body->email;
        $password = SHA1($body->password);

        if (empty($email) || empty($password)){
            return $response->withJson(array('code' => 1, 'message' => 'Не полные данные'), 200);
        } else{
            $auth = SELECT("SELECT * FROM admins WHERE `password` = '$password' AND `email` = '$email'");
            if($auth){
                $auth->code = 0;
                $_SESSION['adminId'] = $auth->id;
                $token = [
                    "iss" => "utopian",
                    "iat" => time(),
                    "exp" => time() + 60,
                    "data" => [
                    "user_id" => $auth->id
                ]];
                $jwt = JWT::encode($token, $this->key);
                return $response->withJson(array('code' => 0, 'message' => 'Сәтті тексеруден өттіңіз', 'token' => $jwt), 200);
            } 
            else return $response->withJson(array('code' => 2, 'message' => 'Не правильный логин или пароль'), 200);
        }
    }

    //Добавить клиента
    public function addVacancy($request, $response) {
        $body = (object) $request->getParsedBody();
        $jwt = $body->jwt;
        if(empty($jwt)){
            return $response->withJson(array(
                "message" => "Регистрация өткен жоқсыз",
                "code" => 1
            ));
        }
        $jwtDecode = JWT::decode($jwt, $this->key, array('HS256'));

        $title = $body->title;
        $description = $body->description;
        
        //вставка в ДБ
        $addVacancy = INSERT("INSERT INTO vacancy 
                    (`title`, `description`) 
                VALUES 
                    ('$title', '$description')");

        return $response->withJson(array(
            "message" => "Сәтті енгізілді",
            "code" => 0
        ));

    }

    // показать вакансии
    public function getViewVacancy($request, $response) {
        $body = (object) $request->getParsedBody();
        $jwt = $body->jwt;
        if(empty($jwt)){
            return $response->withJson(array(
                "message" => "Регистрация өткен жоқсыз",
                "code" => 1
            ));
        }
        
        $jwtDecode = JWT::decode($jwt, $this->key, array('HS256'));

        $viewVacancy = SELECT("SELECT * FROM vacancy");

        return $response->withJson(array(
            "message" => "Сәтті корсетілді",
            "code" => 0,
            "body" => $viewVacancy
        ));

    }

    //показать все резюме
    public function getCV($request, $response, $args) {
        $body = (object) $request->getParsedBody();
        $jwt = $body->jwt;
        if(empty($jwt)){
            return $response->withJson(array(
                "message" => "Регистрация өткен жоқсыз",
                "code" => 1
            ));
        }
        
        $jwtDecode = JWT::decode($jwt, $this->key, array('HS256'));
        // print_r($jwtDecode->data->user_id); exit();
        
        // $userId = $jwtDecode->data->user_id;
    
        $getCV = SELECT("SELECT * FROM `cv`");

        return $response->withJson(array(
            "message" => "Сәтті",
            "code" => 0,
            "result" => $getCV
        ));
    }
   
}
