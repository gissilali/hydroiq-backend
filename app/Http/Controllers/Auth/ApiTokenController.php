<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use http\Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Laravel\Passport\Exceptions\OAuthServerException;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Psr\Http\Message\ServerRequestInterface;

class ApiTokenController extends AccessTokenController
{
    public function issueToken(ServerRequestInterface $request)
    {
        $requestData = $request->getParsedBody();
        try {
            $username = isset($requestData['username']) ? $requestData['username'] : $requestData['email'];
            $user = Admin::where('email', '=', $username)->first();

            //generate token
            $tokenResponse = parent::issueToken($request);

            //convert response to json string
            $content = $tokenResponse->getContent();

            //convert json to array
            $data = json_decode($content, true);
            if(isset($data["error"])) {
                throw new OAuthServerException('The user credentials were incorrect.', 6, 'invalid_credentials', 401);
            }

            return response()->json([
                'user' => $user,
                'tokens' => $data
            ]);
        }
        catch (ModelNotFoundException $e) { // email notfound
            return response()->json([
                "message" => __("User not found")
            ], 404);
        }
        catch (OAuthServerException $e) { //password not correct..token not granted
            return response()->json([
                "message" => __("Invalid credentials")
            ], 422);
        }
        catch (\Exception $e) {
            return response()->json([
                "message" => "internal server error : - ".$e->getMessage()
            ], 500);
        }
    }
}
