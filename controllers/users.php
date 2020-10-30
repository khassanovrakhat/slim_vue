<?php
    namespace Controllers;
    use \Firebase\JWT\JWT;
    use Slim\Http\UploadedFile;
    
    function moveUploadedFile($directory, UploadedFile $uploadedFile)
    {
        $extension = $uploadedFile->getClientFilename();
        // $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
        $filename = sprintf($extension);

        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        return $filename;
    }

    class UsersController {
    private $key = "secretkey";

    //Получать все клиеты
    public function register($request, $response, $args) {
        $body = (object) $request->getParsedBody();
        $first_name = $body->first_name;
        $last_name = $body->last_name;
        $patronymic = $body->patronymic;
        $password = SHA1($body->password);
        $hash = md5( rand(0,1000) );
        $email = $body->email;
        
        if (empty($first_name) || empty($last_name) || empty($patronymic) || empty($password) || empty($email)){
            return $response->withJson(array('code' => 1, 'message' => 'Не полные данные'), 200);
        } else {
            $userRegister = SELECT("INSERT INTO users (`first_name`, `last_name`, `patronymic`, `password`, `hash`, `email`) 
                                            VALUES ('$first_name', '$last_name', '$patronymic', '$password', '$hash', '$email')");
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
            $auth = SELECT("SELECT * FROM users WHERE `password` = '$password' AND `email` = '$email'");
            if($auth){
                $auth->code = 0;
                $_SESSION['userId'] = $auth->id;
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

    //Создать резюме
    public function addCV($request, $response, $args) {
        $body = (object) $request->getParsedBody();
        $jwt = $body->jwt;
        if(empty($jwt)){
            return $response->withJson(array(
                "message" => "Регистрация өткен жоқсыз",
                "code" => 1
            ));
        }
        $jwtDecode = JWT::decode($jwt, $this->key, array('HS256'));
        
        $userId = $jwtDecode->data->user_id;
        $fullName = $body->fullName;
        $nationality = $body->nationality;
        $email = $body->email;
        $phone = $body->phone;
        $lBirth = $body->locationBirth;
        $dBirth  = $body->dateBirth;
        $address = $body->address;
        $education = $body->education;
        $work_experience = 	$body->work_experience;
        $languages = 	$body->languages;
        $skills = 	$body->skills;
        $additional_info = $body->additional_info;

        $addCV = INSERT("INSERT INTO cv 
            (`user_id`, `full_name`, `nationality`, `email`, `phone`, `lBirth`, `dBirth`, `address`, `education`, `work_experience`, `languages`, `skills`, `additional_info`) 
            VALUES 
            ('$userId', '$fullName', '$nationality', '$email', '$phone', '$lBirth', '$dBirth', '$address', '$education', '$work_experience', '$languages', '$skills', '$additional_info')");
            
        // if (empty($name) || empty($last_name) || empty($patronymic) || empty($password) || empty($email)){
        //     return $response->withJson(array('code' => 1, 'message' => 'Не полные данные'), 200);
        // } else {
        //     // $userRegister = SELECT("INSERT INTO users (`name`, `last_name`, `patronymic`, `password`, `hash`, `email`) 
        //     //                                 VALUES ('$name', '$last_name', '$patronymic', '$password', '$hash', '$email')");
        //     // $to      = $email; // Send email to our user

        //     // $subject = 'Жүйеге | сілтеме'; // Give the email a subject 
        //     // $message = '
            
        //     // Спасибо за регистрацию!
            
        //     // ------------------------
        //     // Email: '.$email.'
        //     // TicketID: '.$uniqid.'
        //     // ------------------------
            
        //     // Что бы подтвердить регистрацию перейдите по ссылке:
        //     // http://support.edus.kz/api/login.php?email='.$email.'&hash='.$hash.'
            
        //     // '; // Our message above including the link
                                
        //     // $headers = 'Mediana' . "\r\n"; // Set from headers
        //     // mail($to, $subject, $message, $headers); // Send our email
        //     return $response->withJson(array('code' => 0, 'message' => 'Сәтті тіркеуден өттіңіз'), 200);
        // }

        return $response->withJson(array(
            "message" => "Сәтті енгізілді",
            "code" => 0,
            "result" => $addCV
        ));
    }

    //Показать резюме
    public function getCV($request, $response, $args) {
        $body = (object) $request->getParsedBody();
        $jwt = $body->token;
        if(empty($jwt)){
            return $response->withJson(array(
                "message" => "Регистрация өткен жоқсыз",
                "code" => 1
            ));
        }
        
        $jwtDecode = JWT::decode($jwt, $this->key, array('HS256'));
        // print_r($jwtDecode->data->user_id); exit();
        
        $userId = $jwtDecode->data->user_id;
        // print_r($userId); exit();
    
        $getCV = SELECT("SELECT * FROM `cv` WHERE `user_id` = '$userId'");

        return $response->withJson(array(
            "message" => "Сәтті",
            "code" => 0,
            "result" => $getCV
        ));
    }
   
}

    